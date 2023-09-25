<?php

namespace App\Controller;

use App\Entity\File;
use App\Form\FileType;
use App\Service\DbHelper;
use App\Service\FileHelper;
use App\Entity\VerificationMois;
use App\Entity\MpitondraRaharaha;
use App\Repository\MambraRepository;
use App\Repository\FamilleRepository;
use App\Repository\MpitondraRaharahaRepository;
use App\Repository\RaharahaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\VerificationMoisRepository;
use DateTime;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;


use function PHPUnit\Framework\isNull;

class MpitondraRaharahaController extends AbstractController
{

    private $em;
    private $mambraRepo;
    private $familleRepo;
    private $flashy;
    private $mpitondraRaharahaRepo;
    private $verificationMoisRepo;
    private $fileHelper;
    private $dbHelper;
    private $raharahaRepo;

    public function __construct(
        FlashyNotifier $flashy,
        FamilleRepository $familleRepo,
        EntityManagerInterface $em,
        MambraRepository $mambraRepo,
        VerificationMoisRepository $verificationMoisRepo,
        FileHelper $fileHelper,
        DbHelper $dbHelper,
        RaharahaRepository $raharahaRepo,
        MpitondraRaharahaRepository $mpitondraRaharahaRepo

    ) {
        $this->em = $em;
        $this->mambraRepo = $mambraRepo;
        $this->familleRepo = $familleRepo;
        $this->flashy = $flashy;
        $this->verificationMoisRepo = $verificationMoisRepo;
        $this->fileHelper = $fileHelper;
        $this->dbHelper = $dbHelper;
        $this->raharahaRepo = $raharahaRepo;
        $this->mpitondraRaharahaRepo = $mpitondraRaharahaRepo;
    }
    /**
     * @Route("/mpitondra-raharaha", name="mpitondra_raharaha", methods={"POST","GET"})
     * 
     */
    public function mpitondraRaharaha(Request $request)
    {
        //upload liste mambra
        $fileEntity = new File();
        $formFile = $this->createForm(FileType::class, $fileEntity);
        // dd($request);
        $formFile->handleRequest($request);

        if ($formFile->isSubmitted() && $formFile->isValid()) {
            // Perform additional operations with the uploaded file, if needed
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($fileEntity);
            $entityManager->flush();

            //check the content of the uploads folder
            $filename =  $this->getParameter('kernel.project_dir') . '/public/uploads/mpitondra.xlsx';
            if (is_file($filename)) {
                // try {
                $spreadsheet = $this->fileHelper->readFile($filename);
                $data = $this->fileHelper->createDataMpitondraRaharahafromSpreadsheet($spreadsheet);

                foreach ($data as $key => $volana) {
                    foreach ($volana as $key2 => $semaine) {

                        foreach ($semaine as $andraikitraAbbreviation => $mambraPrenom) {

                            //pour ne pas prendre les dates dans le data, date alarobia et zoma par exemple
                            if (!($mambraPrenom instanceof \DateTime)) {

                                $mpitondraRaharaha = new MpitondraRaharaha();
                                $andraikitraEntity =   $this->raharahaRepo->findOneBy(['abbreviation' => $andraikitraAbbreviation]);
                                $mambraEntity = is_null($mambraPrenom) ? null :   $this->mambraRepo->findOneByPrenom($mambraPrenom);

                                $andro  = explode('_', $andraikitraAbbreviation);
                                $andro =  count($andro) > 2 ? $andro[2] : $andro[1];

                                $mpitondraRaharaha->setAndraikitra($andraikitraEntity);

                                if (is_null($mambraEntity)) {
                                    //enregistrement du responsable, mety ho sampana mety ho olona tsy hay anarana
                                    $nom = is_null($mambraPrenom) ? "" : $mambraPrenom;
                                    $mpitondraRaharaha->setResponsable($nom);
                                } else {
                                    $mpitondraRaharaha->setMambra($mambraEntity);
                                }

                                $mpitondraRaharaha->setDate($semaine['date_' . $andro]);

                                if (!is_null($andraikitraEntity)) {
                                    $entityManager->persist($mpitondraRaharaha);
                                }
                            }
                        }
                    }
                }
                $entityManager->flush();
            }
            // Redirect or render a response
            return $this->redirectToRoute('mpitondra_raharaha');
        }


        //submission de mpitondra raharaha 

        if ($request->query->has('year') && $request->query->has('quarter') && $request->query->get('year') != null) {

            $quarterNumber = intval($request->query->get('quarter'));
            $year =  intval($request->query->get('year'));

            $structure  = $this->getSpecificDaysInQuarter($quarterNumber, $year);
        } else {

            $structure  = $this->getSpecificDaysInQuarter(4, 2023);
        }


        $mpitondraRaharahaAll = $this->mpitondraRaharahaRepo->findAll();
        $propertyArray = array_map(function ($entity) {
            return $entity->getDate(); // Replace with the actual method to access the property
        }, $mpitondraRaharahaAll);

        // Initialize an empty array to store categorized dates
        $categorizedDates = [];
        $mpitondraRehetra = [];

        // Iterate through each date and categorize by month
        foreach ($propertyArray as $date) {
            $date = $date->format('Y-m-d');
            $month = date('F', strtotime($date)); // Get month name
            $mpitondraRehetra[$date] = $this->mpitondraRaharahaRepo->findBy(['date' => new \DateTime($date)]);
            $categorizedDates[$month][$date] = $mpitondraRehetra[$date];
        }
        // dd($categorizedDates);
        $andraikitra = $this->raharahaRepo->findAll();

        $parAndraikitra = [];
        foreach ($andraikitra as $a) {

            $test = array_map(function ($entity) {
                return ($entity->getMambra() != null) ? $entity->getMambra()->getPrenom() : $entity->getResponsable();
            }, $this->mpitondraRaharahaRepo->findBy(['andraikitra' => $a]));

            $parAndraikitra[$a->getAbbreviation()] =  $test;
        }

        // $presides = $this->mpitondraRaharahaRepo->find;
        return $this->render('/mpitondra_raharaha/index.html.twig', [
            'sabbatParMois' => $this->sabbatsAnnuel(),
            'form' => $formFile->createView(),
            'mpitondraRehetra' => $categorizedDates,
            'parAndraikitra' => $parAndraikitra,
            'structure' => $structure,
            'andraikitraRehetra' => $this->raharahaRepo->findAll()
        ]);
    }

