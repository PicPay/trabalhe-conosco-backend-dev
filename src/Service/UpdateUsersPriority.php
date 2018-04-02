<?php
namespace App\Service;
use App\Repository\UserRepository;
use Symfony\Component\Finder\Finder;

/**
 * Class UpdateUsersPriority
 * @package App\Service
 */
class UpdateUsersPriority
{
    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * @var Finder
     */
    protected $finder;

    /**
     * UpdateUsersPriority constructor.
     * @param UserRepository $userRepository
     * @param Finder $finder
     */
    public function __construct(UserRepository $userRepository, Finder $finder)
    {
        $this->userRepository = $userRepository;
        $this->finder = $finder;
    }

    public function update()
    {
        $this->finder->in(__DIR__ . '/../Resources/listas-relevancia/')->name('*.txt');
        foreach ($this->finder as $file) {
            $priority = str_replace(['lista_relevancia_', '.txt'], '', $file->getFilename());
            $usersIds = explode(PHP_EOL, $file->getContents());
            $this->updateUsers($usersIds, $priority);
        }
    }

    protected function updateUsers(array $ids, int $priority)
    {
        $this->userRepository->updateUsersPriority($ids, $priority);
    }
}