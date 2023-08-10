<?php

namespace App\Service;

use App\Entity\File;
use App\Entity\Mambra;
use Symfony\Component\Finder\Finder;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use PhpOffice\PhpSpreadsheet\Reader\Csv as ReaderCsv;
use PhpOffice\PhpSpreadsheet\Reader\Ods as ReaderOds;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as ReaderXlsx;

class FileHelper
{

    private $formFactory;
    private $em;
    private $kernelInterface;

    public function __construct(
        FormFactoryInterface $formFactory,
        EntityManagerInterface $em,
        KernelInterface $kernelInterface
    ) {
        $this->formFactory = $formFactory;
        $this->em = $em;
        $this->kernelInterface = $kernelInterface;
    }

    public function readFile($filename)
    {
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        switch ($extension) {
            case 'ods':
                $reader = new ReaderOds();
                break;
            case 'xlsx':
                $reader = new ReaderXlsx();
                break;
            case 'csv':
                $reader = new ReaderCsv();
                break;
            default:
                throw new \Exception('Invalid extension');
        }
        $reader->setReadDataOnly(true);
        return $reader->load($filename);
    }


    public function createDataFromSpreadsheet($spreadsheet)
    {

        $data = [];
        foreach ($spreadsheet->getWorksheetIterator() as $worksheet) {
            // $worksheetTitle = $worksheet->getTitle();
            // $data = [
            //     'columnNames' => [],
            //     'columnValues' => [],
            // ];
            foreach ($worksheet->getRowIterator() as $row) {
                $rowIndex = $row->getRowIndex();
                if ($rowIndex > 2) {
                    $data['columnValues'][$rowIndex] = [];
                }
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(false); // Loop over all cells, even if it is not set
                foreach ($cellIterator as $cell) {
                    if ($rowIndex === 1) {
                        $data['columnNames'][] = $cell->getCalculatedValue();
                    }
                    if ($rowIndex > 1) {
                        $data['columnValues'][$rowIndex][] = $cell->getCalculatedValue();
                    }
                }
            }
        }

        return $data;
    }

    public function createDataMpitondraRaharahafromSpreadsheet($spreadsheet)
    {
        $data = [];
        foreach ($spreadsheet->getWorksheetIterator() as $worksheet) {
            // $worksheetTitle = $worksheet->getTitle();
            // $data = [
            //     'columnNames' => [],
            //     'columnValues' => [],
            // ];
            foreach ($worksheet->getRowIterator() as $row) {

                $cellIterator = $row->getCellIterator();

                $rowIndex = $row->getRowIndex();
                foreach ($cellIterator as $cell) {
                    // var_dump($cell->getCalculatedValue());
                    echo $cell->getCalculatedValue() . "";
                    // $cell->getCalculatedValue();
                }
                echo "</br>";
                // die();

                // $rowIndex = $row->getRowIndex();
                // if ($rowIndex > 2) {
                //     $data['columnValues'][$rowIndex] = [];
                // }
                // $cellIterator = $row->getCellIterator();
                // $cellIterator->setIterateOnlyExistingCells(false); // Loop over all cells, even if it is not set
                // foreach ($cellIterator as $cell) {
                //     if ($rowIndex === 1) {
                //         $data['columnNames'][] = $cell->getCalculatedValue();
                //     }
                //     if ($rowIndex > 1) {
                //         $data['columnValues'][$rowIndex][] = $cell->getCalculatedValue();
                //     }
                // }
            }
            die();
        }
    }

    public function listFilesInUploadsFolder()
    {
        // Specify the folder name within the public directory
        $folderName = 'uploads';

        // Get the absolute path to the folder within the public directory
        $folderPath = $this->kernelInterface->getProjectDir('kernel.project_dir') . '/public/' . $folderName;

        // Create a new Finder instance and configure it
        $finder = new Finder();
        $finder->files()->in($folderPath);

        // Initialize an array to store the file names and extensions
        $fileList = [];

        // Iterate over the found files
        foreach ($finder as $file) {
            // Get the filename and extension
            $filename = $file->getBasename();
            $extension = $file->getExtension();
            // Store the filename and extension in the array
            $fileList[] = [
                'filename' => $filename,
                'extension' => $extension,
            ];
        }
        return $fileList;
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
}
