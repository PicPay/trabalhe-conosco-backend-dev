<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\Table(name="user")
 * @Serializer\ExclusionPolicy("all")
 * @ORM\Cache(region="region_users")
 */
class User
{
    /**
     * @var integer
     *
     * @Serializer\Expose()
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @Serializer\Expose()
     * @ORM\Column(type="string")
     */
    protected $uuid;

    /**
     * @var string
     *
     * @Serializer\Expose()
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @var string
     *
     * @Serializer\Expose()
     * @ORM\Column(type="string")
     */
    private $username;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint", name="user_priority_id")
     */
    private $userPriority;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return User
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
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
     * @return User
     */
    public function setUuid(string $uuid): User
    {
        $this->uuid = $uuid;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return User
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return int
     */
    public function getUserPriority(): int
    {
        return $this->userPriority;
    }

    /**
     * @param int $userPriority
     * @return User
     */
    public function setUserPriority(int $userPriority): User
    {
        $this->userPriority = $userPriority;
        return $this;
    }
}