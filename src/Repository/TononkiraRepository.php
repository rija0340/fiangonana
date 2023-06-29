<?php

namespace App\Repository;

use App\Entity\Tononkira;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Tononkira|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tononkira|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tononkira[]    findAll()
 * @method Tononkira[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TononkiraRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tononkira::class);
    }

    // /**
    //  * @return Tononkira[] Returns an array of Tononkira objects
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

    /*
    public function findOneBySomeField($value): ?Tononkira
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
