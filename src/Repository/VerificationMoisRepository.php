<?php

namespace App\Repository;

use App\Entity\VerificationMois;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method VerificationMois|null find($id, $lockMode = null, $lockVersion = null)
 * @method VerificationMois|null findOneBy(array $criteria, array $orderBy = null)
 * @method VerificationMois[]    findAll()
 * @method VerificationMois[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VerificationMoisRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VerificationMois::class);
    }

    // /**
    //  * @return VerificationMois[] Returns an array of VerificationMois objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?VerificationMois
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
