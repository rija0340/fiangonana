<?php

namespace App\Service;

use App\Entity\File;
use App\Entity\Mambra;
use App\Entity\Famille;
use App\Repository\FamilleRepository;
use Symfony\Component\Finder\Finder;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use PhpOffice\PhpSpreadsheet\Reader\Csv as ReaderCsv;
use PhpOffice\PhpSpreadsheet\Reader\Ods as ReaderOds;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as ReaderXlsx;

class DbHelper
{

    private $em;
    private $familleRepo;

    public function __construct(
        EntityManagerInterface $em,
        KernelInterface $kernelInterface,
        FamilleRepository $familleRepo
    ) {
        $this->em = $em;
        $this->familleRepo = $familleRepo;
    }


    public function clearAllDataInTable(string $tableName)
    {
        $connection = $this->em->getConnection();

        $connection->executeStatement('SET FOREIGN_KEY_CHECKS=0');

        // Clear the table
        $connection->executeStatement('DELETE FROM ' . $tableName);

        $connection->executeStatement('SET FOREIGN_KEY_CHECKS=1');
    }

    public function insertMambraDataInDb($data)
    {
        $dateNaissance =  str_replace("/", "-", $data[4]);
        $dateNaissance = $dateNaissance != null ? new \DateTime($dateNaissance) : null;

        $famille  = $this->familleRepo->findOneBy(['nom' => $data[2]]);
        $mambra  = new Mambra();
        $mambra->setNom($data[0] != null ? $data[0]  : "");
        $mambra->setPrenom($data[1] != null ? $data[1]  : "");
        $mambra->setFamille($famille != null ? $famille : null);
        $mambra->setSexe($data[3] != null ? $data[3]  : "");
        $mambra->setDateNaissance($dateNaissance);
        $mambra->setTrancheAge($data[5] != null ? $data[5]  : "");
        $mambra->setBaptise($data[1] != null ? $data[0]  : 0);
        $this->em->persist($mambra);
        $this->em->flush();
    }
    public function insertFamilleDataInDb($familleName)
    {
        $famille  = new Famille();
        $famille->setNom($familleName);
        $this->em->persist($famille);
        $this->em->flush();
    }
}
