<?php

namespace App\Repository;

use App\Entity\Term;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Term|null find($id, $lockMode = null, $lockVersion = null)
 * @method Term|null findOneBy(array $criteria, array $orderBy = null)
 * @method Term[]    findAll()
 * @method Term[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TermRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Term::class);
    }

    // /**
    //  * @return Term[] Returns an array of Term objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /**
    * @return Term[] Returns an array of Term objects
    */
    public function findAllDescending()
    {
        return $this->createQueryBuilder('t')
            ->orderBy('t.term', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * @return Term[] Returns an array of Term objects
     */
    public function findCurrent()
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.status >= :val')
            ->setParameter('val', '1')
            ->orderBy('t.term', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findDefault(): Term
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.status = :val')
            ->setParameter('val', '2')
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function findName($term): Term
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.term = :val')
            ->setParameter('val', $term)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }

}
