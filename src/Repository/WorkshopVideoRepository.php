<?php

namespace App\Repository;

use App\Entity\WorkshopVideo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method WorkshopVideo|null find($id, $lockMode = null, $lockVersion = null)
 * @method WorkshopVideo|null findOneBy(array $criteria, array $orderBy = null)
 * @method WorkshopVideo[]    findAll()
 * @method WorkshopVideo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WorkshopVideoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WorkshopVideo::class);
    }

    // /**
    //  * @return WorkshopVideo[] Returns an array of WorkshopVideo objects
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
    public function findOneBySomeField($value): ?WorkshopVideo
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
