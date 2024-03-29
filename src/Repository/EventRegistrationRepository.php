<?php

namespace App\Repository;

use App\Entity\EventRegistration;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EventRegistration|null find($id, $lockMode = null, $lockVersion = null)
 * @method EventRegistration|null findOneBy(array $criteria, array $orderBy = null)
 * @method EventRegistration[]    findAll()
 * @method EventRegistration[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventRegistrationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EventRegistration::class);
    }

    // /**
    //  * @return EventRegistration[] Returns an array of EventRegistration objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    public function findAllArchived() {

        return $this->createQueryBuilder('e')
            ->where('e.archived = true')
            ->orderBy('e.created_at', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findAllNotArchived()
    {
        return $this->createQueryBuilder('e')
            ->where('e.archived = false')
            ->orderBy('e.created_at', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findAllToArchive() {
        return $this->createQueryBuilder('e')
            ->where('e.event.end_date < :today')
            ->setParameter('today', new DateTime())
            ->andWhere('e.status = :cancelled')
            ->setParameter('cancelled', 'cancelled')
            ->orderBy('e.created_at', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    /*
    public function findOneBySomeField($value): ?EventRegistration
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
