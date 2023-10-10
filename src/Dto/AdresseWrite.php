<?php
declare(strict_types=1);
namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;
class AdresseWrite extends Adresse
{
    #[Assert\NotNUll]
    private ?AdressenDetailsWrite $details = null;
    
    public function getDetails(): ?AdressenDetailsWrite
    {
        return $this->details;
    }

    public function setDetails(?AdressenDetailsWrite $details): Adresse
    {
        $this->details = $details;

        return $this;
    }
}