<?php

namespace AppBundle\Service;

/**
 * Class ConvertCsvToArray
 *
 *      import.csvtoarray:
 *          class: AppBundle\Service\ConvertCsvToArray
 *
 * @package AppBundle\Service
 */
class ConvertCsvToArray
{
    /**
     * @param $filename
     * @param string $delimiter
     * @param string $enclosure
     * @return array|bool
     */
    public function __invoke($filename, $delimiter = ',', $enclosure = '"')
    {
        $header = null;
        $data = array();
        if (($handle = fopen($filename, 'r')) !== false) {
            while (($row = fgetcsv($handle, 0, $delimiter, $enclosure)) !== false) {
                if (!$header) {
                    $header = $row;
                } else {
                    $data[] = array_combine($header, $row);
                }
            }
            fclose($handle);
        }

        return $data;
    }
}