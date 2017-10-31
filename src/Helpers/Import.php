<?php

namespace Helper\Import;

/**
 * Class Import
 * @package Helper
 */
class Import
{
    /**
     * @param resource $file
     * @param string $search
     * @return array
     */
    public function getResultado(resource $file, string $search)
    {
        $resultado = [];
        $i = 0;

        while (!feof($file)) {

            $i++;

            $linha = fgetcsv($file);

            if (!is_array($linha)) {
                continue;
            }

            foreach ($linha as $item) {

                if ($i > 30) {
                    //exit;
                }

                if (!stristr($item, $search)) {
                    continue;
                }

                $resultado[$i] = $linha;
            }
        }

        fclose($file);

        return $resultado;
    }
}