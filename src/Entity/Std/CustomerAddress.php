<?php
declare(strict_types=1);
namespace App\Entity\Std;

use App\Doctrine\Filter\SoftDeletableInterface;
use App\Repository\std\CustomerAddressRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CustomerAddressRepository::class)]
#[ORM\Table(name: 'kunde_adresse', schema: 'std')]
class CustomerAddress implements SoftDeletableInterface
{
    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Customer::class, inversedBy: 'customerAddresses')]
    #[ORM\JoinColumn(name: 'kunde_id', referencedColumnName: 'id', nullable: false)]
    private Customer $customer;
    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Address::class, inversedBy: 'customerAddresses')]
    #[ORM\JoinColumn(name: 'adresse_id', referencedColumnName: 'adresse_id', nullable: false)]
    private Address $address;
    #[ORM\Column(name: 'geschaeftlich', type: 'boolean', nullable: true)]
    private bool $commercial = false;
    #[ORM\Column(name: 'rechnungsadresse', type: 'boolean', nullable: true)]
    private bool $billingAddress = false;
    #[ORM\Column(name: 'geloescht', type: 'boolean', nullable: true)]
    private int $deleted = 0;

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

    public function isDeleted(): int
    {
        return $this->deleted;
    }

    public function setDeleted(int $deleted): CustomerAddress
    {
        $this->deleted = $deleted;

        return $this;
    }
}