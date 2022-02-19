<?php

namespace App\Entity;

use App\Repository\LogementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LogementRepository::class)
 */
class Logement
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     * @Assert\NotBlank(
     *     message="titre de logement est obligatoire"
     * )
     * 
     */
    private $titre;

    /**
     * @ORM\Column(type="text")
     * 
     * @Assert\NotBlank(
     *     message="description de logement est obligatoire"
     * )
     */
    private $description;

    /**
     * @ORM\Column(type="text")
     * 
     * @Assert\NotBlank(
     *     message="addresse de logement est obligatoire"
     * )
     * 
     */
    private $addresse;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="logements")
     * @ORM\JoinColumn(nullable=false)
     * 
     */
    private $hote;


    /**
     * @ORM\ManyToMany(targetEntity=Equipement::class, inversedBy="logements")
     */
    private $equipements;

  

    public function __construct()
    {
      
        $this->equipements = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getAddresse(): ?string
    {
        return $this->addresse;
    }

    public function setAddresse(string $addresse): self
    {
        $this->addresse = $addresse;

        return $this;
    }

    public function getHote(): ?User
    {
        return $this->hote;
    }

    public function setHote(?User $hote): self
    {
        $this->hote = $hote;

        return $this;
    }

    /**
     * @return Collection|Equipement[]
     */
    public function getEquipements(): Collection
    {
        return $this->equipements;
    }

    public function addEquipement(Equipement $equipement): self
    {
        if (!$this->equipements->contains($equipement)) {
            $this->equipements[] = $equipement;
        }

        return $this;
    }

    public function removeEquipement(Equipement $equipement): self
    {
        $this->equipements->removeElement($equipement);

        return $this;
    }


}
