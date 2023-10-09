<?php
declare(strict_types=1);
namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class Adresse
{
    private ?int $adresseId = null;
    #[Assert\NotNull]
    #[Assert\NotBlank]
    private string $stasse = '';
    #[Assert\NotNull]
    #[Assert\NotBlank]
    private ?string $plz = '';
    #[Assert\NotNull]
    #[Assert\NotBlank]
    private string $ort = '';
    #[Assert\NotNull]
    #[Assert\NotBlank]
    private string $bundesland = '';
    private ?AdressenDetails $details = null;

    public function getAdresseId(): ?int
    {
        return $this->adresseId;
    }

    public function setAdresseId(?int $adresseId): Adresse
    {
        $this->adresseId = $adresseId;

        return $this;
    }

    public function getStasse(): string
    {
        return $this->stasse;
    }

    public function setStasse(string $stasse): Adresse
    {
        $this->stasse = $stasse;

        return $this;
    }

    public function getPlz(): string
    {
        return $this->plz;
    }

    public function setPlz(?string $plz): Adresse
    {
        $this->plz = $plz;

        return $this;
    }

    public function getOrt(): string
    {
        return $this->ort;
    }

    public function setOrt(string $ort): Adresse
    {
        $this->ort = $ort;

        return $this;
    }

    public function getBundesland(): string
    {
        return $this->bundesland;
    }

    public function setBundesland(string $bundesland): Adresse
    {
        $this->bundesland = $bundesland;

        return $this;
    }

    public function getDetails(): ?AdressenDetails
    {
        return $this->details;
    }

    public function setDetails(?AdressenDetails $details): Adresse
    {
        $this->details = $details;

        return $this;
    }


}