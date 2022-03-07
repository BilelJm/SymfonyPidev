<?php

namespace App\Entity;
use App\Entity\booking;
use App\Repository\FactureRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity(repositoryClass=FactureRepository::class)
 */
class Facture
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    

 

    /**
     * @Assert\Type(type="float", message = "La valeur {{ value }} doit être de type {{ type }}")
     * @Assert\NotBlank(message = "Le champs prix equipement est vide ")
     * @ORM\Column(type="float", nullable=true)
     */
    private $Prix_equip;

    /**
     * @Assert\NotBlank(message = "Le champs id type est vide ")
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $type;

    /**
     * @Assert\Type(type="float", message = "La valeur {{ value }} doit être de type {{ type }}")
     *@Assert\NotBlank(message = "Le champs id frais de seejour est vide ")
     * @ORM\Column(type="float", nullable=true)
     */
    private $Prix_sejour;

    /**
     * @Assert\NotBlank(message = "Le champs frais programmes est vide ")
     * @Assert\Type(type="float", message = "La valeur {{ value }} doit être de type {{ type }}")
     * @ORM\Column(type="float", nullable=true)
     */
    private $prix_exp;

    /**
     * @Assert\Type(type="float", message = "La valeur {{ value }} doit être de type {{ type }}")
     * @Assert\NotBlank(message = "Le champs frais total est vide ")
     * @ORM\Column(type="float", nullable=true)
     */
    private $prix_final;

    /**
       * @ORM\Column(type="integer", nullable=true)
     */
    private $id_res;

    /**
     * @ORM\Column(type="integer")
     */
    private $id_exp;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrixEquip(): ?float
    {
        return $this->Prix_equip;
    }

    public function setPrixEquip(?float $Prix_equip): self
    {
        $this->Prix_equip = $Prix_equip;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getPrixSejour(): ?float
    {
        return $this->Prix_sejour;
    }

    public function setPrixSejour(?float $Prix_sejour): self
    {
        $this->Prix_sejour = $Prix_sejour;

        return $this;
    }

    public function getPrixExp(): ?float
    {
        return $this->prix_exp;
    }

    public function setPrixExp(?float $prix_exp): self
    {
        $this->prix_exp = $prix_exp;

        return $this;
    }

    public function getPrixFinal(): ?float
    {
        return $this->prix_final;
    }

    public function setPrixFinal(?float $prix_final): self
    {
        $this->prix_final = $prix_final;

        return $this;
    }

    public function getIdRes(): ?int
    {
        return $this->id_res;
    }

    public function setIdRes(?int $id_res): self
    {
        $this->id_res = $id_res;

        return $this;
    }

    public function getIdExp(): ?int
    {
        return $this->id_exp;
    }

    public function setIdExp(int $id_exp): self
    {
        $this->id_exp = $id_exp;

        return $this;
    }
}
