<?php

namespace App\Repository;

use App\Entity\Reservation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ReservationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reservation::class);
    }

    public function findReservationsByTour($tourId): array
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.tour = :tour')
            ->setParameter('tour', $tourId)
            ->orderBy('r.dateReservation', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
