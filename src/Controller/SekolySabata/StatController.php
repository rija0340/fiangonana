<?php

namespace App\Controller\SekolySabata;

use App\Repository\KilasyRepository;
use App\Repository\MambraRepository;
use App\Repository\RegistreRepository;
use DateInterval;
use DatePeriod;
use DateTime;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("sekoly-sabata/stat")
 */
class StatController extends AbstractController
{


    private $registreRepo;
    private $flashy;
    private $kilasyRepo;
    private $mambraRepo;

    public function __construct(
        RegistreRepository $registreRepo,
        FlashyNotifier $flashy,
        KilasyRepository $kilasyRepo,
        MambraRepository $mambraRepo

    ) {
        $this->flashy = $flashy;
        $this->registreRepo = $registreRepo;
        $this->kilasyRepo = $kilasyRepo;
        $this->mambraRepo = $mambraRepo;
    }

    /**
     * @Route("/", name="stat_index", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('sekolySabata/stat/index.html.twig');
    }


    /**
     * @Route("/compose", name="stat_compose", methods={"GET","POST"})
     */
    public function statCompose(Request $request): Response
    {

        $dateDebutIntervalString = $request->get('dateDebut');
        $dateFinIntervalString = $request->get('dateFin');
        $dateDebutInterval = new DateTime($dateDebutIntervalString);
        $dateDebutIntervalOriginal = new DateTime($dateDebutIntervalString);
        $dateFinInterval = new DateTime($dateFinIntervalString);
        //tatitra nandritra ny dateRange
        $registresDateRange = $this->registreRepo->findRegistresByDates($dateDebutInterval, $dateFinInterval, null);
        // dd($registresDateRange);
        //************************** ********/
        // tatitra kilasy rehetra mitambatra
        //************************** *******/

        $tatitraMitambatraDateRange = $this->getTatitra($registresDateRange);

        // FIN tatitra kilasy rehetra mitambatra
        //************************** ********/
        //************************** *******/

        //tatitra general par mois 
        $datesParMois = $this->intervalToParMois($dateDebutInterval, $dateFinInterval);
        // dd($dateDebutInterval, $dateFinInterval);

        $tatitraMitambatraParMoisDateRange = [];
        if (!empty($datesParMois)) {
            foreach ($datesParMois as $key => $mois) {
                $dateDebut = new DateTime(reset($mois));
                $dateFin = new DateTime(end($mois));
                $registresDateRange2 = $this->registreRepo->findRegistresByDates($dateDebut, $dateFin, null);
                $tatitraMitambatraParMoisDateRange[$dateDebut->format('F')] = $this->getTatitra($registresDateRange2);
            }
        }

        //liste kilasy par liste des registres 
        $listeIdKilasy  = $this->getListeKilasy($registresDateRange);

        //loop listeKilasy et get tatitra général dateRange
        $tatitraKilasyRehetra[] = [];
        foreach ($listeIdKilasy as $key => $id) {

            $registresKilasy = $this->registreRepo->findRegistresKilasyByDates($dateDebutIntervalOriginal, $dateFinInterval, $id);
            $tatitraKilasy = $this->getTatitraKilasy($registresKilasy);
            if (!empty($tatitraKilasy)) {
                array_push($tatitraKilasyRehetra, $tatitraKilasy);
            }
        }
        //organisé par classe le tableau (nombre de key nombre de classe)
        $tatitraKilasyRehetraRendu =  $this->render('sekolySabata/stat/kilasyRehetra/kilasyRehetra.html.twig', [
            'items' => $tatitraKilasyRehetra,
            'dateDebut' => $dateDebutIntervalOriginal->format('d/m/Y'),
            'dateFin' => $dateFinInterval->format('d/m/Y'),
        ])->getContent();

        $tatitraGeneralParMoisRendu =  $this->render('sekolySabata/stat/general/par_mois.html.twig', [
            'tatitraMitambatraParMoisDateRange' => $tatitraMitambatraParMoisDateRange,
            'dateDebut' => $dateDebutIntervalOriginal->format('d/m/Y'),
            'dateFin' => $dateFinInterval->format('d/m/Y'),
        ])->getContent();

        $tatitraGeneralRendu =  $this->render('sekolySabata/stat/general/compose.html.twig', [
            'tatitraMitambatraDateRange' => $tatitraMitambatraDateRange,
            'dateDebut' => $dateDebutIntervalOriginal->format('d/m/Y'),
            'dateFin' => $dateFinInterval->format('d/m/Y'),
        ])->getContent();

        // former data pour chart
        foreach ($tatitraMitambatraParMoisDateRange as $key => $value) {
            $labels[] = $key;
            $tongaMambraRejitraData[] = isset($value['pourcentTongaDateRange']) ? $value['pourcentTongaDateRange'] : 0;
            $impitoMambraTongaData[] = isset($value['pourcentImpitoTongaDateRange']) ? $value['pourcentImpitoTongaDateRange'] : 0;
            $impitoMambraRejitraData[] = isset($value['pourcentImpitoRejistraDateRange']) ? $value['pourcentImpitoRejistraDateRange'] : 0;
        }
        return new JsonResponse([
            'tatitraGeneralParMois' => $tatitraMitambatraParMoisDateRange != null ?  $tatitraGeneralParMoisRendu : '',
            'dateDebut' => $dateDebutInterval->format('d/m/Y'),
            'dateFin' => $dateFinInterval->format('d/m/Y'),
            'tatitraGeneral' => $tatitraGeneralRendu,
            'tatitraRehetra' => $tatitraKilasyRehetraRendu,
            'labels' =>  isset($labels) ? $labels : [],
            'tongaMambraRejitraData' => isset($tongaMambraRejitraData) ? $tongaMambraRejitraData : [],
            'impitoMambraTongaData' => isset($impitoMambraTongaData) ? $impitoMambraTongaData : [],
            'impitoMambraRejitraData' =>  isset($impitoMambraRejitraData) ? $impitoMambraRejitraData : []

        ]);
    }

