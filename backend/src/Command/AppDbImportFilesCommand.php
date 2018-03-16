<?php

namespace App\Command;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
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
    const IMPORT_TABLE_PRIORITY = 'user_priority';

    /**
     * @var EntityManagerInterface
     */
    private $em;
    private $conn;
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
        $this->conn = $this->getConn();
    }

    protected function configure()
    {
        $this
            ->setDescription('Importação dos arquivos csv e texto para o banco de dados');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        if (!$this->init($io)) {
            return;
        }

        $io->writeln('Arquivo prioridade 1...');
        $numRows = $this->importFile(self::IMPORT_FILE_OPTION_P1, $io);
        $io->writeln('Importação arquivo Prioridade 1 finalizada, com total de ' . $numRows . ' registros importados.');
        $io->newLine();

        $io->writeln('Arquivo prioridade 2...');
        $numRows = $this->importFile(self::IMPORT_FILE_OPTION_P2, $io);
        $io->writeln('Importação arquivo Prioridade 2 finalizada, com total de ' . $numRows . ' registros importados.');
        $io->newLine();

        $io->writeln('Arquivo csv... (Tempo estimado: 6 min) - ' . date('H:i:s'));
        $numRows = $this->importFile(self::IMPORT_FILE_OPTION_CSV, $io);
        $io->writeln('Importação arquivo CSV finalizada, com total de ' . $numRows . ' registros importados.');
        $io->newLine();

        $io->writeln('Adicionando índices... (Tempo estimado: 17 min) - ' . date('H:i:s'));
        $this->addIndexFullText($io);
        $io->newLine();

        $io->writeln('Finalizando... - ' . date('H:i:s'));
        $this->finish();
        $io->newLine();
    }

    private function normalizeFile($file)
    {
        return str_replace('\\', '/', $file);
    }

    private function importFile($option, SymfonyStyle $io)
    {
        $file = '';
        $level = 0;

        switch ($option) {
            case self::IMPORT_FILE_OPTION_CSV:
                $file = $this->dbCsvPath;
                break;
            case self::IMPORT_FILE_OPTION_P1:
                $file = $this->dbP1Path;
                $level = 1;
                break;
            case self::IMPORT_FILE_OPTION_P2:
                $file = $this->dbP2Path;
                $level = 2;
                break;
        }

        $isCsv = function ($file) {
            return strstr(strtolower($file), '.csv');
        };

        $io->writeln("Inserindo dados...");

        if ($isCsv($file)) {
            $numRows = $this->conn->exec("LOAD DATA LOCAL INFILE '" . $file . "' INTO TABLE " . self::IMPORT_TABLE_USER . " FIELDS TERMINATED BY ',' LINES TERMINATED BY '\n' (uuid,name,username)");
        } else {
            $numRows = $this->conn->exec("LOAD DATA LOCAL INFILE '" . $file . "' INTO TABLE " . self::IMPORT_TABLE_PRIORITY . " FIELDS TERMINATED BY ',' LINES TERMINATED BY '\n' (uuid) SET level = " . $level);
        }

        return $numRows;
    }

    private function addIndexFullText(SymfonyStyle $io)
    {
        $io->writeln('adicionando fulltext');
        $this->conn->exec(" ALTER TABLE `" . self::IMPORT_TABLE_USER . "` ADD FULLTEXT (`name`, `username`) ");
    }

    private function finish()
    {
        $this->conn->close();
    }

    private function getConn()
    {
        $this->em->getConfiguration()->setSQLLogger(null);
        return $this->em->getConnection();
    }

    private function init(SymfonyStyle $io)
    {
        $r = $this->conn->fetchAssoc("select count(id) as result_count from user");
        if ((int)$r['result_count'] > 0) {
            $io->comment('Registros já importados.');
            return false;
        }
        return true;
    }
}
