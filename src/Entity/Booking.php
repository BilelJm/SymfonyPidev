<?php

namespace App\Entity;

use App\Repository\BookingRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BookingRepository::class)
 */
class Booking
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @ORM\Column(type="date")
     */
    private $date_arrivee;

    /**
     * @ORM\Column(type="date")
     */
    private $date_depart;

    /**
     * @ORM\Column(type="integer")
     */
    private $duree_sejour;

   
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbr_adulte;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nb_enfants;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $remarques;

    /**
     * @ORM\Column(type="float")
     */
    private $Prix_total;

    public function getId(): ?int
    {
        return $this->id;
    }

   

    public function getDateArrivee(): ?\DateTimeInterface
    {
        return $this->date_arrivee;
    }

    public function setDateArrivee(\DateTimeInterface $date_arrivee): self
    {
        $this->date_arrivee = $date_arrivee;

        return $this;
    }

    public function getDateDepart(): ?\DateTimeInterface
    {
        return $this->date_depart;
    }

    public function setDateDepart(\DateTimeInterface $date_depart): self
    {
        $this->date_depart = $date_depart;

        return $this;
    }

    public function getDureeSejour(): ?int
    {
        return $this->duree_sejour;
    }

    public function setDureeSejour(int $duree_sejour): self
    {
        $this->duree_sejour = $duree_sejour;

        return $this;
    }

   

    public function getNbrAdulte(): ?int
    {
        return $this->nbr_adulte;
    }

    public function setNbrAdulte(?int $nbr_adulte): self
    {
        $this->nbr_adulte = $nbr_adulte;

        return $this;
    }

    public function getNbEnfants(): ?int
    {
        return $this->nb_enfants;
    }

    public function setNbEnfants(?int $nb_enfants): self
    {
        $this->nb_enfants = $nb_enfants;

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

    public function getPrixTotal(): ?float
    {
        return $this->Prix_total;
    }

    public function setPrixTotal(float $Prix_total): self
    {
        $this->Prix_total = $Prix_total;

        return $this;
    }
}
