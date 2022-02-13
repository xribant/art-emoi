<?php

namespace App\Repository;

use App\Entity\WorkshopLocation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method WorkshopLocation|null find($id, $lockMode = null, $lockVersion = null)
 * @method WorkshopLocation|null findOneBy(array $criteria, array $orderBy = null)
 * @method WorkshopLocation[]    findAll()
 * @method WorkshopLocation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WorkshopLocationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WorkshopLocation::class);
    }

    // /**
    //  * @return WorkshopLocation[] Returns an array of WorkshopLocation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('w.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?WorkshopLocation
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
