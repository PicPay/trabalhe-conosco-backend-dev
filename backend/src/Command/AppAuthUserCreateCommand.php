<?php

namespace App\Command;

use App\Entity\UserAuth;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AppAuthUserCreateCommand extends Command
{
    protected static $defaultName = 'app:auth:user-create';
    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * AppAuthUserCreateCommand constructor.
     * @param null $name
     * @param EntityManagerInterface $em
     */
    public function __construct($name = null, EntityManagerInterface $em, ValidatorInterface $validator)
    {
        parent::__construct($name);
        $this->em = $em;
        $this->validator = $validator;
    }

    protected function configure()
    {
        $this
            ->setDescription('Criação de usuário de acesso.')
            ->setDefinition(array(
                new InputArgument('email', InputArgument::REQUIRED, 'The email'),
                new InputArgument('password', InputArgument::REQUIRED, 'The password'),
            ))
            ->setHelp('Comando para criação de usuário de acesso.');;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $email = $input->getArgument('email');
        $password = $input->getArgument('password');

        $userAuth = new UserAuth();
        $userAuth
            ->setName($email)
            ->setEmail($email)
            ->setPlainPassword($password);

        $this->em->persist($userAuth);

        /** @var ConstraintViolationListInterface $errors */
        $errors = $this->validator->validate($userAuth);
        if ($errors->count() > 0) {
            foreach ($errors as $error) {
                $io->comment($error->getMessage());
            }
            return;
        }

        $this->em->flush();
        $io->success(sprintf('Usuário <comment>%s</comment> criado.', $email));
    }

    /**
     * @inheritDoc
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {
        $questions = array();
        if (!$input->getArgument('email')) {
            $question = new Question('Por favor, digite um e-mail:');
            $question->setValidator(function ($email) {
                if (empty($email)) {
                    throw new \Exception('Email não pode ser vazio');
                }
                return $email;
            });
            $questions['email'] = $question;
        }
        if (!$input->getArgument('password')) {
            $question = new Question('Por favor, digite umm senha:');
            $question->setValidator(function ($password) {
                if (empty($password)) {
                    throw new \Exception('Senha não pode ser vazia');
                }
                return $password;
            });
            $question->setHidden(true);
            $questions['password'] = $question;
        }
        foreach ($questions as $name => $question) {
            $answer = $this->getHelper('question')->ask($input, $output, $question);
            $input->setArgument($name, $answer);
        }
    }
}
