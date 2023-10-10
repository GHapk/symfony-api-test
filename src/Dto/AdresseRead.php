<?php
declare(strict_types=1);
namespace App\Dto;
class AdresseRead extends Adresse
{
    private ?AdressenDetails $details = null;

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