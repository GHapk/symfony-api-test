<?php
declare(strict_types=1);
namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;
class AdressenDetailsWrite extends AdressenDetails
{
    #[Assert\NotBlank]
    #[Assert\NotNull]
    private string $kundenId;

    public function getKundenId(): string
    {
        return $this->kundenId;
    }

    public function setKundenId(string $kundenId): AdressenDetailsWrite
    {
        $this->kundenId = $kundenId;

        return $this;
    }
}