    public function intervalToParMois($dateDebutF, $dateFinF)
    {

        $datesParMois = [];
        $d1 = $dateDebutF;
        $d = $dateDebutF;
        $d2 =  $dateFinF;

        while ($d1 <= $d2) {
            if ($d1->format('N') == 6) {
                $mois = $d1->format('F');

                $datesParMois[$mois][] = $d1->format('Y-m-d');
            }
            $d1->modify('+1 day');
        }
        return $datesParMois;
    }

    public function getTatitra($registres, $type = null)
    {

        $asaSoaDateRange = 0;
        $kilasy = "";
        $asafiDateRange = 0;
        $fampianaranaBaibolyDateRange = 0;
        $bokyTraktaDateRange = 0;
        $semineraKaoferansaDateRange = 0;
        $nahavitaFampTaratasyDateRange = 0;
        $batisaTamiDateRange = 0;
        $nombreRegistre = 0;
        $pourcentTongaDateRange = 0;
        $pourcentImpitoTongaDateRange = 0;
        $pourcentImpitoRejistraDateRange = 0;
        $totalFanatitra = 0;

        $tatitra = [];

        foreach ($registres as $registre) {
            if ($registre != null) {

                if ($type == 'kilasy') { //$registresDateRange est un array of registre

                    $nombreRegistre++;
                    $kilasy = $registre->getKilasy()->getNom();
                    $asaSoaDateRange += $registre->getAsaSoa();

                    $asafiDateRange +=  $registre->getAsafi();
                    $fampianaranaBaibolyDateRange +=  $registre->getFampianaranaBaiboly();
                    $bokyTraktaDateRange +=  $registre->getBokyTrakta();
                    $semineraKaoferansaDateRange +=  $registre->getSemineraKaoferansa();
                    $nahavitaFampTaratasyDateRange +=  $registre->getNahavitaFampTaratasy();
                    $batisaTamiDateRange += $registre->getBatisaTami();
                    $totalFanatitra += $registre->getFanatitra();

                    $pourcentTongaDateRange += $this->getPourcentTonga($registre->getMambraTonga(), $registre->getNbrMambraKilasy());
                    $pourcentImpitoTongaDateRange += $this->getPourcentImpitoTonga($registre->getMambraTonga(), $registre->getNianatraImpito());
                    $pourcentImpitoRejistraDateRange += $this->getPourcentImpitoRejistra($registre->getNianatraImpito(), $registre->getNbrMambraKilasy());
                } else if ($type == null) { //registresDateRange est un array of array of registre
                    foreach ($registre as $registre) {

                        $nombreRegistre++;
                        $asaSoaDateRange += $registre->getAsaSoa();
                        $asafiDateRange +=  $registre->getAsafi();
                        $fampianaranaBaibolyDateRange +=  $registre->getFampianaranaBaiboly();
                        $bokyTraktaDateRange +=  $registre->getBokyTrakta();
                        $semineraKaoferansaDateRange +=  $registre->getSemineraKaoferansa();
                        $nahavitaFampTaratasyDateRange +=  $registre->getNahavitaFampTaratasy();
                        $batisaTamiDateRange += $registre->getBatisaTami();
                        $totalFanatitra += $registre->getFanatitra();

                        $pourcentTongaDateRange += $this->getPourcentTonga($registre->getMambraTonga(), $registre->getNbrMambraKilasy());
                        $pourcentImpitoTongaDateRange += $this->getPourcentImpitoTonga($registre->getMambraTonga(), $registre->getNianatraImpito());
                        $pourcentImpitoRejistraDateRange += $this->getPourcentImpitoRejistra($registre->getNianatraImpito(), $registre->getNbrMambraKilasy());
                    }
                } else if ($type == 'sabata') {

                    $mambraTonga = 0;
                    $mpamangy = 0;
                    $tongaRehetra = 0;
                    $impito = 0;
                    $asasoa = 0;
                    $asafi = 0;
                    $fampianaranaBaiboly = 0;
                    $bokyNaTrakta = 0;
                    $semineraKaoferansa = 0;
                    $alasarona = 0;
                    $nahavitaFampianaranaTaratasy = 0;
                    $batisaTami = 0;
                    $fanatitra = 0;

                    foreach ($registres as $registre) {
                        if ($registre != null) {
                            $mambraTonga += $registre->getMambraTonga();
                            $mpamangy += $registre->getMpamangy();
                            $tongaRehetra += $registre->getTongaRehetra();
                            $impito += $registre->getNianatraImpito();
                            $asafi += $registre->getAsafi();
                            $asasoa += $registre->getAsaSoa();
                            $fampianaranaBaiboly += $registre->getFampianaranaBaiboly();
                            $bokyNaTrakta += $registre->getBokyTrakta();
                            $semineraKaoferansa += $registre->getSemineraKaoferansa();
                            $alasarona += $registre->getAlasarona();
                            $nahavitaFampianaranaTaratasy += $registre->getNahavitaFampTaratasy();
                            $batisaTami += $registre->getBatisaTami();
                            $fanatitra += $registre->getFanatitra();

                            // $mambraKilasyRehetra = $this->mambraRepo->findMambra($registre->getKilasy());
                            $mambraKilasyRehetra = $registre->getNbrMambraKilasy();

                            //pour chaque classe construire les 3 stats
                            $pourcentKilasy = [
                                'pourcentTonga' => $this->getPourcentTonga($registre->getMambraTonga(), $mambraKilasyRehetra),
                                'pourcentImpitoTonga' => $this->getPourcentImpitoTonga($registre->getMambraTonga(), $registre->getNianatraImpito()),
                                'pourcentImpitoRejistra' => $this->getPourcentImpitoRejistra($registre->getNianatraImpito(), $mambraKilasyRehetra),
                                'kilasyId' => $registre->getKilasy()->getId()
                            ];
                            $allPourcent[$registre->getKilasy()->getId()] = $pourcentKilasy;
                        }
                    }
                    return [
                        'registres' => $registres,
                        'totalMambraTonga'      => $mambraTonga,
                        'totalMpamangy'        => $mpamangy,
                        'totalTongaRehetra'    => $tongaRehetra,
                        'totalNianatraImpito'     => $impito,
                        'totalAsaSoa'    => $asasoa,
                        'totalAsafi'    => $asafi,
                        'totalFampianaranaBaiboly'   => $fampianaranaBaiboly,
                        'totalBokyTrakta'    => $bokyNaTrakta,
                        'totalSemineraKaoferansa'   => $semineraKaoferansa,
                        'totalAlasarona'    => $alasarona,
                        'totalNahavitaFampTaratasy'    => $nahavitaFampianaranaTaratasy,
                        'totalBatisaTami'     => $batisaTami,
                        'totalFanatitra'    => $fanatitra,
                        'allPourcent' => $allPourcent
                    ];
                }
            }
        }
        if ($nombreRegistre > 0) {
            $tatitra['kilasy'] = $kilasy;
            $tatitra['asaSoaDateRange'] = $asaSoaDateRange;
            $tatitra['asafiDateRange'] = $asafiDateRange;
            $tatitra['fampianaranaBaibolyDateRange'] = $fampianaranaBaibolyDateRange;
            $tatitra['bokyTraktaDateRange'] = $bokyTraktaDateRange;
            $tatitra['semineraKaoferansaDateRange'] = $semineraKaoferansaDateRange;
            $tatitra['nahavitaFampTaratasyDateRange'] = $nahavitaFampTaratasyDateRange;
            $tatitra['batisaTamiDateRange'] = $batisaTamiDateRange;
            $tatitra['totalFanatitra'] = $totalFanatitra;
            $tatitra['pourcentTongaDateRange'] = $pourcentTongaDateRange / $nombreRegistre;
            $tatitra['pourcentImpitoTongaDateRange'] = $pourcentImpitoTongaDateRange / $nombreRegistre;
            $tatitra['pourcentImpitoRejistraDateRange'] = $pourcentImpitoRejistraDateRange / $nombreRegistre;
        }

        return $tatitra;
    }

