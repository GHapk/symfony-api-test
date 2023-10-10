<?php
declare(strict_types=1);
namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;
class User
{
    #[Assert\NotBlank]
    #[Assert\Email]
    #[Assert\Length(min: 1, max: 200)]
    protected string $userName = '';
    #[Assert\Choice(options: [0,1])]
    protected int $active = 1;

    public function getUserName(): string
    {
        return $this->userName;
    }

    public function setUserName(string $userName): User
    {
        $this->userName = $userName;

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
}