<?php
declare(strict_types=1);
namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class Kunde
{
    private ?string $id = null;
    #[Assert\NotBlank]
    #[Assert\NotNull]
    private ?string $name = null;
    #[Assert\NotBlank]
    #[Assert\NotNull]
    private ?string $vorname = null;
    #[Assert\NotBlank]
    private ?string $firma = null;
    #[Assert\DateTime]
    #[Assert\NotNull]
    private ?\DateTime $geburtsdatum = null;
    #[Assert\NotBlank]
    private ?string $geschlecht = null;
    #[Assert\Email]
    #[Assert\NotNull]
    private ?string $email = null;
    #[Assert\GreaterThan(value: 0)]
    private ?int $vermittlerId = null;
    /**
     * @var iterable|Adresse[]
     */
    private array $adressen = [];
    private ?User $user = null;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(?string $id): Kunde
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): Kunde
    {
        $this->name = $name;

        return $this;
    }

    public function getVorname(): ?string
    {
        return $this->vorname;
    }

    public function setVorname(?string $vorname): Kunde
    {
        $this->vorname = $vorname;

        return $this;
    }

    public function getFirma(): ?string
    {
        return $this->firma;
    }

    public function setFirma(?string $firma): Kunde
    {
        $this->firma = $firma;

        return $this;
    }

    public function getGeburtsdatum(): ?\DateTime
    {
        return $this->geburtsdatum;
    }

    public function setGeburtsdatum(?\DateTime $geburtsdatum): Kunde
    {
        $this->geburtsdatum = $geburtsdatum;

        return $this;
    }

    public function getGeschlecht(): ?string
    {
        return $this->geschlecht;
    }

    public function setGeschlecht(?string $geschlecht): Kunde
    {
        $this->geschlecht = $geschlecht;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): Kunde
    {
        $this->email = $email;

        return $this;
    }

    public function getVermittlerId(): ?int
    {
        return $this->vermittlerId;
    }

    public function setVermittlerId(?int $vermittlerId): Kunde
    {
        $this->vermittlerId = $vermittlerId;

        return $this;
    }

    /**
     * @return Adresse[]
     */
    public function getAdressen(): iterable
    {
        return $this->adressen;
    }

    public function setAdressen(iterable $adressen): Kunde
    {
        $this->adressen = $adressen;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): Kunde
    {
        $this->user = $user;

        return $this;
    }
}