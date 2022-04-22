<?php

namespace App\Repository;

use App\Entity\Mambra;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Mambra|null find($id, $lockMode = null, $lockVersion = null)
 * @method Mambra|null findOneBy(array $criteria, array $orderBy = null)
 * @method Mambra[]    findAll()
 * @method Mambra[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MambraRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Mambra::class);
    }

    /**
     * @return Mambra[] Returns an array of Mambra objects
     */

    public function findLehibe()
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.trancheAge = :val')
            ->setParameter('val', '35+')
            ->orderBy('m.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Mambra[] Returns an array of Mambra objects
     */

    public function findTanoraZokiny()
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.trancheAge = :val')
            ->setParameter('val', '19_35')
            ->orderBy('m.id', 'ASC')
            ->getQuery()
            ->getResult();
    }


    /**
     * @return Mambra[] Returns an array of Mambra objects
     */

    public function findZatovo()
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.trancheAge = :val')
            ->setParameter('val', '16_18')
            ->orderBy('m.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Mambra[] Returns an array of Mambra objects
     */

    public function findTanoraZandriny()
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.trancheAge = :val')
            ->setParameter('val', '13_15')
            ->orderBy('m.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Mambra[] Returns an array of Mambra objects
     */

    public function findAnkizy()
    {
        return $this->createQueryBuilder('m')
            ->where("m.trancheAge = '5_12' OR m.trancheAge = '3_4' OR m.trancheAge = '0_2'")
            ->orderBy('m.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Mambra[] Returns an array of Mambra objects
     */

    public function findMambraAfakaMitondraRaharaha()
    {
        return $this->createQueryBuilder('m')
            ->where("m.trancheAge != '0_2' AND m.trancheAge != '3_4' AND m.trancheAge != '5_12'")
            ->andWhere("m.baptise = TRUE OR m.baptise != 'NULL' ")
            // ->setParameter('val', 'NULL')
            ->orderBy('m.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return Mambra[] Returns an array of Mambra objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Mambra
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
