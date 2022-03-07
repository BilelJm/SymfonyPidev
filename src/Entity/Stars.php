<?php

namespace App\Entity;

use App\Repository\StarsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StarsRepository::class)
 */
class Stars
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $ratedIndex;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRatedIndex(): ?int
    {
        return $this->ratedIndex;
    }

    public function setRatedIndex(?int $ratedIndex): self
    {
        $this->ratedIndex = $ratedIndex;

        return $this;
    }
}
