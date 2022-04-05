<?php

namespace App\Repository;

use App\Entity\FreeRegistration;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FreeRegistration|null find($id, $lockMode = null, $lockVersion = null)
 * @method FreeRegistration|null findOneBy(array $criteria, array $orderBy = null)
 * @method FreeRegistration[]    findAll()
 * @method FreeRegistration[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FreeRegistrationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FreeRegistration::class);
    }

    // /**
    //  * @return FreeRegistration[] Returns an array of FreeRegistration objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FreeRegistration
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
