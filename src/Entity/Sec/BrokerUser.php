<?php
declare(strict_types=1);
namespace App\Entity\Sec;

use App\Entity\Std\Broker;
use \DateTime;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity()]
#[ORM\Table(name: 'vermittler_user', schema: 'sec')]
class BrokerUser extends User
{
    #[ORM\Id()]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    #[ORM\Column(name: 'id', type: 'integer', nullable: false)]
    private int $id = 0;
    #[ORM\Column(name: 'email', type: 'string', length:200, nullable: false)]
    private string $email = '';
    #[ORM\Column(name: 'passwd', type: 'string', length: 60, nullable: false)]
    private string $password = '';
    #[ORM\Column(name: 'aktiv', type: 'boolean', nullable: false)]
    private bool $active = false;
    #[ORM\Column(name: 'last_login', type: 'datetime', nullable: true)]
    private ?DateTime $lastLogin = null;
    #[ORM\OneToOne(targetEntity: Broker::class)]
    #[ORM\JoinColumn(name: 'vermittler_id', referencedColumnName: 'id')]
    public ?Broker $broker = null;

    public function __construct()
    {
        $this->broker = new Broker();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): BrokerUser
    {
        $this->id = $id;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): BrokerUser
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): BrokerUser
    {
        $this->password = $password;

        return $this;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function setActive(bool $active): BrokerUser
    {
        $this->active = $active;

        return $this;
    }

    public function getLastLogin(): ?DateTime
    {
        return $this->lastLogin;
    }

    public function setLastLogin(?DateTime $lastLogin): BrokerUser
    {
        $this->lastLogin = $lastLogin;

        return $this;
    }

    public function getBroker(): Broker
    {
        return $this->broker;
    }

    public function setBroker(Broker $broker): BrokerUser
    {
        $this->broker = $broker;

        return $this;
    }
}