    /**
     * @Route("/-ajout-mpitondra-raharaha", name="creer_mpitondra_raharaha", methods={"POST","GET"})
     * 
     */
    public function ajoutMpitondraRaharaha(Request $request)
    {

        $all = $request->request;
        $entityManager = $this->getDoctrine()->getManager();
        $dataToFlush = false;

        dd($request);




        foreach ($all as $key => $value) {

            if (strpos('data', $key) === false) {
                $parts = explode('-', $key); //ex : 13-ff_alar
                $monthAndWeekNumber =  $parts[0]; //ex 13
                $weekNumber = explode('_', $monthAndWeekNumber);
                $weekNumber = $weekNumber[1];
                $andraikitra = $parts[1];
                $explodedAndraikitra =  isset($andraikitra) ? explode('_', $andraikitra) : null;
                $andro  = !is_null($explodedAndraikitra) ? end($explodedAndraikitra) : null; //ex : alar

                $year = 2023;
                $weekDates = isset($weekNumber) ? $this->getWeekDates(intval($weekNumber), $year) : null;

                if (!is_null($andro)) {

                    switch ($andro) {
                        case 'alar':
                            $date = $weekDates['wednesday'];
                            break;
                        case 'zoma':
                            $date = $weekDates['friday'];
                            break;
                        case 'sabata':
                            $date = $weekDates['saturday'];
                            break;
                        default:
                            $date = null;
                            break;
                    }
                }
            }
            //personne
            $idMambra = intval($request->request->get($key . '_data'));
            $andraikitraEntity  = $this->raharahaRepo->findOneBy(['abbreviation' => $andraikitra]);
            $mambra = $this->mambraRepo->find($idMambra);

            if ($mambra != null && $andraikitraEntity != null && $date != null) {

                $date = new \DateTime($date);

                $existingMpitondraRaharaha = $this->mpitondraRaharahaRepo->findOneBy(['andraikitra' => $andraikitraEntity, 'date' => $date]);


                if ($existingMpitondraRaharaha != null && ($existingMpitondraRaharaha->getMambra()->getId() != $mambra->getId())) {

                    $existingMpitondraRaharaha->setMambra($mambra);
                    $entityManager->persist($existingMpitondraRaharaha);
                    $dataToFlush = true;
                } elseif ($existingMpitondraRaharaha != null && ($existingMpitondraRaharaha->getMambra()->getId() == $mambra->getId())) {
                } else {

                    $mpitondra = new MpitondraRaharaha();
                    $mpitondra->setMambra($mambra);
                    $mpitondra->setAndraikitra($andraikitraEntity);
                    $mpitondra->setDate($date);
                    $entityManager->persist($mpitondra);
                    $dataToFlush = true;
                }
            }
        }
        if ($dataToFlush) {
            $entityManager->flush();
        }
        return $this->redirectToRoute('mpitondra_raharaha');
    }


