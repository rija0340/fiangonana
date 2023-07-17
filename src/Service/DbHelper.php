<?php

namespace App\Service;

use App\Entity\File;
use App\Entity\Mambra;
use App\Entity\Famille;
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

    public function __construct(
        EntityManagerInterface $em,
        KernelInterface $kernelInterface
    ) {
        $this->em = $em;
    }


    public function clearAllMambraInDb(string $tableName)
    {
        $connection = $this->em->getConnection();

        $connection->executeStatement('SET FOREIGN_KEY_CHECKS=0');

        // Clear the table
        $connection->executeStatement('DELETE FROM ' . $tableName);

        $connection->executeStatement('SET FOREIGN_KEY_CHECKS=1');
    }

    public function insertMambraDataInDb($mambras)
    {
        foreach ($mambras as $key => $data) {
            $mambra  = new Mambra();
            $mambra->setNom($data[0]);
            $mambra->setPrenom($data[1]);
            $mambra->setFamille($data[2]);
            $mambra->setSexe($data[3]);
            $mambra->setDateNaissance($data[4]);
            $mambra->setTrancheAge($data[5]);
            $mambra->setBaptise($data[6]);
            $this->em->persist($mambra);
        }
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
