<?php
declare(strict_types=1);
namespace App\Entity\Std;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Controller\GetAddressListContoller;
use App\Dto\AdresseRead;
use App\Dto\AdresseWrite;
use App\Entity\Public\FederalState;
use App\Processor\AdresseDtoAddressEntiyProcessor;
use App\Provider\AddressEntityAdresseDtoProvider;
use App\Repository\std\AddressRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AddressRepository::class)]
#[ORM\Table(name: 'adresse', schema: 'std')]
#[ApiResource(operations: [
    new Get(
        uriTemplate: '/adresse/{id}',
        normalizationContext: ['groups' => 'read'],
        security: 'object.isBroker(user.getBroker().getId())',
        output: AdresseRead::class,
        provider: AddressEntityAdresseDtoProvider::class
    ),
    new GetCollection(
        uriTemplate: '/adresse',
        controller: GetAddressListContoller::class,
        normalizationContext: ['groups' => 'read'],
    ),
    new Post(
        uriTemplate: '/adresse',
        input: AdresseWrite::class,
        output: AdresseRead::class,
        processor: AdresseDtoAddressEntiyProcessor::class
    ),
    new Put(
        uriTemplate: '/adresse/{id}',
        security: 'object.isBroker(user.getBroker().getId())',
        input: AdresseWrite::class,
        processor: AdresseDtoAddressEntiyProcessor::class
    ),
    new Delete(
        uriTemplate: '/adresse/{id}',
        security: 'object.isBroker(user.getBroker().getId())'
    ),
],
    security: "is_granted('ROLE_BROKER')"
)]
class Address
{
    #[ORM\Id()]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    #[ORM\Column(name: 'adresse_id', type: 'integer', nullable: false)]
    private ?int $id = null;
    #[ORM\Column(name: 'strasse', type: 'string', nullable: true)]
    private ?string $street = null;
    #[ORM\Column(name: 'plz', type: 'string', length: 10, nullable: true)]
    private ?string $zip = null;
    #[ORM\Column(name: 'ort', type: 'string', nullable: true)]
    private ?string $city = null;
    #[ORM\ManyToOne(targetEntity: FederalState::class)]
    #[ORM\JoinColumn(name: 'bundesland', referencedColumnName: 'kuerzel')]
    private FederalState $federalState;
    /**
     * @var iterable|CustomerAddress[]
     */
    #[ORM\OneToMany(mappedBy: 'address', targetEntity: CustomerAddress::class, cascade: ['remove'])]
    private iterable $customerAddresses = [];

    public function __construct() {
        $this->customerAddresses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): Address
    {
        $this->id = $id;

        return $this;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(?string $street): Address
    {
        $this->street = $street;

        return $this;
    }

    public function getZip(): ?string
    {
        return $this->zip;
    }

    public function setZip(?string $zip): Address
    {
        $this->zip = $zip;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): Address
    {
        $this->city = $city;

        return $this;
    }

    public function getFederalState(): FederalState
    {
        return $this->federalState;
    }

    public function setFederalState(FederalState $federalState): Address
    {
        $this->federalState = $federalState;

        return $this;
    }

    /**
     * Check if the address is related to any customer of a broker
     *
     * @param int $brokerId
     * @return bool
     */
    public function isBroker(int $brokerId): bool
    {
        foreach ($this->customerAddresses as $customerAddress) {
            if ($customerAddress->getCustomer()?->getBroker()?->getId() === $brokerId) {
                return true;
            }
        }

        return false;
    }


}