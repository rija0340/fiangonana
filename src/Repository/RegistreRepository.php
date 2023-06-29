<?php

namespace App\Repository;

use DatePeriod;
use DateInterval;
use App\Entity\Registre;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Registre|null find($id, $lockMode = null, $lockVersion = null)
 * @method Registre|null findOneBy(array $criteria, array $orderBy = null)
 * @method Registre[]    findAll()
 * @method Registre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RegistreRepository extends ServiceEntityRepository
{

    private $kilasyRepo;
    public function __construct(ManagerRegistry $registry, KilasyRepository $kilasyRepo)
    {
        $this->kilasyRepo = $kilasyRepo;
        parent::__construct($registry, Registre::class);
    }

    /**
     * @return Registre[] Returns an array of Classe objects
     */

    public function findExistingRegistres($kilasy, $date)
    {
        return $this->createQueryBuilder('c')
            ->where("c.createdAt = :date AND c.kilasy = :kilasy ")
            ->setParameter('kilasy', $kilasy)
            ->setParameter('date', $date)
            ->getQuery()
            ->getResult();
    }

    /** 
     * @return Registre[] Returns an array 
     * @param DateTime $dateDebut
     * @param DateTime $dateFin
     */
    public function findRegistresKilasyByDates($dateDebut, $dateFin, $kilasy)
    {
        return $this->findRegistresByDates($dateDebut, $dateFin, $kilasy);
    }

    public function findRegistresByDates($dateDebut, $dateFin, $kilasy = 0)
    {
        $interval = new DateInterval('P1D');

        $dateRange = new DatePeriod($dateDebut, $interval, $dateFin);

        $saturdayCount = 0;
        $compteur = 0;
        $registresDateRange = [];
        foreach ($dateRange as $date) {
            $compteur++;
            if ($date->format('D') == 'Sat') {
                $saturdayCount++;
                if ($kilasy != 0) {
                    array_push($registresDateRange, $this->findOneBy(['createdAt' => $date, 'kilasy' => $kilasy]));
                } else {
                    array_push($registresDateRange, $this->findBy(['createdAt' => $date]));
                }
            }
        }
        // dd($registresDateRange, $kilasy);
        return $registresDateRange;
    }

    // /**
    //  * @return Registre[] Returns an array of Classe objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Registre
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
