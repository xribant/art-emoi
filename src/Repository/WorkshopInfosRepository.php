<?php

namespace App\Repository;

use App\Entity\WorkshopInfos;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method WorkshopInfos|null find($id, $lockMode = null, $lockVersion = null)
 * @method WorkshopInfos|null findOneBy(array $criteria, array $orderBy = null)
 * @method WorkshopInfos[]    findAll()
 * @method WorkshopInfos[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WorkshopInfosRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WorkshopInfos::class);
    }

    // /**
    //  * @return WorkshopInfos[] Returns an array of WorkshopInfos objects
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
    public function findOneBySomeField($value): ?WorkshopInfos
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
