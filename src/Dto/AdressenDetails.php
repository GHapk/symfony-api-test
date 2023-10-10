<?php
declare(strict_types=1);
namespace App\Dto;
class AdressenDetails
{
    private bool $geschaeftlich = false;
    private bool $rechnungsadresse = true;

    public function isGeschaeftlich(): bool
    {
        return $this->geschaeftlich;
    }

    public function setGeschaeftlich(bool $geschaeftlich): AdressenDetails
    {
        $this->geschaeftlich = $geschaeftlich;

        return $this;
    }

    public function isRechnungsadresse(): bool
    {
        return $this->rechnungsadresse;
    }

    public function setRechnungsadresse(bool $rechnungsadresse): AdressenDetails
    {
        $this->rechnungsadresse = $rechnungsadresse;

        return $this;
    }
}