<?php

namespace App\Command;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\RuntimeException;

class AppInstallCommand extends Command
{
    protected static $defaultName = 'app:install';

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * AppInstallCommand constructor.
     * @param null $name
     * @param EntityManagerInterface $em
     */
    public function __construct($name = null, EntityManagerInterface $em)
    {
        parent::__construct($name);

        $this->em = $em;
        $this->em->getConfiguration()->setSQLLogger(null);
    }

    protected function configure()
    {
        $this
            ->setDescription('Instalação da aplicação')
            ->addOption('install-mode', 'im', InputArgument::OPTIONAL, 'Modo de instalação (dev ou prod)', 'dev');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $installMode = $input->getOption('install-mode');

        if ($installMode == 'dev' || $installMode == 'prod') {
            $this->runProcess($this->getCommands($installMode), $io);
        } else {
            $io->caution('Opção Inválida!');
        }
    }

    private function runProcess($commands, SymfonyStyle $io)
    {
        $callback = function ($type, $buffer) {
            if (Process::ERR === $type) {
                echo $buffer;
            } else {
                echo $buffer;
            }
        };

        foreach ($commands as $step => $command) {
            try {

                $io->newLine();
                $io->section(sprintf(
                    'Passo %d de %d. <info>%s</info>',
                    $step + 1,
                    count($commands),
                    $command['message']
                ));

                $process = new Process($command['command']);
                $process->setTimeout(3600);
                $process->mustRun($callback);

            } catch (RuntimeException $exception) {
                $io->writeln($exception->getMessage());
            }
        }

        $io->newLine(2);
        $io->success('Instalação finalizada com sucesso.');
    }

    private function getCommands($mode)
    {
        //composer install --no-dev --optimize-autoloader
        $cache = $mode == 'prod' ? ' --env=prod --no-debug' : '';
        return [
            [
                'command' => 'php bin/console cache:clear' . $cache, 'message' => 'Setando cache'
            ],
            [
                'command' => 'php bin/console doctrine:database:create --if-not-exists',
                'message' => 'Criando banco de dados',
            ],
            [
                'command' => 'php bin/console doctrine:migrations:migrate -n',
                'message' => 'Executando migrações',
            ],
            [
                'command' => 'php bin/console app:auth:user-create neandher89@gmail.com 1234',
                'message' => 'Criação de Usuário de Acesso',
            ],
            [
                'command' => 'php bin/console app:db:import-files',
                'message' => 'Importando arquivos de banco',
            ],
        ];
    }
}
