<?php
declare(strict_types=1);

namespace App\Entity\Public;


use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'bundesland', schema:"public")]
class FederalState
{
    #[ORM\Column(name:"kuerzel", type:"string", length:2, nullable:false)]
    #[ORM\Id()]
    #[ORM\GeneratedValue(strategy: "NONE")]
    private string $short = '';

    #[ORM\Column(name:"name", type:"string", nullable:false)]
    private string $name = '';

    public function getShort(): string
    {
        return $this->short;
    }

    public function setShort(string $short): FederalState
    {
        $this->short = $short;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): FederalState
    {
        $this->name = $name;

        return $this;
    }
}