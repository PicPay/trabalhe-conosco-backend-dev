<?php
namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;
use Ramsey\Uuid\UuidInterface;

/**
 * Class User
 * @package App\Entity
 * @ORM\Entity()
 * @ORM\Table(name="user", indexes={
 *     @ORM\Index(columns={"name"}, flags={"fulltext"}),
 *     @ORM\Index(columns={"username"}, flags={"fulltext"},)
 * })
 */
class User implements JsonSerializable
{
    const PRIORITY_HIGH = 1;

    const PRIORITY_MEDIUM = 2;

    const PRIORITY_LOW = 3;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\Column(type="uuid")
     * @var UuidInterface
     */
    protected $id;

    /**
     * @ORM\Column()
     * @var string
     */
    protected $username;

    /**
     * @ORM\Column()
     * @var string
     */
    protected $name;

    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    protected $priority = 3;


    /**
     * User constructor.
     * @param UuidInterface $id
     * @param string $username
     * @param string $name
     * @param int $priority
     */
    public function __construct(UuidInterface $id, string $username, string $name, int $priority = self::PRIORITY_LOW)
    {
        $this->id = $id;
        $this->username = $username;
        $this->name = $name;
        $this->priority = $priority;
    }

    /**
     * @return UuidInterface
     */
    public function getId(): UuidInterface
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getPriority(): int
    {
        return $this->priority;
    }

    public function getPriorityLabel(): string
    {
        $names = [
            self::PRIORITY_LOW => 'Low',
            self::PRIORITY_MEDIUM => 'Medium',
            self::PRIORITY_HIGH => 'High',
        ];

        return $names[$this->priority];
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'username' => trim($this->username),
            'name' => $this->name,
            'priority' => [
                'id' => $this->priority,
                'name' => $this->getPriorityLabel(),
            ],
        ];
    }


}