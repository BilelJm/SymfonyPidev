<?php

namespace App\Entity;

use App\Repository\ProgrammeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ProgrammeRepository::class)
 */
class Programme
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank (message="le titre de proggramme est obligatoire")
     *  * @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="Le titre ne doit pas contenir un chiffre")
     *   * @Assert\Length(
     *      min = 10,
     *      max = 15,
     *      minMessage = "Le titre doit contenir au moins {{ limit }} caractéres",
     *      maxMessage = "Le titre doit contenir au plus {{ limit }} characters"
     * )
     *
     */
    private $Titre;

    /**
     * @Assert\NotBlank (message="la description est obligatoire")
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *      min = 50,
     *      max = 100,
     *       minMessage = "La description doit contenir au moins {{ limit }} caractéres",
     *      maxMessage = "La description doit contenir au plus {{ limit }} characters"
     * )
     */
    private $Description;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank (message="le prix est obligatoire")
     * @Assert\Range (min=10 , max=100 , notInRangeMessage = "Le prix doit etre entre {{ min }} et {{ max }} dt ",)
     * @Assert\Positive
     */
    private $prix;

    /**
     *  * @Assert\NotBlank (message="la date est obligatoire")
     * @ORM\Column(type="date")


     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank (message="l'adresse est obligatoire")
     *  @Assert\Length(
     *      min = 10,
     *      max = 20,
     *       minMessage = "La adresse doit contenir au moins {{ limit }} caractéres",
     *      maxMessage = "La description doit contenir au plus {{ limit }} characters"
     * )
     */
    private $adresse;

    /**
     * @Assert\NotBlank (message="la category est obligatoire")
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="programmes")
     */
    private $category;

    /**
     * @Assert\NotBlank (message="le statut est obligatoire")
     * @ORM\ManyToOne(targetEntity=Statut::class, inversedBy="programmes")
     */
    private $statut;

    /**
     * @Assert\NotBlank (message="l'image est obligatoire")
     * @ORM\ManyToOne(targetEntity=Image::class, inversedBy="programme",cascade={"persist"})
     * * @Assert\Image(
     *     minWidth = 200,
     *     maxWidth = 400,
     *     minHeight = 200,
     *     maxHeight = 400
     * )
     */
    private $image;
    /**
     * @Assert\NotBlank (message="l'image est obligatoire")
     * @ORM\ManyToOne(targetEntity=Image::class, inversedBy="programme" , cascade={"persist"})
     * * @Assert\Image(
     *     minWidth = 200,
     *     maxWidth = 400,
     *     minHeight = 200,
     *     maxHeight = 400
     * )
     */
    private $image2;

    /**
     * @Assert\NotBlank (message="l'image est obligatoire")
     * @ORM\ManyToOne(targetEntity=Image::class, inversedBy="programme",cascade={"persist"})
     * * @Assert\Image(
     *     minWidth = 200,
     *     maxWidth = 400,
     *     minHeight = 200,
     *     maxHeight = 400
     * )
     */
    private $image3;

    /**
     * @ORM\ManyToOne(targetEntity=OptionGuide::class, inversedBy="programme")
     */
    private $Guide;

    /**
     * @ORM\ManyToOne(targetEntity=OptionTransport::class, inversedBy="programmes")
     */
    private $transport;

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

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getStatut(): ?Statut
    {
        return $this->statut;
    }

    public function setStatut(?Statut $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getImage(): ?Image
    {
        return $this->image;
    }

    public function setImage(?Image $image): self
    {
        $this->image = $image;

        return $this;
    }
    public function getImage2(): ?Image
    {
        return $this->image2;
    }

    public function setImage2(?Image $image): self
    {
        $this->image2 = $image;

        return $this;
    }
    public function getImage3(): ?Image
    {
        return $this->image3;
    }

    public function setImage3(?Image $image): self
    {
        $this->image3 = $image;

        return $this;
    }

    public function getGuide(): ?OptionGuide
    {
        return $this->Guide;
    }

    public function setGuide(?OptionGuide $Guide): self
    {
        $this->Guide = $Guide;

        return $this;
    }

    public function getTransport(): ?OptionTransport
    {
        return $this->transport;
    }

    public function setTransport(?OptionTransport $transport): self
    {
        $this->transport = $transport;

        return $this;
    }
}
