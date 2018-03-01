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
            if ($installMode == 'dev') {
                $this->runProcess($this->getDevCommands(), $io);
            } else {
                $this->runProcess($this->getProdCommands(), $io);
            }
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

        $runningSubProccesses = [];
        $c = 0;
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

                if (!empty($command['subprocess'])) {

                    $runningSubProccesses[] = $process;
                    $process->start($callback);

                    sleep(5);

                    $subProcess = new Process($command['subprocess']);
                    $subProcess->setTimeout(3600);
                    $subProcess->start($callback);
                    $runningSubProccesses[] = $subProcess;

                    if (empty($command[($c + 1)])) {
                        $this->checkSubProcessFinished($runningSubProccesses);
                    }

                } else {
                    $process->mustRun($callback);
                }
            } catch (RuntimeException $exception) {
                $io->writeln($exception->getMessage());
            }
            $c++;
        }

        $io->newLine(2);
        $io->success('Instalação finalizada com sucesso.');
    }

    private function checkSubProcessFinished($activeProcesses)
    {
        while (count($activeProcesses)) {
            foreach ($activeProcesses as $i => $runningProcess) {
                if (!$runningProcess->isRunning()) {
                    unset($activeProcesses[$i]);
                }
                sleep(1);
            }
        }
    }

    private function getDevCommands()
    {
        return [
//            [
//                'command' => 'composer install',
//                'message' => 'Instalando dependências',
//            ],
            [
                'command' => 'php bin/console doctrine:database:create --if-not-exists',
                'message' => 'Criando banco de dados',
            ],
            [
                'command' => 'php bin/console doctrine:migrations:migrate -n',
                'message' => 'Executando migrações',
            ],
            [
                'command' => 'php bin/console hautelook:fixtures:load -n',
                'message' => 'Carregando fixtures',
            ],
            [
                'command' => 'php bin/console cache:clear',
                'message' => 'Limpando cache',
            ],
            [
                'command' => 'php bin/console app:db:import-files',
                'message' => 'Importando arquivos de banco (média de 10 min)',
            ],
            [
                'command' => 'php bin/console enqueue:consume --setup-broker',
                'message' => 'Populando elaticsearch',
                'subprocess' => 'php bin/console fos:elastica:populate --pager-persister=queue',
            ],
        ];
    }

    private function getProdCommands()
    {
        return [
//            [
//                'command' => 'composer install --no-dev --optimize-autoloader',
//                'message' => 'Instalando dependências',
//            ],
            [
                'command' => 'php bin/console doctrine:database:create --if-not-exists',
                'message' => 'Criando banco de dados',
            ],
            [
                'command' => 'php bin/console doctrine:migrations:migrate -n',
                'message' => 'Executando migrações',
            ],
            [
                'command' => 'php bin/console cache:clear --env=prod --no-debug',
                'message' => 'Setando cache para produção',
            ],
            [
                'command' => 'php bin/console app:auth:user-create neandher89@gmail.com 1234',
                'message' => 'Criação de Usuário de Acesso',
            ],
            //[
           //     'command' => 'php bin/console app:db:import-files',
             //   'message' => 'Importando arquivos de banco (média de 10 min)',
           // ],
            [
                'command' => 'php bin/console enqueue:consume --setup-broker --env=prod --no-debug',
                'message' => 'Populando elaticsearch',
                'subprocess' => 'php bin/console fos:elastica:populate --pager-persister=queue',
            ]
        ];
    }
}
