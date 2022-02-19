<?php

namespace App\Entity;

use App\Repository\OptionGuideRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=OptionGuideRepository::class)
 */
class OptionGuide
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="string", length=255)
     */
    private $Nom;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="string", length=255)
     */
    private $Prenom;

    /**
     * @ORM\Column(type="integer")
     */
    private $Tel;

    /**
     * @ORM\OneToMany(targetEntity=Programme::class, mappedBy="Guide")
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
        return $this->Nom;
    }

    public function setNom(string $Nom): self
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->Prenom;
    }

    public function setPrenom(string $Prenom): self
    {
        $this->Prenom = $Prenom;

        return $this;
    }

    public function getTel(): ?int
    {
        return $this->Tel;
    }

    public function setTel(int $Tel): self
    {
        $this->Tel = $Tel;

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
            $programme->setGuide($this);
        }

        return $this;
    }

    public function removeProgramme(programme $programme): self
    {
        if ($this->programme->removeElement($programme)) {
            // set the owning side to null (unless already changed)
            if ($programme->getGuide() === $this) {
                $programme->setGuide(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return (string) $this->getNom();
    }
}
