<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom_client = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $date_reservation = null;

    #[ORM\Column]
    private ?int $nombre_personnes = null;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Tour $tour = null;

    public function getId(): ?int { return $this->id; }

    public function getNomClient(): ?string { return $this->nom_client; }
    public function setNomClient(string $nom_client): static { $this->nom_client = $nom_client; return $this; }

    public function getEmail(): ?string { return $this->email; }
    public function setEmail(string $email): static { $this->email = $email; return $this; }

    public function getDateReservation(): ?\DateTime { return $this->date_reservation; }
    public function setDateReservation(\DateTime $date_reservation): static { $this->date_reservation = $date_reservation; return $this; }

    public function getNombrePersonnes(): ?int { return $this->nombre_personnes; }
    public function setNombrePersonnes(int $nombre_personnes): static { $this->nombre_personnes = $nombre_personnes; return $this; }

    public function getTour(): ?Tour { return $this->tour; }
    public function setTour(?Tour $tour): static { $this->tour = $tour; return $this; }
}
