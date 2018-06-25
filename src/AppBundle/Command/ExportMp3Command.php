<?php
namespace AppBundle\Command;

use AppBundle\Entity\TuneFile;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

/**
 * Export mp3 with intelligible names
 */
class ExportMp3Command extends ContainerAwareCommand
{
    protected $output;

    protected function configure()
    {
        $this
            // the name of the command (the part after "app/console")
            ->setName('il:export-mp3')

            // the short description shown while running "php app/console list"
            ->setDescription('Export MP3 with intelligible names')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->output = $output;

        // parcours des tunefiles
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $tuneFiles = $em->getRepository('AppBundle:TuneFile')->findAll();
        foreach ($tuneFiles as $tuneFile) {
            $this->exportFile($tuneFile);
        }
    }

    /**
     *
     * @param TuneFile $tuneFile
     */
    protected function exportFile(TuneFile $tuneFile)
    {
        if ($tuneFile->getFileName()) {
            $originFilePath = $this->getContainer()->getParameter('app.path.root_path').$this->getContainer()->getParameter('app.path.tune_file_path').'/'.$tuneFile->getFileName();

            $pathParts = pathinfo($originFilePath);
            if (isset($pathParts['extension']) &&  $pathParts['extension'] === 'mp3') {
                $normalizedName = $this->sanitize($tuneFile->getName(), true, true);
                $targetFilePath = $this->getContainer()->getParameter('app.path.root_path').$this->getContainer()->getParameter('app.path.export_mp3_path').'/'.$normalizedName.'.mp3';

                $fs = new Filesystem();

                try {
                    $this->output->writeln('copy "'.$originFilePath.'" to "'.$targetFilePath.'"');
                    $fs->copy($originFilePath, $targetFilePath);
                } catch (IOExceptionInterface $e) {
                    $this->output->writeln('<error>Error when copying at path "'.$e->getPath().'"</error>');
                }
            } else {
                $this->output->writeln($tuneFile->getFileName().' is not mp3 - Skip');
            }
        } else {
            $this->output->writeln($tuneFile->getName().' is not a file - Skip');
        }
    }

    /**
     *
     * @param type $string
     * @param type $forceLowercase
     * @param type $analyse
     * @return type
     */
    protected function sanitize($string, $forceLowercase = true, $analyse = false)
    {
        $strip = array("~", "`", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "_", "=", "+", "[", "{", "]",
                       "}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;",
                       "â€”", "â€“", ",", "<", ".", ">", "/", "?");
        $clean = trim(str_replace($strip, "", strip_tags($string)));
        $clean = preg_replace('/\s+/', "-", $clean);
        $clean = ($analyse) ? preg_replace("/[^a-zA-Z0-9]/", "", $clean) : $clean ;
        return ($forceLowercase) ?
            (function_exists('mb_strtolower')) ?
                mb_strtolower($clean, 'UTF-8') :
                strtolower($clean) :
            $clean;
    }
}
