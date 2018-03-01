<?php

namespace App\Entity;

use App\User\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserAuthRepository")
 * @ORM\Table(name="user_auth")
 * @Serializer\ExclusionPolicy("all")
 */
class UserAuth extends BaseUser
{
    /**
     * @var string
     *
     * @Serializer\Expose()
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return UserAuth
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
}