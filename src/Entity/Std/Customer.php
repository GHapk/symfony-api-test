<?php
declare(strict_types=1);
namespace App\Entity\Std;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Controller\GetCustomerListController;
use App\Dto\Kunde;
use App\Entity\Sec\User;
use App\Processor\CustomerKundeProcessor;
use App\Provider\CustomerKundeProvider;
use App\Repository\std\CustomerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CustomerRepository::class)]
#[ORM\Table(name: 'tbl_kunden', schema: 'std')]
#[ApiResource(operations: [
        new Get(
            uriTemplate: '/kunden/{id}',
            security: 'object.getVermittlerId() == user.getId()'
        ),
        new GetCollection(
            uriTemplate: '/kunden',
            controller: GetCustomerListController::class,
            provider: CustomerKundeProvider::class,
        ),
        new Post(
            uriTemplate: '/kunden',
            input: Kunde::class,
            processor: CustomerKundeProcessor::class
        ),
        new Put(
            uriTemplate: '/kunden/{id}',
            security: 'object.getVermittlerId() == user.getId()',
            input: Kunde::class,
            processor: CustomerKundeProcessor::class
        ),
        new Delete(
            uriTemplate: '/kunden/{id}',
            security: 'object.getVermittlerId() == user.getId()'
        ),
    ],
    security: "is_granted('ROLE_BROKER')",
    provider: CustomerKundeProvider::class
)]
class Customer
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    #[ORM\Column(name: 'id', type: 'string', nullable: false)]
    private ?string $id = null;
    #[ORM\Column(name: 'name', type: 'string', length: 255, nullable: true)]
    private ?string $lastName = null;
    #[ORM\Column(name: 'vorname', type: 'string', length: 255, nullable: true)]
    private ?string $firstName = null;
    #[ORM\Column(name: 'firma', type: 'string', nullable: true)]
    private ?string $company = null;
    #[ORM\Column(name: 'geburtsdatum', type: 'datetime', nullable: true)]
    private ?\DateTime $birthday = null;
    #[ORM\Column(name: 'geloescht', type: 'integer', nullable: true)]
    private int $deleted = 0;
    #[ORM\Column(name: 'geschlecht', type: 'string', nullable: true)]
    private ?string $gender = null;
    #[ORM\Column(name: 'email', type: 'string', nullable: true)]
    private ?string $email = null;
    #[ORM\ManyToOne(targetEntity: Broker::class, inversedBy: 'customers')]
    #[ORM\JoinColumn(name: 'vermittler_id', referencedColumnName: 'id')]
    private ?Broker $broker = null;
    #[ORM\OneToOne(mappedBy: 'customer', inversedBy: null, targetEntity: User::class)]
    private ?User $user = null;
    /**
     * @var CustomerAddress[]|Collection|null
     */
    #[ORM\OneToMany(mappedBy: 'customer', targetEntity: CustomerAddress::class)]
    private iterable|null $customerAddresses;

    public function __construct() {
        $this->customerAddresses = new ArrayCollection();
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(?string $id): Customer
    {
        $this->id = $id;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): Customer
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): Customer
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getCompany(): ?string
    {
        return $this->company;
    }

    public function setCompany(?string $company): Customer
    {
        $this->company = $company;

        return $this;
    }

    public function getBirthday(): ?\DateTime
    {
        return $this->birthday;
    }

    public function setBirthday(?\DateTime $birthday): Customer
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function isDeleted(): int
    {
        return $this->deleted;
    }

    public function setDeleted(int $deleted): Customer
    {
        $this->deleted = $deleted;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(?string $gender): Customer
    {
        $this->gender = $gender;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): Customer
    {
        $this->email = $email;

        return $this;
    }

    public function getBroker(): Broker
    {
        return $this->broker;
    }

    public function setBroker(Broker $broker): Customer
    {
        $this->broker = $broker;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): Customer
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return CustomerAddress[]|Collection|null
     */
    public function getCustomerAddresses(): ?iterable
    {
        return $this->customerAddresses;
    }

    public function setCustomerAddresses(?iterable $customerAddresses): Customer
    {
        $this->customerAddresses = $customerAddresses;

        return $this;
    }

    public function getCustomerAddressByAddressIdAndCustomerId(?int $addressId, ?string $customerId): ?CustomerAddress {
        if (null === $customerId || null === $addressId) {
            return null;
        }

        foreach ($this->getCustomerAddresses() as $customerAddress) {
            if (
                $customerAddress->getCustomer()->getId() === $customerId &&
                $customerAddress->getAddress()->getI === $addressId
            ) {
                return $customerAddress;
            }
        }

        return null;
    }
}