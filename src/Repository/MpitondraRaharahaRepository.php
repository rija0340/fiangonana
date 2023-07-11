<?php

namespace App\Repository;

use App\Entity\MpitondraRaharaha;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MpitondraRaharaha|null find($id, $lockMode = null, $lockVersion = null)
 * @method MpitondraRaharaha|null findOneBy(array $criteria, array $orderBy = null)
 * @method MpitondraRaharaha[]    findAll()
 * @method MpitondraRaharaha[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MpitondraRaharahaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MpitondraRaharaha::class);
    }

    // /**
    //  * @return MpitondraRaharaha[] Returns an array of MpitondraRaharaha objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SekolySabata
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
