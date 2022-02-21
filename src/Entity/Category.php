<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank (message="le titre est obligatoire")
     * @ORM\Column(type="string", length=255)
     *  *  * @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="Le titre ne doit pas contenir un chiffre")
     */
    private $Titre;

    /**
     * @ORM\OneToMany(targetEntity=Programme::class, mappedBy="category")
     */
    private $programmes;

    public function __construct()
    {
        $this->programmes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->Titre;
    }

    public function setTitre(string $Titre): self
    {
        $this->Titre = $Titre;

        return $this;
    }

    /**
     * @return Collection|programme[]
     */
    public function getProgrammes(): Collection
    {
        return $this->programmes;
    }

    public function addProgramme(programme $programme): self
    {
        if (!$this->programmes->contains($programme)) {
            $this->programmes[] = $programme;
            $programme->setCategory($this);
        }

        return $this;
    }

    public function removeProgramme(programme $programme): self
    {
        if ($this->programmes->removeElement($programme)) {
            // set the owning side to null (unless already changed)
            if ($programme->getCategory() === $this) {
                $programme->setCategory(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return (string) $this->getTitre();
    }
}
