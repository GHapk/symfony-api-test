<?php
declare(strict_types=1);
namespace App\Dto;
class KundeRead extends Kunde
{
    /**
     * @var iterable|Adresse[]
     */
    private array $adressen = [];
    private ?User $user = null;

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