    function getNameMouthFR($numMois): string
    {

        $monthFR = null;
        switch ($numMois) {
            case "01":
                $monthFR = 'Janvier';
                break;
            case "02":
                $monthFR = 'Février';
                break;
            case "03":
                $monthFR = 'Mars';
                break;
            case "04":
                $monthFR = 'Avril';
                break;
            case "05":
                $monthFR = 'Mai';
                break;
            case "06":
                $monthFR = 'Juin';
                break;
            case "07":
                $monthFR = 'Juillet';
                break;
            case "08":
                $monthFR = 'Août';
                break;
            case "09":
                $monthFR = 'Septembre';
                break;
            case "10":
                $monthFR = 'Octobre';
                break;
            case "11":
                $monthFR = 'Novembre';
                break;
            case "12":
                $monthFR = 'Décembre';
                break;
        }

        return $monthFR;
    }

    //return un tableau de tableaux contenant 
    //tous les sabbats du mois rangé par mois
    function sabbatsAnnuel()
    {

        $currentYear = new \DateTime('now');
        $currentYear = $currentYear->format('Y');
        $defaultMouth = 'january';
        $array = [];
        //on fixe le nombre de jour et si la date n'est pas valide, on saute le test
        //utilisation de check date
        for ($mois = 1; $mois < 13; $mois++) {
            for ($day = 1; $day < 31; $day++) {
                $date = new \DateTime($currentYear . "-" . $mois . "-" . $day);
                if (checkdate($mois, $day, $currentYear)) {
                    if ($date->format('w') == 6) {
                        array_push($array, $date);
                    }
                }
            }
        }
        //
        $sabbatsRangeParMois = [];
        $dataParMois = [];
        //classer les sabbats par mois
        for ($mois = 1; $mois < 13; $mois++) {
            for ($i = 0; $i < 52; $i++) {
                if ($array[$i]->format('m') == $mois) {
                    array_push($dataParMois, $array[$i]);
                    // $data[$mois] = $array[$i];
                }
            }
            $sabbatsRangeParMois[$this->getNameMouthFR($mois)] = $dataParMois;
            $dataParMois = [];
        }
        return $sabbatsRangeParMois;
    }


    function getFrenchDate($monthName, $dayNumber)
    {
        // Array of French month names
        $frenchMonths = array(
            'janvier', 'février', 'mars', 'avril', 'mai', 'juin',
            'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre'
        );

        // Convert both month names to lowercase without accents for comparison
        $monthNameLower = strtolower(str_replace(array('é', 'è'), 'e', $monthName));

        // Find the index of the month in the array
        $monthIndex = array_search($monthNameLower, $frenchMonths);

        // Check if the month was found
        if ($monthIndex !== false) {
            // Create a date using the found month index and provided day number
            $date = date('Y-m-d', mktime(0, 0, 0, $monthIndex + 1, $dayNumber));

            return $date;
        } else {
            return "Invalid month name";
        }
    }

