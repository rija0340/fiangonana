<?php

namespace App\Repository;

use App\Entity\RelationKM;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RelationKM|null find($id, $lockMode = null, $lockVersion = null)
 * @method RelationKM|null findOneBy(array $criteria, array $orderBy = null)
 * @method RelationKM[]    findAll()
 * @method RelationKM[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RelationKMRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RelationKM::class);
    }

    // /**
    //  * @return RelationKM[] Returns an array of RelationKM objects
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
    public function findOneBySomeField($value): ?RelationKM
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
