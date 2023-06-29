<?php

namespace App\Repository;

use App\Entity\Kilasy;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Kilasy|null find($id, $lockMode = null, $lockVersion = null)
 * @method Kilasy|null findOneBy(array $criteria, array $orderBy = null)
 * @method Kilasy[]    findAll()
 * @method Kilasy[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class KilasyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Kilasy::class);
    }



    /**
     * @return Kilasy[] Returns an array of Kilasy objects
     */

    public function findAllWithout($kilasy)
    {
        return $this->createQueryBuilder('k')
            ->andWhere('k.id != :val')
            ->setParameter('val', $kilasy->getId())
            ->orderBy('k.id', 'ASC')
            ->getQuery()
            ->getResult();
    }


    // /**
    //  * @return Kilasy[] Returns an array of Kilasy objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('k')
            ->andWhere('k.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('k.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Kilasy
    {
        return $this->createQueryBuilder('k')
            ->andWhere('k.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
