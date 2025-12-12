<?php

namespace App\Repository;

use App\Entity\Tour;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class TourRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tour::class);
    }

    /**
     * Retourne tous les tours pour une destination donnée
     */
    public function findToursByDestination($destinationId): array
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.destination = :dest')
            ->setParameter('dest', $destinationId)
            ->orderBy('t.title', 'ASC') // title au lieu de titre
            ->getQuery()
            ->getResult();
    }
}
