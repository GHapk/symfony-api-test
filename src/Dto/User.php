<?php
declare(strict_types=1);
namespace App\Dto;

class User
{
    private string $userName = '';
    private ?string $passwort = null;
    private int $active = 1;
    private ?\DateTime $lastLogin = null;

    public function getUserName(): string
    {
        return $this->userName;
    }

    public function setUserName(string $userName): User
    {
        $this->userName = $userName;

        return $this;
    }

    public function getPasswort(): ?string
    {
        return $this->passwort;
    }

    public function setPasswort(?string $passwort): User
    {
        $this->passwort = $passwort;

        return $this;
    }

    public function getActive(): int
    {
        return $this->active;
    }

    public function setActive(int $active): User
    {
        $this->active = $active;

        return $this;
    }

    public function getLastLogin(): ?\DateTime
    {
        return $this->lastLogin;
    }

    public function setLastLogin(?\DateTime $lastLogin): User
    {
        $this->lastLogin = $lastLogin;

        return $this;
    }

}