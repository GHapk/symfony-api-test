<?php
declare(strict_types=1);
namespace App\Entity\Std;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'tbl_kunden', schema: 'std')]
class Customer
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    #[ORM\Column(name: 'id', type: 'integer', nullable: false)]
    private string $id;
    #[ORM\Column(name: 'name', type: 'string', length: 255, nullable: true)]
    private ?string $lastName;
    #[ORM\Column(name: 'vorname', type: 'string', length: 255, nullable: true)]
    private ?string $firstName;
    #[ORM\Column(name: 'firma', type: 'string', nullable: true)]
    private ?string $company;
    #[ORM\Column(name: 'geburtsdatum', type: 'datetime', nullable: true)]
    private ?\DateTime $birthday;
    #[ORM\Column(name: 'geloescht', type: 'boolean', nullable: true)]
    private bool $deleted = false;
    #[ORM\Column(name: 'geschlecht', type: 'string', nullable: true)]
    private ?string $gender;
    #[ORM\Column(name: 'email', type: 'string', nullable: true)]
    private ?string $email;
    #[ORM\ManyToOne(targetEntity: Broker::class, inversedBy: 'customers')]
    #[ORM\JoinColumn(name: 'vermittler_id', referencedColumnName: 'id')]
    private Broker $broker;

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): Customer
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

    public function isDeleted(): bool
    {
        return $this->deleted;
    }

    public function setDeleted(bool $deleted): Customer
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
}