<?php

namespace App\Entity;

use App\Repository\TourRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: TourRepository::class)]
class Tour
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: 'float')]
    private ?float $price = null;

    #[ORM\ManyToOne(targetEntity: Destination::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Destination $destination = null;

    #[ORM\OneToMany(targetEntity: Reservation::class, mappedBy: 'tour')]
    private Collection $reservations;

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
    }

    // Getters & Setters
    public function getId(): ?int { return $this->id; }

    public function getTitle(): ?string { return $this->title; }
    public function setTitle(string $title): self { $this->title = $title; return $this; }

    public function getDescription(): ?string { return $this->description; }
    public function setDescription(?string $description): self { $this->description = $description; return $this; }

    public function getPrice(): ?float { return $this->price; }
    public function setPrice(float $price): self { $this->price = $price; return $this; }

    public function getDestination(): ?Destination { return $this->destination; }
    public function setDestination(?Destination $destination): self { $this->destination = $destination; return $this; }

    public function getReservations(): Collection { return $this->reservations; }

    public function addReservation(Reservation $reservation): self
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations->add($reservation);
            $reservation->setTour($this);
        }
        return $this;
    }

    public function removeReservation(Reservation $reservation): self
    {
        if ($this->reservations->removeElement($reservation) && $reservation->getTour() === $this) {
            $reservation->setTour(null);
        }
        return $this;
    }
}