    /**
     * @Route("/sabata", name="stat_sabata", methods={"GET","POST"})
     */
    public function sabata(Request $request): Response
    {

        $stringDate = $request->get('dateSabata');

        if ($stringDate != null) {

            $date = new DateTime($stringDate);
            $registres = $this->registreRepo->findBy(['createdAt' => $date]);

            if (count($registres) == 0) {
                $this->flashy->error("Tsy misy registre amin'io date io");
                return $this->redirectToRoute("stat_index");
            }
            $tatitraSabata = $this->getTatitra($registres, 'sabata');

            return $this->render('sekolySabata/stat/sabata.html.twig', [
                'dateSabata' => $date->format('d/m/Y'),
                'registres' => $registres,
                'totalMambraTonga'      => $tatitraSabata['totalMambraTonga'],
                'totalMpamangy'        => $tatitraSabata['totalMpamangy'],
                'totalTongaRehetra'    => $tatitraSabata['totalTongaRehetra'],
                'totalNianatraImpito'     => $tatitraSabata['totalNianatraImpito'],
                'totalAsafi'     => $tatitraSabata['totalAsafi'],
                'totalAsaSoa'    => $tatitraSabata['totalAsaSoa'],
                'totalFampianaranaBaiboly'   => $tatitraSabata['totalFampianaranaBaiboly'],
                'totalBokyTrakta'    => $tatitraSabata['totalBokyTrakta'],
                'totalSemineraKaoferansa'   => $tatitraSabata['totalSemineraKaoferansa'],
                'totalAlasarona'    => $tatitraSabata['totalAlasarona'],
                'totalNahavitaFampTaratasy'    => $tatitraSabata['totalNahavitaFampTaratasy'],
                'totalBatisaTami'     => $tatitraSabata['totalBatisaTami'],
                'totalFanatitra'    => $tatitraSabata['totalFanatitra'],
                'allPourcent' => $tatitraSabata['allPourcent']
            ]);
        } else {
            return  $this->redirectToRoute('stat_index');
        }
    }


