<?php

namespace AppBundle\Service\ExcelTuneImport\Importer;

/**
 * Interface ExcelImporterInterface
 * @package AppBundle\Service\ExcelTuneImport\Importer
 */
interface ExcelImporterInterface
{
    /**
     * Get the name of the importer
     * @return string
     */
    public function getName();

    /**
     * TODO correct description
     * @param string $path
     * @param array $config
     * @return mixed
     */
    public function import($path, array $config);
}