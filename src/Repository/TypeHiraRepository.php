<?php

namespace App\Repository;

use App\Entity\TypeHira;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TypeHira|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeHira|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeHira[]    findAll()
 * @method TypeHira[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeHiraRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypeHira::class);
    }

    // /**
    //  * @return TypeHira[] Returns an array of TypeHira objects
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
    public function findOneBySomeField($value): ?TypeHira
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