    /** 
     * cette fonction retourne stat d'un sabbat
     * @param Registre[] $registres
     * @return array() of registre
     */
    // public function getTatitraSabata($registres)
    // {
    //     $mambraTonga = 0;
    //     $mpamangy = 0;
    //     $tongaRehetra = 0;
    //     $impito = 0;
    //     $asasoa = 0;
    //     $asafi = 0;
    //     $fampianaranaBaiboly = 0;
    //     $bokyNaTrakta = 0;
    //     $semineraKaoferansa = 0;
    //     $alasarona = 0;
    //     $nahavitaFampianaranaTaratasy = 0;
    //     $batisaTami = 0;
    //     $fanatitra = 0;
    //     //atao anaty tableau hafa dia asaina id class oatra dia checkena anaty twig avy eo 
    //     $allPourcent = [];
    //     foreach ($registres as $registre) {
    //         if ($registre != null) {
    //             $mambraTonga += $registre->getMambraTonga();
    //             $mpamangy += $registre->getMpamangy();
    //             $tongaRehetra += $registre->getTongaRehetra();
    //             $impito += $registre->getNianatraImpito();
    //             $asafi += $registre->getAsafi();
    //             $asasoa += $registre->getAsaSoa();
    //             $fampianaranaBaiboly += $registre->getFampianaranaBaiboly();
    //             $bokyNaTrakta += $registre->getBokyTrakta();
    //             $semineraKaoferansa += $registre->getSemineraKaoferansa();
    //             $alasarona += $registre->getAlasarona();
    //             $nahavitaFampianaranaTaratasy += $registre->getNahavitaFampTaratasy();
    //             $batisaTami += $registre->getBatisaTami();
    //             $fanatitra += $registre->getFanatitra();

