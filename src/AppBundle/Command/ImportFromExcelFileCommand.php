<?php
namespace AppBundle\Command;

use AppBundle\Entity\Tune;
use AppBundle\Entity\TuneFile;
use AppBundle\Entity\TuneFileType;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Import tunes from excel file
 */
class ImportFromExcelFileCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            // the name of the command (the part after "app/console")
            ->setName('il:import-mtab')

            // the short description shown while running "php app/console list"
            ->setDescription('Import PDFs files from MandolinTab.net.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->output = $output;

        // recuperation de la liste des pdf dispo sur

        // TODO mettre ce qui suit dans un service
        $crawler = new Crawler();
        $crawler->add(file_get_contents(static::MANDOLINTABDOTNET_URL));

        //dump($crawler->html());

        $availablePdfs = $crawler->filter('a')->each(function (Crawler $node, $i) {
            return array(
                'href' => static::MANDOLINTABDOTNET_URL.$node->attr('href'),
                'name' => str_replace('.pdf', '', strtolower(trim(isset(explode('-', $node->text())[1]) ? explode('-', $node->text())[1] : ''))),
                'id' => trim(explode('-', $node->text())[0]),
            );
        });
        //$values = $crawler->filter('a')->extract(array('_text', 'href'));

        // parcours des tunes
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $tunes = $em->getRepository('AppBundle:Tune')->findAll();
        foreach ($tunes as $tune) {
            $this->importFile($tune, $availablePdfs);

        }

        $this->output->writeln('<info>Nombre de fichiers total recuperes : '.$this->countOk.'</info>');
        $this->output->writeln('<info>Nombre de fichiers total ignores/abandonne : '.$this->countKo.'</info>');
        $this->output->writeln('<info>Nombre de fichiers abandonnes car existants : '.$this->countAbandon.'</info>');
        $this->output->writeln('<info>Nombre de fichiers non trouves : '.$this->countNonTrouve.'</info>');
        $this->output->writeln('<info>Nombre de fichiers trouves x fois : '.$this->countTrouveX.'</info>');
    }

    /**
     *
     * @param Tune $tune
     * @param array $availablePdfs
     */
    protected function importFile(Tune $tune, $availablePdfs)
    {
        $normalizedName = $this->normalizeName($tune->getName());
        // recuperer 1 et 1 seul fichier available
        $available = $this->getOnlyOneAvailable($normalizedName, $availablePdfs);
        if ($available) {
            //  si aucun tunefile n'existe pour l'id => on cree le fichier
            $found = false;

            foreach ($tune->getTuneFiles() as $tuneFile) {
                /* @var $tuneFile \AppBundle\Entity\TuneFile */
                if ($tuneFile->getMandolinTabId() === $available['id']) {
                    $found = true;
                }
            }

            if (!$found) {
                // aucune tunefile trouve pour l'id mandolintab
                $this->output->writeln('<info>Telechargement du fichier '.$available['href'].'</info>');
                $this->createTuneFile($tune, $available);

                $this->countOk++;
            } else {
                $this->output->writeln('Le fichier a deja ete telecharge: abandon');
                $this->countKo++;
                $this->countAbandon++;
            }
        }
    }

    /**
     * Créé le TuneFile avec téléchargement du PDF depuis mandolintab
     * @param Tune $tune
     * @param type $available
     */
    protected function createTuneFile(Tune $tune, $available)
    {
        $filename = 'MT_'.str_replace(' ', '_', $available['name']).'.pdf';
        $path = $this->getContainer()->getParameter('app.path.root_path').$this->getContainer()->getParameter('app.path.tune_file_path').'/'.$filename;

        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $partitionType = $em->getRepository('AppBundle:TuneFileType')->findOneBy(array('id' => TuneFileType::TUNE_FILE_TYPE_PARTITION_ID));

        if (file_put_contents($path, fopen($available['href'], 'r'))) {
            $tuneFile = new TuneFile();
            $tuneFile
                ->setTuneFileType($partitionType)
                ->setName($available['name'])
                ->setMandolinTabId($available['id'])
                ->setTune($tune)
                ->setFileName($filename)
            ;

            $tune->addTuneFile($tuneFile);

            $em->persist($tune);
            $em->flush();
        } else {
            $this->output->writeln('<error>Le fichier '.$available['href'].' n\'a pas pu etre telecharge</error>');
        }
    }

    /**
     *
     * @param type $name
     * @param type $availablePdfs
     */
    protected function getOnlyOneAvailable($name, $availablePdfs)
    {
        $count = 0;
        $available = null;
        foreach ($availablePdfs as $availablePdf) {
            $availablePdfNormalized = $this->normalizeName($availablePdf['name']);
            if ($availablePdfNormalized === $name) {
                $count++;
                $available = $availablePdf;
            }
        }

        if ($count > 1) {
            $available = null;
            $this->output->writeln('<error>Le titre '.$name.' a ete trouve plus d\'une fois dans la liste des PDFs disponibles.</error>');
            $this->countKo++;
            $this->countTrouveX++;
        } elseif ($count === 0) {
            $this->output->writeln('<error>Le titre '.$name.' n\'a pas ete trouve dans la liste des PDFs disponibles.</error>');
            $this->countKo++;
            $this->countNonTrouve++;
        }

        return $available;
    }

    /**
     *
     * @param type $name
     * @return type
     */
    protected function normalizeName($name)
    {
        $name = strtolower($name);
        $name = str_replace('the', '', $name);
        $name = str_replace(',', '', $name);
        $name = trim($name);

        return $name;
    }
}