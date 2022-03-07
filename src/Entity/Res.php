<?php

namespace App\Entity;

use App\Repository\ResRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ResRepository::class)
 */
class Res
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $s;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getS(): ?string
    {
        return $this->s;
    }

    public function setS(string $s): self
    {
        $this->s = $s;

        return $this;
    }
}
