<?php

namespace App\Repository;

use App\Entity\Hira;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Hira|null find($id, $lockMode = null, $lockVersion = null)
 * @method Hira|null findOneBy(array $criteria, array $orderBy = null)
 * @method Hira[]    findAll()
 * @method Hira[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HiraRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Hira::class);
    }

    // /**
    //  * @return Hira[] Returns an array of Hira objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('h.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Hira
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
