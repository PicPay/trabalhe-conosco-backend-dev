<?php

namespace App\Command;

use App\Service\ImportUsersFromCsv;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ImportUsersCommand
 * @package App\Command
 */
class ImportUsersCommand extends Command
{
    const DEFAULT_URL = 'https://s3.amazonaws.com/careers-picpay/users.csv.gz';

    /**
     * @var string
     */
    protected $varDir;

    /**
     * @var ImportUsersFromCsv
     */
    protected $importUsersFromCsv;

    /**
     * ImportUsersCommand constructor.
     * @param string $varDir
     * @param ImportUsersFromCsv $importUsersFromCsv
     */
    public function __construct(string $varDir, ImportUsersFromCsv $importUsersFromCsv)
    {
        $this->varDir = $varDir;
        $this->importUsersFromCsv = $importUsersFromCsv;
        parent::__construct();
    }


    protected function configure()
    {
        $this->setName('app:import-users')
            ->setDescription('Download and import users.')
            ->setHelp(
                sprintf('This command allow you import users from some CSV. The default url is %s', static::DEFAULT_URL)
            );
        $this->addArgument('csvUrl', InputArgument::OPTIONAL, 'Csv Url', static::DEFAULT_URL);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $queryStart  = microtime(true);

        $filename = $this->varDir . '/csv/users.csv.gz';

        if (!file_exists($filename)) {
            $this->fetchFile($input, $output, $filename);
        }

        $output->writeln("");
        $output->writeln('Arquivo pronto');
        $output->writeln('Extraindo arquivo.');

        $csvFilename = $this->extractFile($filename);
        $output->writeln('Importando dados de usuario para o banco de dados.');

        $this->importUsersFromCsv->import($csvFilename);

        $queryEnd  = microtime(true);
        $queryTime = round($queryEnd - $queryStart, 4);

        $output->writeln("  <comment>------------------------</comment>");
        $output->writeln(sprintf("  <info>++</info> finished in %ss", $queryTime));
    }

    protected function extractFile(string $filename): string
    {
        $outFileName = str_replace('.gz', '', $filename);

        if (file_exists($outFileName)) {
            return $outFileName;
        }

        $file = gzopen($filename, 'rb');
        $outFile = fopen($outFileName, 'wb');

        stream_copy_to_stream($file, $outFile);

        fclose($outFile);
        gzclose($file);

        return $outFileName;
    }

    protected function fetchFile(InputInterface $input, OutputInterface $output, string $filename)
    {
        $csvUrl = $input->getArgument('csvUrl');

        $progressBar = new ProgressBar($output, 100);

        $progress = function(
            $downloadTotal,
            $downloadedBytes,
            $uploadTotal,
            $uploadedBytes
        ) use($progressBar) {
            if (!is_numeric($downloadTotal) || 0 >= $downloadTotal ) {
                return;
            }

            $progressBar->setProgress( round($downloadedBytes/$downloadTotal*100, 0) );
        };

        $progressBar->start();
        $client = new \GuzzleHttp\Client();
        $response = $client->get($csvUrl, [
            'progress' => $progress,
            'sink' => $filename,
        ]);
        $progressBar->finish();

        unset($progressBar, $response, $client);
    }
}