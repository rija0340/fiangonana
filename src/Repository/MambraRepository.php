<?php

namespace App\Repository;

use App\Entity\Mambra;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\Extension\Core\Type\CountryType;

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

    public function findPossibleMambra($trancheAge)
    {

        $condition = $this->getCondition($trancheAge);

        $rawsql = "SELECT m.id
                FROM mambra as m
                LEFT JOIN relation_km as r
                ON m.id = r.mambra_id
                LEFT JOIN kilasy as k
                ON k.id = r.kilasy_id
                WHERE r.kilasy_id IS NULL AND (" . $condition . ")";

        $statement =  $this->getEntityManager()->getConnection()->prepare($rawsql);
        $mambra = $statement->executeQuery([])->fetchAllAssociative();
        $liste = [];
        foreach ($mambra as $m) {
            array_push($liste, $this->find($m['id']));
        }

        return $liste;
    }

    /**
     * @return Mambra[]
     * @param Kilasy
     */
    public function findMambra($kilasy)
    {
        $trancheAge = $kilasy->getKilasyLasitra()->getTrancheAge();
        $condition = $this->getCondition($trancheAge);
        $rawsql = "SELECT m.id,m.nom,m.prenom,m.baptise,m.tranche_age,r.is_mpanentana, r.is_mambra_tsotra, r.is_mpampianatra
        FROM mambra as m
        LEFT JOIN relation_km as r
        ON m.id = r.mambra_id
        LEFT JOIN kilasy as k
        ON k.id = r.kilasy_id
        WHERE r.is_current = 1 AND r.kilasy_id = " . $kilasy->getId() . " AND (" . $condition . ") OR  r.is_current = 1 AND r.kilasy_id = " . $kilasy->getId();

        $statement =  $this->getEntityManager()->getConnection()->prepare($rawsql);
        $mambra = $statement->executeQuery([])->fetchAllAssociative();

        // $liste = [];
        // foreach ($mambra as $m) {
        //     array_push($liste, $this->find($m['id']));
        // }

        return $mambra;
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

    public function getCondition($trancheAge)
    {

        $hasVirg = str_contains($trancheAge, ',');
        if ($hasVirg) {

            $tranches = explode(",", $trancheAge);
            $count = 0;
            $condition = '';
            foreach ($tranches as $key => $tranche) {

                $condition .= "m.tranche_age = '$tranche'";

                $count++;
                if ($count == count($tranches)) {
                    continue;
                } else {
                    $condition .= ' OR ';
                }
            }
        } else {
            $condition = "m.tranche_age = '$trancheAge'";
        }
        return $condition;
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
