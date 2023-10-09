<?php
declare(strict_types=1);
namespace App\Entity\Std;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Controller\GetCustomerAddressListController;
use App\Dto\Adresse;
use App\Provider\CustomerAddressAdresseProvider;
use App\Repository\std\CustomerAddressRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CustomerAddressRepository::class)]
#[ORM\Table(name: 'kunde_adresse', schema: 'std')]
#[ApiResource(operations: [
    new Get(
        uriTemplate: '/adresse/{id}',
        security: 'object.getCustomer().getVermittlerId() == user.getId()'
    ),
    new GetCollection(
        uriTemplate: '/adresse',
        controller: GetCustomerAddressListController::class,
    ),
    new Post(
        uriTemplate: '/adresse',
        input: Adresse::class,
        processor: CustomerAddressAdresseProvider::class
    ),
    new Put(
        uriTemplate: '/adresse/{id}',
        security: 'object.getCustomer().getVermittlerId() == user.getId()',
        input: Adresse::class,
        processor: CustomerAddressAdresseProvider::class
    ),
    new Delete(
        uriTemplate: '/adresse/{id}',
        security: 'object.getCustomer().getVermittlerId() == user.getId()'
    ),
],
    security: "is_granted('ROLE_BROKER')"
)]
class CustomerAddress
{
    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Customer::class, inversedBy: 'customerAddresses')]
    #[ORM\JoinColumn(name: 'kunde_id', referencedColumnName: 'id', nullable: false)]
    private Customer $customer;
    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Address::class)]
    #[ORM\JoinColumn(name: 'adresse_id', referencedColumnName: 'adresse_id', nullable: false)]
    private Address $address;
    #[ORM\Column(name: 'geschaeftlich', type: 'boolean', nullable: true)]
    private bool $commercial = false;
    #[ORM\Column(name: 'rechnungsadresse', type: 'boolean', nullable: true)]
    private bool $billingAddress = false;
    #[ORM\Column(name: 'geloescht', type: 'boolean', nullable: true)]
    private bool $deleted = false;

    public function getCustomer(): Customer
    {
        return $this->customer;
    }

    public function setCustomer(Customer $customer): CustomerAddress
    {
        $this->customer = $customer;

        return $this;
    }

    public function getAddress(): Address
    {
        return $this->address;
    }

    public function setAddress(Address $address): CustomerAddress
    {
        $this->address = $address;

        return $this;
    }

    public function isCommercial(): bool
    {
        return $this->commercial;
    }

    public function setCommercial(bool $commercial): CustomerAddress
    {
        $this->commercial = $commercial;

        return $this;
    }

    public function isBillingAddress(): bool
    {
        return $this->billingAddress;
    }

    public function setBillingAddress(bool $billingAddress): CustomerAddress
    {
        $this->billingAddress = $billingAddress;

        return $this;
    }

    public function isDeleted(): bool
    {
        return $this->deleted;
    }

    public function setDeleted(bool $deleted): CustomerAddress
    {
        $this->deleted = $deleted;

        return $this;
    }
}