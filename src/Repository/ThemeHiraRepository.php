<?php

namespace App\Repository;

use App\Entity\ThemeHira;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ThemeHira|null find($id, $lockMode = null, $lockVersion = null)
 * @method ThemeHira|null findOneBy(array $criteria, array $orderBy = null)
 * @method ThemeHira[]    findAll()
 * @method ThemeHira[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ThemeHiraRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ThemeHira::class);
    }

    // /**
    //  * @return ThemeHira[] Returns an array of ThemeHira objects
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
    public function findOneBySomeField($value): ?ThemeHira
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
