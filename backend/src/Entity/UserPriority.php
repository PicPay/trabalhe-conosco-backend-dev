<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PriorityRepository")
 * @ORM\Table(name="user_priority")
 * @Serializer\ExclusionPolicy("all")
 * @ORM\Cache()
 */
class UserPriority
{

    /**
     * @var integer
     *
     * @Serializer\Expose()
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     *
     * @Serializer\Expose()
     * @ORM\Column(type="string")
     */
    private $uuid;

    /**
     * @var integer
     *
     * @ORM\Column(type="smallint")
     * @Serializer\Expose()
     */
    private $level;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }

    /**
     * @param string $uuid
     * @return UserPriority
     */
    public function setUuid(string $uuid): UserPriority
    {
        $this->uuid = $uuid;
        return $this;
    }

    /**
     * @return int
     */
    public function getLevel(): int
    {
        return $this->level;
    }

    /**
     * @param int $level
     * @return UserPriority
     */
    public function setLevel(int $level): UserPriority
    {
        $this->level = $level;
        return $this;
    }
}