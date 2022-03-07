<?php

namespace App\Entity;

use App\Repository\CommentsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommentsRepository::class)
 */
class Comments
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $content;



    /**
     * @ORM\ManyToOne(targetEntity=Annonce::class, inversedBy="comments",cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $annonces;





    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }




    public function getAnnonces(): ?Annonce
    {
        return $this->annonces;
    }

    public function setAnnonces(?Annonce $annonces): self
    {
        $this->annonces = $annonces;

        return $this;
    }


}
