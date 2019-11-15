<?php

namespace App\Repository;

use App\Entity\Course;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Course|null find($id, $lockMode = null, $lockVersion = null)
 * @method Course|null findOneBy(array $criteria, array $orderBy = null)
 * @method Course[]    findAll()
 * @method Course[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CourseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Course::class);
    }

    /**
     * @return Course[] Returns an array of Course objects
     */

    public function findAllAsc()
    {
        return $this->createQueryBuilder('c')
            ->orderBy('c.coursename', 'ASC')
            ->setMaxResults(500)
            ->getQuery()
            ->getResult()
            ;
    }

    /**
    * @return Course[] Returns an array of Course objects
    */

    public function findByArea($area, $term)
    {
        if ($area=='U') {
            return $this->createQueryBuilder('c')
                ->andWhere('c.area = 1 or c.area = 2 or c.area = 3 or c.area = 4 or c.area = 5 or c.area = 6')
                ->andWhere('c.term = :term')
                ->setParameter('term', $term)
                ->orderBy('c.coursename', 'ASC')
                ->setMaxResults(500)
                ->getQuery()
                ->getResult()
                ;
        }
        else {
            return $this->createQueryBuilder('c')
                ->andWhere('c.area = :area')
                ->setParameter('area', $area)
                ->andWhere('c.term = :term')
                ->setParameter('term', $term)
                ->orderBy('c.coursename', 'ASC')
                ->setMaxResults(500)
                ->getQuery()
                ->getResult()
                ;
        }

    }

    public function findOneByTermCall($term, $callnumber)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.term = :term')
            ->setParameter('term', $term)
            ->andWhere('c.callnumber = :callnumber')
            ->setParameter('callnumber', $callnumber)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function findByName($name)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.instructorname = :val')
            ->setParameter('val', $name)
            ->getQuery()
            ->getResult()
            ;
    }
}
