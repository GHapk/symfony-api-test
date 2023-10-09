<?php
declare(strict_types=1);
namespace App\Entity\Std;

use ApiPlatform\Metadata\ApiResource;
use App\Entity\Public\FederalState;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity()]
#[ORM\Table(name: 'adresse', schema: 'std')]
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


}