<?php
declare(strict_types=1);
namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;
class UserWrite extends User
{
    #[Assert\Regex('/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/')]
    #[Assert\Length(min: 8, max: 60)]
    private ?string $passwort = null;

    #[Assert\NotBlank]
    private ?string $customerId = null;


    public function getPasswort(): ?string
    {
        return $this->passwort;
    }

    public function setPasswort(?string $passwort): User
    {
        $this->passwort = $passwort;

        return $this;
    }

    public function getCustomerId(): ?string
    {
        return $this->customerId;
    }

    public function setCustomerId(?string $customerId): UserWrite
    {
        $this->customerId = $customerId;

        return $this;
    }
}