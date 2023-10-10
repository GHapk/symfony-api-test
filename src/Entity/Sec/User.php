<?php
declare(strict_types=1);

namespace App\Entity\Sec;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Dto\UserWrite;
use App\Processor\UserDtoUserEntityProcessor;
use App\Provider\UserEntityUserDtoProvider;
use \DateTime;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Std\Customer;

#[ORM\Entity]
#[ORM\Table(name: 'user', schema: "sec")]
#[ApiResource(operations: [
    new Get(
        uriTemplate: '/user/{id}',
        provider: UserEntityUserDtoProvider::class
    ),
    new GetCollection(
        uriTemplate: '/user',
        provider: UserEntityUserDtoProvider::class
    ),
    new Post(
        uriTemplate: '/user',
        input: UserWrite::class,
        processor: UserDtoUserEntityProcessor::class
    ),
    new Put(
        uriTemplate: '/user/{id}',
        input: UserWrite::class,
        processor: UserDtoUserEntityProcessor::class
    ),
    new Delete(
        uriTemplate: '/user/{id}',
    ),
],
    security: "is_granted('ROLE_BROKER')"
)]
class User
{
    #[ORM\Id()]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    #[ORM\Column(name: 'id', type: 'integer', nullable: false, insertable: false, updatable: false)]
    private ?int $id = null;
    #[ORM\Column(name: 'email', type: 'string', length:200, nullable: false)]
    private string $email = '';
    #[ORM\Column(name: 'passwd', type: 'string', length: 60, nullable: false)]
    private string $password = '';
    #[ORM\OneToOne(mappedBy: null,  inversedBy: 'user', targetEntity: Customer::class)]
    #[ORM\JoinColumn(name: 'kundenid', referencedColumnName: 'id')]
    private ?Customer $customer;
    #[ORM\Column(name: 'aktiv', type: 'integer', nullable: false)]
    private int $active = 0;
    #[ORM\Column(name: 'last_login', type: 'datetime', nullable: true)]
    private ?DateTime $lastLogin;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): User
    {
        $this->id = $id;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): User
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): User
    {
        $this->password = $password;

        return $this;
    }

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): User
    {
        $this->customer = $customer;

        return $this;
    }

    public function isActive(): int
    {
        return $this->active;
    }

    public function setActive(int $active): User
    {
        $this->active = $active;

        return $this;
    }

    public function getLastLogin(): ?DateTime
    {
        return $this->lastLogin;
    }

    public function setLastLogin(?DateTime $lastLogin): User
    {
        $this->lastLogin = $lastLogin;

        return $this;
    }


}