    //             // $mambraKilasyRehetra = $this->mambraRepo->findMambra($registre->getKilasy());
    //             $mambraKilasyRehetra = $registre->getNbrMambraKilasy();

    //             //pour chaque classe construire les 3 stats
    //             $pourcentKilasy = [
    //                 'pourcentTonga' => $this->getPourcentTonga($registre->getMambraTonga(), $mambraKilasyRehetra),
    //                 'pourcentImpitoTonga' => $this->getPourcentImpitoTonga($registre->getMambraTonga(), $registre->getNianatraImpito()),
    //                 'pourcentImpitoRejistra' => $this->getPourcentImpitoRejistra($registre->getNianatraImpito(), $mambraKilasyRehetra),
    //                 'kilasyId' => $registre->getKilasy()->getId()
    //             ];
    //             $allPourcent[$registre->getKilasy()->getId()] = $pourcentKilasy;
    //         }
    //     }

    //     return [
    //         'registres' => $registres,
    //         'totalMambraTonga'      => $mambraTonga,
    //         'totalMpamangy'        => $mpamangy,
    //         'totalTongaRehetra'    => $tongaRehetra,
    //         'totalNianatraImpito'     => $impito,
    //         'totalAsaSoa'    => $asasoa,
    //         'totalAsafi'    => $asafi,
    //         'totalFampianaranaBaiboly'   => $fampianaranaBaiboly,
    //         'totalBokyTrakta'    => $bokyNaTrakta,
    //         'totalSemineraKaoferansa'   => $semineraKaoferansa,
    //         'totalAlasarona'    => $alasarona,
    //         'totalNahavitaFampTaratasy'    => $nahavitaFampianaranaTaratasy,
    //         'totalBatisaTami'     => $batisaTami,
    //         'totalFanatitra'    => $fanatitra,
    //         'allPourcent' => $allPourcent
    //     ];
    // }

    /** 
     * cette fonction retourne liste kilasy from array of array of registre
     * @param Registre[][] 
     * @return array()
     */
    public function getListeKilasy($registresDateRange)
    {
        $listeIdKilasy = [];
        foreach ($registresDateRange as $key => $arrayRegistre) {
            foreach ($arrayRegistre as $key => $registre) {
                if (!in_array($registre->getKilasy()->getId(), $listeIdKilasy)) {
                    array_push($listeIdKilasy, $registre->getKilasy()->getId());
                }
            }
        }
        return $listeIdKilasy;
    }

    /** 
     * cette fonction permet d'avoir les stat concernant une seule classe 
     * @param Registre[] $registres //toutes les registres du date range
     * @return array() contenant les statistiques
     */
    public function getTatitraKilasy($registres)
    {
        return $this->getTatitra($registres, 'kilasy');
    }

    /** 
     * return pourcentage présence
     * par membre registre
     * @param kilasy sy date registre
     */
    public function getPourcentTonga($mambraTonga, $mambraKilasy)
    {

        $mambraKilasy = intval($mambraKilasy);
        $pourcentage = 0;
        if (($mambraKilasy > 0 && $mambraTonga > 0)) {

            $pourcentage  = ($mambraTonga * 100) / $mambraKilasy;
        }
        return $pourcentage;
    }

    /**
     * return pourcentage nianatra impito tonga
     */

    public function getPourcentImpitoTonga($mambraTonga, $nianatraImpito)
    {
        if ($mambraTonga != 0 && $nianatraImpito != 0) {
            $pourcentage = 0;
            $pourcentage  = ($nianatraImpito * 100) / $mambraTonga;

            return $pourcentage;
        } else {
            return 0;
        }
    }

    /**
     * return pourcentage nianatra impito mambra rejistra
     */
    public function getPourcentImpitoRejistra($nianatraImpito, $mambraKilasy)
    {
        $mambraKilasy = intval($mambraKilasy);
        $pourcentage = 0;
        if (($mambraKilasy > 0 && $nianatraImpito > 0) && ($mambraKilasy > $nianatraImpito)) {
            $pourcentage  = ($nianatraImpito * 100) / $mambraKilasy;
            return $pourcentage;
        } else {
            return 0;
        }
    }
}
