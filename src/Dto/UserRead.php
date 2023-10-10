<?php
declare(strict_types=1);
namespace App\Dto;

class UserRead extends User
{
    protected ?\DateTime $lastLogin = null;

    public function getLastLogin(): ?\DateTime
    {
        return $this->lastLogin;
    }

    public function setLastLogin(?\DateTime $lastLogin): UserRead
    {
        $this->lastLogin = $lastLogin;

        return $this;
    }
}