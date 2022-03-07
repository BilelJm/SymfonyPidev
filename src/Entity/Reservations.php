<?php

namespace App\Entity;

use App\Repository\ReservationsRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity(repositoryClass=ReservationsRepository::class)
 */
class Reservations
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank(message = "Le champs date arrive est vide ")
     * @ORM\Column(type="date", nullable=true)
     */
    private $datearrive;

    /**
     * @Assert\NotBlank(message = "Le champs date depart est vide ")
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateDepart;

    /**
     * @Assert\NotBlank(message = "Le champs duree sejour est vide ")
     * @ORM\Column(type="integer", nullable=true)
     */
    private $dureesejour;

   

    /**
     * @Assert\NotBlank(message = "Le champs nombre d'adultes est vide ")
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbadulte;

    /**
     * @Assert\NotBlank(message = "Le champs nombre d'enfants est vide ")
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbenfants;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $remarques;

    /**
     * @Assert\NotBlank(message = "Le champs frais total est vide ")
     * @ORM\Column(type="float", nullable=true)
     */
    private $prixtotal;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDatearrive(): ?\DateTimeInterface
    {
        return $this->datearrive;
    }

    public function setDatearrive(?\DateTimeInterface $datearrive): self
    {
        $this->datearrive = $datearrive;

        return $this;
    }

    public function getDateDepart(): ?\DateTimeInterface
    {
        return $this->dateDepart;
    }

    public function setDateDepart(?\DateTimeInterface $dateDepart): self
    {
        $this->dateDepart = $dateDepart;

        return $this;
    }

    public function getDureesejour(): ?int
    {
        return $this->dureesejour;
    }

    public function setDureesejour(?int $dureesejour): self
    {
        $this->dureesejour = $dureesejour;

        return $this;
    }

   

    public function getNbadulte(): ?int
    {
        return $this->nbadulte;
    }

    public function setNbadulte(?int $nbadulte): self
    {
        $this->nbadulte = $nbadulte;

        return $this;
    }

    public function getNbenfants(): ?int
    {
        return $this->nbenfants;
    }

    public function setNbenfants(?int $nbenfants): self
    {
        $this->nbenfants = $nbenfants;

        return $this;
    }

    public function getRemarques(): ?string
    {
        return $this->remarques;
    }

    public function setRemarques(?string $remarques): self
    {
        $this->remarques = $remarques;

        return $this;
    }

    public function getPrixtotal(): ?float
    {
        return $this->prixtotal;
    }

    public function setPrixtotal(?float $prixtotal): self
    {
        $this->prixtotal = $prixtotal;

        return $this;
    }
}
