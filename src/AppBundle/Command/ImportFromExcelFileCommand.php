<?php
namespace AppBundle\Command;

use AppBundle\Service\ExcelTuneImport\ExcelImportTuneManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Import tunes from excel file
 * Ex: php bin/console il:import-tunes-excel OneWorksheetPerTypeOneTuneFileExcelImporter "/home/xxx/Téléchargements/Tunes.xlsx" my_conf -v
 */
class ImportFromExcelFileCommand extends Command
{
    private $excelImportTuneManager;
    private $importersConfigurations;

    public function __construct(ExcelImportTuneManager $excelImportTuneManager, array $importersConfigurations)
    {
        $this->excelImportTuneManager = $excelImportTuneManager;
        $this->importersConfigurations = $importersConfigurations;

        parent::__construct();
    }

    protected function configure()
    {
        $importerList = $this->excelImportTuneManager->getImportersNameList();
        $this
            ->setName('il:import-tunes-excel')
            ->setDescription('Import tunes from excel file')
            ->setHelp('Available importers are : '.join(', ', $importerList))
            ->addArgument('importer', InputArgument::REQUIRED, 'The importer to use.')
            ->addArgument('path', InputArgument::REQUIRED, 'The excel file path.')
            ->addArgument('configKey', InputArgument::REQUIRED, 'The config key found in config/specificImporterConfig.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (!isset($this->importersConfigurations[$input->getArgument('configKey')])) {
            throw new \LogicException($input->getArgument('configKey').' is not a known importer config. Did you created it in config/specificImporterConfig, and did youcorrectly spelled its name ?');
        }
        $config = $this->importersConfigurations[$input->getArgument('configKey')];
        $this->excelImportTuneManager->getImporterByName($input->getArgument('importer'))->import($input->getArgument('path'), $config);
        // recuperation de la liste des pdf dispo sur

        //$this->output->writeln('<info>Nombre de fichiers total recuperes : '.$this->countOk.'</info>');
    }
}