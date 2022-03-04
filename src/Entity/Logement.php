<?php

namespace App\Entity;

use App\Repository\LogementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=LogementRepository::class)
 * @Vich\Uploadable
 */
class Logement
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("post:read")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("post:read")
     * @Assert\NotBlank(
     *     message="titre de logement est obligatoire"
     * )
     * 
     */
    private $titre;

    /**
     * @ORM\Column(type="text")
     * @Groups("post:read")
     * @Assert\NotBlank(
     *     message="description de logement est obligatoire"
     * )
     */
    private $description;

    /**
     * @ORM\Column(type="text")
     * @Groups("post:read")
     * @Assert\NotBlank(
     *     message="addresse de logement est obligatoire"
     * )
     * 
     */
    private $addresse;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="logements")
     * @ORM\JoinColumn(nullable=false)
     * @Groups("post:read")
     */
    private $hote;

    /**
     * @ORM\ManyToMany(targetEntity=Equipement::class, inversedBy="logements")
     */
    private $equipements;

    /**
     * @ORM\Column(type="string",length=255, nullable=true)
     * @var string
     *
     */
    private $filename;

    /**
     * @ORM\Column(type="string",length=255, nullable=true)
     * @var string
     */
    private $qrFileName;

    /**
     * @Vich\UploadableField(mapping="logment_image", fileNameProperty="filename")
     * @Assert\Image(
     * mimeTypes = {"image/png","image/jpeg","image/webp"},
     * mimeTypesMessage = "Please upload a valid file"
     *
     * )
     * @var File
     */
    private $imageFile;

    /**
     * @Vich\UploadableField(mapping="qr_image", fileNameProperty="qrFileName")
     * @Assert\Image(
     * mimeTypes = {"image/png","image/jpeg","image/webp"},
     * mimeTypesMessage = "Please upload a valid file"
     *
     * )
     * @var File
     */
    private $imageQrFile;

    /**
     * @ORM\Column(type="datetime",nullable=true, columnDefinition="DATETIME on update CURRENT_TIMESTAMP")
     */
    private $createdAt;
    /**
     * @ORM\Column(type="datetime",nullable=true, columnDefinition="DATETIME on update CURRENT_TIMESTAMP")
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive = true;


    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable('now');
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
    /**
     * @return string|null
     */
    public function getFilename(): ?string
    {
        return $this->filename;
    }

    /**
     *@return File|null
     */
    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    /**
     * @param null|string $filename
     * @return Logement
     */
    public function setFilename(?string $filename): ?Logement
    {
        $this->filename = $filename;
        return $this;
    }

    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $imageFile
     */
    public function setImageFile(?File $imageFile = null): Logement
    {
        $this->imageFile = $imageFile;
        if (null != $imageFile) {
            if ($this->imageFile instanceof UploadedFile) {
                $this->updatedAt = new \DateTime('now');
            }
        }
        return $this;
    }

    /**
     * @return string|null
     */
    public function getQrFileName(): string
    {
        return $this->qrFileName;
    }

    /**
     * @param null|string $qrFileName
     * @return Logement
     */
    public function setQrFileName(?string $qrFileName): Logement
    {
        $this->qrFileName = $qrFileName;
        return $this;
    }

    /**
     * @return File|null
     */
    public function getImageQrFile(): ?File
    {
        return $this->imageQrFile;
    }

    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $imageQrFile
     */
    public function setImageQrFile(?File $imageQrFile): Logement
    {
        $this->imageQrFile = $imageQrFile;
        if (null != $imageQrFile) {
            if ($this->imageQrFile instanceof UploadedFile) {
                $this->updatedAt = new \DateTime('now');
            }
        }

        return $this;
    }


    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }
    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

}
