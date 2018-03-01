<?php

namespace App\Command;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class AppDbImportFilesCommand extends Command
{
    protected static $defaultName = 'app:db:import-files';

    const IMPORT_FILE_OPTION_CSV = 'file_csv';
    const IMPORT_FILE_OPTION_P1 = 'file_p1';
    const IMPORT_FILE_OPTION_P2 = 'file_p2';
    const IMPORT_TABLE_USER = 'user';
    const IMPORT_TABLE_P1 = 'user_priority_one';
    const IMPORT_TABLE_P2 = 'user_priority_two';

    /**
     * @var EntityManagerInterface
     */
    private $em;
    private $dbCsvPath;
    private $dbP1Path;
    private $dbP2Path;

    /**
     * AppDbImportFilesCommand constructor.
     * @param null $name
     * @param EntityManagerInterface $em
     * @param $dbCsvPath
     * @param $dbP1Path
     * @param $dbP2Path
     */
    public function __construct($name = null, EntityManagerInterface $em, $dbCsvPath, $dbP1Path, $dbP2Path)
    {
        parent::__construct($name);

        $this->em = $em;
        $this->dbCsvPath = $this->normalizeFile($dbCsvPath);
        $this->dbP1Path = $this->normalizeFile($dbP1Path);
        $this->dbP2Path = $this->normalizeFile($dbP2Path);

        $this->em->getConfiguration()->setSQLLogger(null);
    }

    protected function configure()
    {
        $this
            ->setDescription('Importação dos arquivos csv e texto para o banco de dados');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $bar = new ProgressBar($output);
        $bar->start();
        $bar->setFormat('verbose_nomax');

        // *************** LIMPANDO AS TABELAS *************** //
        $this->truncateTable(self::IMPORT_TABLE_USER)
            ->truncateTable(self::IMPORT_TABLE_P1)
            ->truncateTable(self::IMPORT_TABLE_P2);
        $bar->advance();

        // *************** IMPORTAÇÃO DO ARQUIVO PRIORIDADE 1 *************** //
        $numRows = $this->importFile(self::IMPORT_FILE_OPTION_P1);
        $io->newLine();
        $io->writeln(' Importação arquivo Prioridade 1 finalizada, com total de ' . $numRows . ' registros importados.');
        $bar->advance();

        // *************** IMPORTAÇÃO DO ARQUIVO PRIORIDADE 2 *************** //
        $numRows = $this->importFile(self::IMPORT_FILE_OPTION_P2);
        $io->newLine();
        $io->writeln(' Importação arquivo Prioridade 2 finalizada, com total de ' . $numRows . ' registros importados.');
        $bar->advance();

        // *************** IMPORTAÇÃO DO CSV *************** //
        $numRows = $this->importFile(self::IMPORT_FILE_OPTION_CSV);
        $io->newLine();
        $io->writeln(' Importação arquivo CSV finalizada, com total de ' . $numRows . ' registros importados.');
        $bar->advance();

        $bar->finish();
    }

    private function normalizeFile($file)
    {
        return str_replace('\\', '/', $file);
    }

    private function importFile($option)
    {
        $file = '';
        $table = '';

        switch ($option) {
            case self::IMPORT_FILE_OPTION_CSV:
                $file = $this->dbCsvPath;
                $table = self::IMPORT_TABLE_USER;
                break;
            case self::IMPORT_FILE_OPTION_P1:
                $file = $this->dbP1Path;
                $table = self::IMPORT_TABLE_P1;
                break;
            case self::IMPORT_FILE_OPTION_P2:
                $file = $this->dbP2Path;
                $table = self::IMPORT_TABLE_P2;
                break;
        }

        $conn = $this->em->getConnection();

        $isCsv = function ($file) {
            return strstr(strtolower($file), '.csv');
        };

        $conn->exec(" ALTER TABLE " . $table . " DROP PRIMARY KEY ");

        /*if ($isCsv($file)) {
            $hasFullText = $conn->fetchAll("show index from " . $table . " where Index_type = 'FULLTEXT'");
            if (count($hasFullText) > 0) {
                $conn->exec(" ALTER TABLE " . $table . " DROP INDEX name ");
                $conn->exec(" ALTER TABLE " . $table . " DROP INDEX username ");
            }
        }*/

        $numRows = $conn->exec(" LOAD DATA LOCAL INFILE '" . $file . "' INTO TABLE " . $table . " FIELDS TERMINATED BY ',' LINES TERMINATED BY '\n' ");

        $conn->exec(" ALTER TABLE " . $table . " ADD PRIMARY KEY(id) ");

        if ($isCsv($file)) {
            $conn->exec(" ALTER TABLE " . $table . " ADD FULLTEXT (name) ");
            $conn->exec(" ALTER TABLE " . $table . " ADD FULLTEXT (username) ");
        }

        return $numRows;
    }

    private function truncateTable($table)
    {
        $truncate = $this->em->getConnection()->getDatabasePlatform()->getTruncateTableSQL($table);
        $this->em->getConnection()->executeUpdate($truncate);
        return $this;
    }
}
