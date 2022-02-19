<?php

namespace App\Entity;

use App\Repository\ImageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ImageRepository::class)
 */
class Image
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
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $file;

    /**
     * @ORM\OneToMany(targetEntity=programme::class, mappedBy="image")
     */
    private $programme;

    public function __construct()
    {
        $this->programme = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getFile(): ?string
    {
        return $this->file;
    }

    public function setFile(string $file): self
    {
        $this->file = $file;

        return $this;
    }

    /**
     * @return Collection|programme[]
     */
    public function getProgramme(): Collection
    {
        return $this->programme;
    }

    public function addProgramme(programme $programme): self
    {
        if (!$this->programme->contains($programme)) {
            $this->programme[] = $programme;
            $programme->setImage($this);
        }

        return $this;
    }

    public function removeProgramme(programme $programme): self
    {
        if ($this->programme->removeElement($programme)) {
            // set the owning side to null (unless already changed)
            if ($programme->getImage() === $this) {
                $programme->setImage(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return (string) $this->getFile();
    }
}
