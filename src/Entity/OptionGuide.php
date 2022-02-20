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
     * @Assert\NotBlank (message="le nom du guide est obligatoire")
     * @ORM\Column(type="string", length=255)
     *  *  * @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="Le titre ne doit pas contenir un chiffre")
     */
    private $Nom;

    /**
     * @Assert\NotBlank (message="le prenom du guide est obligatoire")
     * @ORM\Column(type="string", length=255)
     *  *  * @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="Le titre ne doit pas contenir un chiffre")
     */
    private $Prenom;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank (message="le prenom du guide est obligatoire")
    @Assert\Length(min = 8, max =8, minMessage = "le numéro de telephne doit contenir 8 chiffres",
     * maxMessage = "le numéro de telephne doit contenir 8 chiffres")
    @Assert\Regex(pattern="/^[0-9]*$/", message="chiffres seulement")
     *
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
