<?php

namespace App\Entity;

use App\Repository\ServiceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ServiceRepository::class)]
class Service
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Veuillez Remplir Ce Champs*")]
    private ?string $categorieservice = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Veuillez Remplir Ce Champs*")]
    private ?string $nom = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: "Veuillez Remplir Ce Champs*")]
    private $imageser = null;

    #[ORM\OneToMany(targetEntity: Reservation::class, mappedBy: 'service_desiree')]
    private Collection $reservations;

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategorieS(): ?string
    {
        return $this->categorieservice;
    }

    public function setCategorieS(string $categorieservice): static
    {
        $this->categorieservice = $categorieservice;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection<int, Reservation>
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function getImageser()
    {
        return $this->imageser;
    }
    
    public function setImageser($imageser)
    {
        $this->imageser = $imageser;
    
        return $this;
    }


    public function addReservation(Reservation $reservation): static
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations->add($reservation);
            $reservation->setServiceDesiree($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): static
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getServiceDesiree() === $this) {
                $reservation->setServiceDesiree(null);
            }
        }

        return $this;
    }
}
