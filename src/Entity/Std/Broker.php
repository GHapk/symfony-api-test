<?php
declare(strict_types=1);
namespace App\Entity\Std;

use ApiPlatform\Metadata\ApiResource;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'vermittler', schema: 'std')]
class Broker
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    #[ORM\Column(name: 'id', type: 'integer', nullable: false)]
    private int $id;
    #[ORM\Column(name: 'nummer', type: 'string', length: 36, nullable: false)]
    private string $number;
    #[ORM\Column(name: 'vorname', type: 'string', length: 255, nullable: true)]
    private ?string $firstName;
    #[ORM\Column(name: 'nachname', type: 'string', length: 255, nullable: true)]
    private ?string $lastname;
    #[ORM\Column(name: 'firma', type: 'string', length: 255, nullable: true)]
    private ?string $company;
    #[ORM\Column(name: 'geloescht', type: 'boolean', nullable: false)]
    private bool $deleted = false;
    #[ORM\OneToMany(mappedBy: 'broker', targetEntity: Customer::class)]
    private Collection $customers;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): Broker
    {
        $this->id = $id;

        return $this;
    }

    public function getNumber(): string
    {
        return $this->number;
    }

    public function setNumber(string $number): Broker
    {
        $this->number = $number;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): Broker
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(?string $lastname): Broker
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getCompany(): ?string
    {
        return $this->company;
    }

    public function setCompany(?string $company): Broker
    {
        $this->company = $company;

        return $this;
    }

    public function isDeleted(): bool
    {
        return $this->deleted;
    }

    public function setDeleted(bool $deleted): Broker
    {
        $this->deleted = $deleted;

        return $this;
    }

    public function getCustomers(): Collection
    {
        return $this->customers;
    }

    public function setCustomers(Collection $customers): Broker
    {
        $this->customers = $customers;

        return $this;
    }
}