    /**
     * retourne les jours dans un trimestre d'une année
     * mercredi, vendredi et samedi par semaine et par mois
     */
    function getSpecificDaysInQuarter($rankQuarter, $year)
    {

        $monthNames = $this->getQuarterMonths($rankQuarter);

        $all = [];
        foreach ($monthNames as $key => $month) {

            $all[$month] =  $this->getSpecificDaysInMonth(intval($key + 1), $year);
        }
        return $all;
    }

    /**
     * retourn les mois dans un trimestre 
     * params rang d'un trimestre dans une année
     */
    function getQuarterMonths($quarterRank)
    {

        // Create an array to hold the month names
        $monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        $quarterMonths = [];
        // Check if the quarter value is within a valid range (1 to 4)
        if ($quarterRank >= 1 && $quarterRank <= 4) {
            // Calculate the start and end months for the selected quarter
            $startMonth = ($quarterRank - 1) * 3; // Months are zero-based, so 0 for Q1, 3 for Q2, 6 for Q3, 9 for Q4
            $endMonth = $startMonth + 2;

            // Get the corresponding months for the selected quarter
            $quarterMonths = array_slice($monthNames, $startMonth, 3, true);
        } else {
            // Handle an invalid quarter value here
            echo "Invalid quarterRank value. Please choose a value between 1 and 4.";
            exit;
        }

        return $quarterMonths;
    }

    /**
     * retourne les dates spécifiques (mercredi, vendredi et samedi ) dans un mois 
     * classé par semaine et par type de jour
     * params numero d'un mois
     */
    function getSpecificDaysInMonth($monthNumber, $year)
    {
        // Define the month and year (you can change these values)
        $month = $monthNumber;
        // Calculate the number of days in the given month
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

        // Initialize an associative array to hold weeks with arrays of days
        $weeksArray = [];

        // Loop through the days in the month and group them by week and weekday
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = "$year-$month-$day";


            //get data form database 

            $data =  $this->mpitondraRaharahaRepo->findBy(['date' => new \DateTime($date)]);
            $data = count($this->entityToArray($data)) > 0 ? $this->entityToArray($data) : "";


            $weekNumber = date('W', strtotime($date)); // Get the ISO-8601 week number
            $dayOfWeek = date('N', strtotime($date)); // 1 (Monday) to 7 (Sunday)
            // Check if the current day is one of the specific days (Wednesday, Friday, or Saturday)
            if ($dayOfWeek == 3 || $dayOfWeek == 5 || $dayOfWeek == 6) {
                // Create a new week array if it doesn't exist
                if (!isset($weeksArray[$weekNumber])) {
                    $weeksArray[$weekNumber] = [
                        'wednesday' => "",
                        'friday' => "",
                        'saturday' => "",
                    ];
                }

                if ($dayOfWeek == 3) { // Wednesday
                    $weeksArray[$weekNumber]['wednesday'] =  ['date' => $date, 'data' => $data];
                } elseif ($dayOfWeek == 5) { // Friday
                    $weeksArray[$weekNumber]['friday'] = ['date' => $date, 'data' => $data];
                } elseif ($dayOfWeek == 6) { // Saturday
                    $weeksArray[$weekNumber]['saturday'] = ['date' => $date, 'data' => $data];
                }
            }
        }

        return $weeksArray;
    }




    public function entityToArray($entities)
    {
        $data = [];
        foreach ($entities as $key => $entity) {
            $one = [
                'mambra' => $entity->getMambra()->getPrenom(),
                'mambraId' => $entity->getMambra()->getId(),
            ];

            $data[$entity->getAndraikitra()->getAbbreviation()] = $one;
        }

        return $data;
    }


    /**
     * 
     * @param numero de semaine et année 
     *  @return array $dates contenant des dates spécifiques
     */

    function getWeekDates($weekNumber, $year)
    {

        $week_start = new DateTime();
        $week_start->setISODate($year, $weekNumber);
        $wednesday = $week_start->modify("next wednesday")->format("Y-m-d");
        $friday = $week_start->modify("next friday")->format("Y-m-d");
        $saturday = $week_start->modify("next saturday")->format("Y-m-d");

        $dates = [
            'wednesday' => $wednesday,
            'friday' => $friday,
            'saturday' => $saturday
        ];

        return $dates;
    }
}
