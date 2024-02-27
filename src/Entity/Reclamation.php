<?php

namespace App\Entity;

use App\Repository\ReclamationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\Reservation;

#[ORM\Entity(repositoryClass: ReclamationRepository::class)]
class Reclamation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Veuillez Remplir Ce Champs*")]
    private ?string $contenu = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: "Veuillez Remplir Ce Champs*")]
    private $image = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Reservation $idReservation = null;
    
    public function __toString()
    {
        return $this->idReservation ? $this->idReservation->getId() : '';
    }
    
    public function getId(): ?int
    {
        return $this->id;
    }
    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): static
    {
        $this->contenu = $contenu;

        return $this;
    }
    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    public function getIdReservation(): ?Reservation
    {
        return $this->idReservation;
    }

    public function setIdReservation(?Reservation $idReservation): static
    {
        $this->idReservation = $idReservation;

        return $this;
    }

}
