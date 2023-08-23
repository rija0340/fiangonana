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
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
            'parAndraikitra' => $parAndraikitra
        ]);
    }

    /**
     * @Route("/-ajout-mpitondra-raharaha", name="creer_mpitondra_raharaha", methods={"POST","GET"})
     * 
     */
    public function ajoutMpitondraRaharaha(Request $request)
    {
        $array = $request->request;
        //si array n'est pas vide, traiter les données
        //$array contient mpandraharaha pour un mois
        if (count($array) != 0) {
            // $client = $request->query->get('client');
            // $client = explode('(', $client);
            // $mailClient = explode(')', $client[1]);
            // $mailClient = $mailClient[0];
            //01-01-2022_
            // array[date]=>[ presides = nom, dimy_minitra = nom   ]
            $sabataVolanaIray = [];
            $andraikitra = [];
            //boucler sur toutes les données recu form query
            foreach ($array as $key => $arr) {
                $dateSabata = substr($key, 0, 10);
                $andraikitra = substr($key, 11);
                $sabataVolanaIray[$dateSabata] = []; //to build an array of arrays
                //pour chaque date, rassembler les responsabilité (andraikitra $sabataVolanaIray[date] => [[presides => rija], [dimyMinintra=>chettina]])
                foreach ($array as $key2 => $arr2) {
                    $presides = [];
                    $tmt = [];
                    $dimyMinitra = [];
                    $lesona = [];
                    $mpitoryTeny = [];
                    $presidesHariva = [];

                    $date2 = substr($key2, 0, 10);
                    $andr2 = substr($key2, 11);
                    //presides
                    if ($date2 == $dateSabata && $andr2 == "presides") {
                        //on met la valeur (la personne) dans un tableau
                        $presides['presides'] = $arr2;
                        //et on push le tableau dans le tableau principal
                        array_push($sabataVolanaIray[$dateSabata], $presides);
                    }
                    //dimyMinitra
                    if ($date2 == $dateSabata && $andr2 == "dimyMinitra") {
                        $dimyMinitra['dimyMinitra'] = $arr2;
                        array_push($sabataVolanaIray[$dateSabata], $dimyMinitra);
                    }
                    //tatitra maneran-tany
                    if ($date2 == $dateSabata && $andr2 == "tmt") {
                        $tmt['tmt'] = $arr2;
                        array_push($sabataVolanaIray[$dateSabata], $tmt);
                    }

                    //tatitra maneran-tany
                    if ($date2 == $dateSabata && $andr2 == "lesona") {
                        $tmt['lesona'] = $arr2;
                        array_push($sabataVolanaIray[$dateSabata], $tmt);
                    }
                    //tatitra maneran-tany
                    if ($date2 == $dateSabata && $andr2 == "mpitoryTeny") {
                        $tmt['mpitoryTeny'] = $arr2;
                        array_push($sabataVolanaIray[$dateSabata], $tmt);
                    }
                    //tatitra maneran-tany
                    if ($date2 == $dateSabata && $andr2 == "presidesHariva") {
                        $tmt['presidesHariva'] = $arr2;
                        array_push($sabataVolanaIray[$dateSabata], $tmt);
                    }
                }
            }
            // insertion dans base de données boucler pour tous les sabbats d'un mois
            foreach ($sabataVolanaIray as $key => $sab) {
                //sab est un tableau representant 1 sabbat contenant key=>value ,
                //key -> andraikitra, value-> id personne 
                $ss = new MpitondraRaharaha();
                $ss->setDateSabata(new \DateTime($key));
                $ss->setPresides($this->mambraRepo->find($sab[0]['presides']));
                $ss->setDimyMinitra($this->mambraRepo->find($sab[1]['dimyMinitra']));
                $ss->setTmt($this->mambraRepo->find($sab[2]['tmt']));
                $ss->setLesona($this->mambraRepo->find($sab[3]['lesona']));
                $ss->setMpitoryTeny($this->mambraRepo->find($sab[4]['mpitoryTeny']));
                $ss->setPresidesHariva($this->mambraRepo->find($sab[5]['presidesHariva']));
                $this->em->persist($ss);
                $this->em->flush();
            }
            //check si un specific mois est rempli et mettre true dans vérification mois entity
            $verification = new VerificationMois();
            $verification->setMois($this->getNameMouthFR($ss->getDateSabata()->format('m')) . "_" . $ss->getDateSabata()->format('Y'));
            $verification->setRempli(true);
            $this->em->persist($verification);
            $this->em->flush();
            return $this->redirectToRoute('mpitondra_raharaha');
        }

        //possibilité de saisi seulement pour les mois vide
        $moisRemplis =  $this->verificationMoisRepo->findAll();
        // on boucle les mois et on remet dans un autre tableau ceux qui ne sont 
        // pas encore rempli
        $moisVide = array_fill_keys(array('Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'), '');
        foreach ($this->sabbatsAnnuel() as $key => $sabbat) {
            if (count($moisRemplis) > 0) {
                foreach ($moisRemplis as $mois) {

                    if (explode('_', $mois->getMois())[0] != $key) {
                        $moisVide[$key] = $sabbat;
                    } else {
                        unset($moisVide[$key]);
                    }
                }
            } else {
                $moisVide = $this->sabbatsAnnuel();
            }
        }


        return $this->render('/mpitondra_raharaha/new.html.twig', [
            'sabbatParMois' => $moisVide,
            'mambras' => $this->mambraRepo->findMambraAfakaMitondraRaharaha(),
            'familles' => $this->familleRepo->findAll()

        ]);
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
}
