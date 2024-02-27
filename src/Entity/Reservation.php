<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use App\Entity\Service;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_debut = null;
    
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_fin = null;
    

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Veuillez Remplir Ce Champs*")]
    private ?string $categorie = null;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    #[Assert\NotBlank(message: "Veuillez Remplir Ce Champs*")]
    private ?Service $service_desiree = null;

    public function __construct()
    {
        $this->date_debut = new \DateTime('now');
        $this->date_fin = new \DateTime('now');
    }
    public function __toString()
    {
        return $this->service_desiree ? $this->service_desiree->getNom() : '';
    }
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->date_debut;
    }

    public function setDateDebut(?\DateTimeInterface $date_debut): static
    {
        $this->date_debut = $date_debut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->date_fin;
    }

    public function setDateFin(?\DateTimeInterface $date_fin): static
    {
        $this->date_fin = $date_fin;

        return $this;
    }

    public function getCategorie(): ?string
    {
        return $this->categorie;
    }

    public function setCategorie(string $categorie): static
    {
        $this->categorie = $categorie;

        return $this;
    }

    //FUNCTION
    public function validateDate(ExecutionContextInterface $context, $payload)
    {
        if ($this->date_debut < new \DateTime('now')) {
            $context->buildViolation('La date de début ne peut pas être antérieure à aujourd\'hui.')
                ->atPath('date_debut')
                ->addViolation();
        }

        if ($this->date_fin < new \DateTime('now')) {
            $context->buildViolation('La date de fin ne peut pas être antérieure à aujourd\'hui.')
                ->atPath('date_fin')
                ->addViolation();
        }
    }

    public function getServiceDesiree(): ?Service
    {
        return $this->service_desiree;
    }

    public function setServiceDesiree(?Service $service_desiree): static
    {
        $this->service_desiree = $service_desiree;

        return $this;
    }

}
