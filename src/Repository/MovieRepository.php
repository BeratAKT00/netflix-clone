<?php

namespace App\Repository;

use App\Entity\Movie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Movie>
 */
class MovieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Movie::class);
    }

    /**
     * Recherche les films par titre (Barre de recherche)
     * @return Movie[]
     */
    public function findBySearch(string $query): array
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.titre LIKE :val')
            ->setParameter('val', '%' . $query . '%')
            ->orderBy('m.id', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
