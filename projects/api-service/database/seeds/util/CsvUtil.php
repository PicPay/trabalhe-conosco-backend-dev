<?php

namespace Database\Util;

/**
 * Class CsvUtil
 * @package Database\Util
 */
class CsvUtil
{
    /**
     * @param string $table
     * @param string $filename
     * @param string $delimiter
     * @return array|bool
     */
    public function csv_to_array($table = 'user', $filename = '', $delimiter = ',')
    {
        if (!file_exists($filename) || !is_readable($filename)) {
            return FALSE;
        }

        $header = NULL;
        $data = array();
        if (($handle = fopen($filename, 'r')) !== FALSE) {
            while (($row = fgetcsv($handle, 100000, $delimiter)) !== FALSE) {
                if (!$header) {
                    $header = $this->resolveTableHeader($table);
                }

                $data[] = array_combine($header, $row);
            }
            fclose($handle);
        }

        return $data;
    }

    /**
     * @param $index
     * @return mixed
     */
    private function resolveTableHeader($index)
    {
        $array = [
            'user' => array('id', 'name', 'username'),
            'preference' => array('user_id')
        ];

        return $array[$index];
    }
}
