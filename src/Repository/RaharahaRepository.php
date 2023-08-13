<?php

namespace App\Repository;

use App\Entity\Raharaha;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Raharaha|null find($id, $lockMode = null, $lockVersion = null)
 * @method Raharaha|null findOneBy(array $criteria, array $orderBy = null)
 * @method Raharaha[]    findAll()
 * @method Raharaha[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RaharahaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Raharaha::class);
    }

    // /**
    //  * @return Raharaha[] Returns an array of Raharaha objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Raharaha
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
