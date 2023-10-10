<?php
declare(strict_types=1);
namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class Kunde
{
    protected ?string $id = null;
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\Length(max: 255)]
    protected ?string $name = null;
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\Length(max: 255)]
    protected ?string $vorname = null;
    #[Assert\NotBlank]
    protected ?string $firma = null;
    #[Assert\NotNull]
    #[Assert\Date]
    protected ?\DateTime $geburtsdatum = null;
    #[Assert\NotNull]
    #[Assert\Choice(choices: ['männlich', 'weiblich', 'divers'])]
    protected ?string $geschlecht = null;
    #[Assert\Email]
    #[Assert\NotNull]
    protected ?string $email = null;
    #[Assert\GreaterThan(value: 0)]
    protected ?int $vermittlerId = null;
    protected int $geloescht = 0;

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

    public function getGeloescht(): int
    {
        return $this->geloescht;
    }

    public function setGeloescht(int $geloescht): Kunde
    {
        $this->geloescht = $geloescht;

        return $this;
    }
}