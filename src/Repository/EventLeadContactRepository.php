<?php

namespace App\Repository;

use App\Entity\EventLeadContact;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EventLeadContact>
 *
 * @method EventLeadContact|null find($id, $lockMode = null, $lockVersion = null)
 * @method EventLeadContact|null findOneBy(array $criteria, array $orderBy = null)
 * @method EventLeadContact[]    findAll()
 * @method EventLeadContact[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventLeadContactRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EventLeadContact::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(EventLeadContact $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(EventLeadContact $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return EventLeadContact[] Returns an array of EventLeadContact objects
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

    /*
    public function findOneBySomeField($value): ?EventLeadContact
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
