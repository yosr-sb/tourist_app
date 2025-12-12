<?php

namespace App\Repository;

use App\Entity\Destination;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class DestinationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Destination::class);
    }
}
//Un repository sert à interagir avec la base de données pour cette entité : récupérer, filtrer, trier, etc.
//Le constructeur lie ce repository à l’entité Destination, ce qui permet à Doctrine de savoir quelle table manipuler.