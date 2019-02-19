<?php

namespace App\Service;

set_time_limit(0);

use App\Entity\User;
use Doctrine\ORM\EntityManager;
use App\Repository\UserRepository;

/**
 * Class UserImporter
 *
 * @package App\Service
 */
class UserImporter
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * @var string
     */
    protected $usersFilePath;

    /**
     * @var array
     */
    protected $priorityFilesPath;

    /**
     * UserImporter constructor.
     *
     * @param EntityManager $entityManager
     * @param UserRepository $userRepository
     * @param string $usersFilePath
     * @param string $priority1FilePath
     * @param string $priority2FilePath
     */
    public function __construct(EntityManager $entityManager, UserRepository $userRepository, string $usersFilePath, string $priority1FilePath, string $priority2FilePath)
    {
        $this->entityManager = $entityManager;
        $this->userRepository = $userRepository;
        $this->usersFilePath = $usersFilePath;
        $this->priorityFilesPath[] = $priority1FilePath;
        $this->priorityFilesPath[] = $priority2FilePath;
    }

    /**
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Exception
     */
    public function import(): void
    {
        $batchSize = 1000;

        if (($handle = \fopen($this->usersFilePath, "r")) !== FALSE) {
            $i = 0;
            while (($data = \fgetcsv($handle, 1000, ",")) !== FALSE) {
                $user = $this->build($data);
                $this->entityManager->persist($user);
                if (($i % $batchSize) === 0) {
                    $this->entityManager->flush();
                    $this->entityManager->clear();
                }
                ++$i;
            }
            \fclose($handle);
            $this->entityManager->flush();
            $this->entityManager->clear();
        }

        $priority = 0;
        foreach($this->priorityFilesPath as $priorityFilePath) {
            if (($handle = \fopen($priorityFilePath, "r")) !== FALSE) {
                $i = 0;
                while (($data = \fgetcsv($handle, 1000, ",")) !== FALSE) {
                    $user = $this->userRepository->findOneBy(['id' => $data]);
                    if($user instanceof User) {
                        $user->setPriority($priority);
                        $this->entityManager->persist($user);
                        if (($i % $batchSize) === 0) {
                            $this->entityManager->flush();
                            $this->entityManager->clear();
                        }
                        ++$i;
                    }
                }
                \fclose($handle);
                $this->entityManager->flush();
                $this->entityManager->clear();
                ++$priority;
            }
        }
    }

    /**
     * @param array $data User's data
     *
     * @return User
     * @throws \Exception
     */
    public function build(array $data): User
    {

        return new User(
            $data[0] ?? '',
            $data[1] ?? '',
            $data[2] ?? ''
        );
    }
}