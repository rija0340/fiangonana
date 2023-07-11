<?php

namespace App\Controller;

use App\Entity\HiraChoral;
use App\Entity\HistoriqueHiraChoral;
use App\Form\HiraChoralType;
use App\Form\HistoriqueHiraChoralType;
use App\Repository\HiraChoralRepository;
use App\Repository\HistoriqueHiraChoralRepository;
use App\Service\ApplicationGlobals;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/hira/choral")
 */
class HiraChoralController extends AbstractController
{

    private $historiqueRepo;
    private $hiraChoralRepo;
    private $applicationGlobals;
    public function __construct(
        HistoriqueHiraChoralRepository $historiqueRepo,
        HiraChoralRepository $hiraChoralRepo,
        ApplicationGlobals $applicationGlobals
    ) {
        $this->historiqueRepo = $historiqueRepo;
        $this->hiraChoralRepo = $hiraChoralRepo;
        $this->applicationGlobals = $applicationGlobals;
    }

    /**
     * @Route("/", name="hira_choral_index", methods={"GET"})
     */
    public function index(HiraChoralRepository $hiraChoralRepository): Response
    {
        return $this->render('hira_choral/index.html.twig', [
            'hira_chorals' => $hiraChoralRepository->findAll(),
            'activitesChoral' => $this->applicationGlobals->getActiviteChoral()
        ]);
    }
    /**
     * @Route("/creation", name="hira_choral_creation", methods={"GET"})
     */
    public function creationHira()
    {
        $arrayOne = [
            0 =>  "Ankohonan'ny RAY",
            1 =>  'Apetraho eo aminy',
            2 =>  'Apetrako',
            3 =>  'Asandratray',
            4 =>  'Derao JESO',
            5 =>  'Ekeo anio JESO',
            6 =>  'Eo aminao',
            7 =>  'Faly ny fo',
            8 =>  'Fifaliako',
            9 =>  'Haleloia',
            10 =>  'Ho avy izy',
            11 =>  'Hobio Jeso',
            12 =>  'Indro raiso tompo ô',
            13 =>  'Inty aho JESO',
            14 =>  'JESO mamiko ianao',
            15 =>  'Jehovah tomponay',
            16 =>  "Jeso lay zanakin'ny RAY",
            17 =>  'Jeso ndreto izahay',
            18 =>  'Lay JESO mpamonjy anao',
            19 =>  'Lehibe',
            20 =>  'Manatona ny mpamonjy',
            21 =>  'Miantso anao ny tompo',
            22 =>  'Mifalia',
            23 =>  'Mifohaza',
            24 =>  'Mila midera',
            25 =>  'Misy tantara iray',
            26 =>  'Moa ve efa mba renao',
            27 =>  'Ny fahasoavanao',
            28 =>  'Ny famindram-ponao jeso',
            29 =>  'Ny famonjen\'i JESO',
            30 =>  'Ny famonjena',
            31 =>  'Ny faniriako hatrizao JESO',
            32 =>  'Ny hatsaranao',
            33 =>  'O banjino',
            34 =>  'RFA',
            35 =>  'Ry salema',
            36 =>  'Segneur ton amour',
            37 =>  'Tanora ô',
            38 =>  'Tiako ianao JESO',
            39 =>  'Tiako ianao jeso {play back}',
            40 =>  'Tsy misy',
            41 =>  'Vaoavao mahafaly',
            42 =>  'Vavaka',
            43 =>  'Vavaka 2',
            44 =>  'Voninahitra',
            45 =>  'Voninahitra ho anao JESO',
            46 =>  'fiainam-baovao',
            47 =>  'ho anao jeso',
            48 =>  'indro jeso voc',
            49 =>  'jeso tompo',
            50 =>  'seigneur',
            51 =>  'tsy ho ela',
            52 =>  'Ö impiry moa',
            53 =>  'ô mifalia',
            65 =>  'Ianao jesosy ô',
            66 =>  'Indro JESO',
            70 =>  'JESO mamiko ianao _Old1',
            73 =>  'Jeso lay zanaky ny ray',
            76 =>  'Lay Jeso mpamonjy anao',
            80 =>  'Miantso anao ny tompo01',
            85 =>  'Misy tantara iray_Old1',
            87 =>  'Moa ve efa vocal',
            88 =>  'Nty aho JESO',
            92 =>  'Ny famonjen\'i jeso',
            95 =>  'Ny faniriako hatrizao JESO_Old1',
            97 =>  'Ny hatsaranao_New1',
            100 =>  'Ry jehovah tomponay',
            103 =>  'TIAKO IANAO JESO',
            109 =>  'Vavaka (solo)',
            110 =>  'Vavaka 1',
            119 =>  'ô banjino'
        ];

        $arrayTwo = [
            1 =>  'Ampianaro aho Tompo',
            2 =>  'Andriamanitra Mpamorona',
            3 =>  'Azoko antoka ny fandresena',
            4 =>  'CAF enter1',
            5 =>  'Derainay Ianao JESO',
            6 =>  'Eny havaozy Tompo ô',
            7 =>  'Eto ny voninahitr\'Andriamanitra',
            8 =>  'Fanantenana ho anao',
            9 =>  'Fifaliako',
            10 =>  'Fifaliana ho ahy',
            11 =>  'Folder',
            12 =>  'Haleloia',
            13 =>  'Henoy ny vavakay',
            14 =>  'Ho anao manontolo  B',
            15 =>  'Ho anao manontolo  C',
            16 =>  'Ho anao manontolo',
            17 =>  'Ho any an-danitra isika',
            18 =>  'Ho avy JESO',
            19 =>  'Ho hitantsika JESOSY',
            20 =>  'ILAY TANY VAOVAO',
            21 =>  'Ianao Mpamonjy master',
            22 =>  'Ilay fanantenana lehibe',
            23 =>  'Indro JESO version',
            24 =>  'Indro ny mpanjaka',
            25 =>  'Inty aho JESO',
            26 =>  'Izao anio izao',
            27 =>  'Izao no ora',
            28 =>  'JESO Mahatoky anao',
            29 =>  'JESO avy any nazareta',
            30 =>  'JESO be fitiavana ianao',
            31 =>  'JESO be fitiavana remix',
            32 =>  'JESO isaorako ianao',
            33 =>  'JESO lay sakaiza tsy mandao',
            34 =>  'JESO malala ô, omeko anao',
            35 =>  'JESO mamiko ianao',
            36 =>  'JESO sakaizako hatrizao',
            37 =>  'JESO tsara indrindra',
            38 =>  'JESOSY no mpamonjy',
            39 =>  'Je vis pour JESUS',
            40 =>  'Jereo JESO Fanantenana',
            41 =>  'Jerosalema',
            42 =>  'Jeso no hany famonjena',
            43 =>  'Jeso ny fianako eo aminao',
            44 =>  'Jesosy sy izaho',
            45 =>  'Lay JESO Mpamonjy anao',
            46 =>  'Lay sakaiza',
            47 =>  'Manantona',
            48 =>  'Manendry anao JESO',
            49 =>  'Masina Ianao JESO',
            50 =>  'Midera anao',
            51 =>  'Misaotra ny Ray',
            52 =>  'Mivavaka aho',
            53 =>  'Ny Andriamanitro',
            54 =>  'Ny akaikinao JESO',
            55 =>  'Ny famonjen\'i JESO',
            56 =>  'Ny fitiavanao JESO',
            57 =>  'Ny hafatra ho anao',
            58 =>  'Ny hasambarako',
            59 =>  'Ny hatsaranao',
            60 =>  'Ny herinao',
            61 =>  'Ny manompo anao JESO',
            62 =>  'Omeo azy',
            65 =>  'Raha mbola velona',
            66 =>  'Raha sendra',
            67 =>  'Ray ô!',
            68 =>  'Resy lahatra aho JESO',
            69 =>  'Ry JEHOVAH Tomponay',
            70 =>  'Ry TOMPO ô mpahary',
            71 =>  'TOMPO be indrafo',
            72 =>  'Te hahita anao aho',
            73 =>  'Tena ho avy izy',
            74 =>  'Tena tiako Ianao JESO',
            75 =>  'Vatolampiko mandrakizay',
            76 =>  'Vavaka',
            77 =>  'Voninahitra ho anao JESO',
            83 =>  'ô Impiry moa',
            84 =>  'ô! Mifalia',
            85 =>  'Ambarao ny voninahiny',
            86 =>  'Asandratray ny feo',
            87 =>  'Hiverina aminao',
            88 =>  'Ho hitantsika jesosy',
            89 =>  'Lazao ny fanantenanao',
            90 =>  'Lehibe ny anaranao',
            91 =>  'Mpandresy',
            92 =>  'Raha ho avy Ianao JESO',
            93 =>  'Tonga tety JESO',
            94 =>  'Voninahitra ho anao irery ihany',
            101 =>  'IZAO NO ORA',
            102 =>  'JEROSALEMA',
            105 =>  'MANENDRY ANAO',
            109 =>  'Ry jehovah tomponay',
            111 =>  'ô! mifalia'

        ];


        $merged = array_merge($arrayOne, $arrayTwo);

        $unique = array_unique($merged);

        foreach ($unique as  $titre) {
            $hira = new HiraChoral();
            $hira->setTitre(trim($titre));
            $hira->setCle("");
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($hira);
            $entityManager->flush();
        }
        dd("operation terminé");
    }

    /**
     * @Route("/add-historique/{id}", name="hira_choral_add_historique", methods={"GET","POST"})
     */
    public function addHistorique(HiraChoral $hiraChoral, Request $request): Response
    {

        $historique = new HistoriqueHiraChoral();

        $historique->addHira($hiraChoral);
        $historique->setDoneAt(new DateTime($request->get('doneAt')));
        $historique->setFotoana($request->get('fotoana'));
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($historique);
        $entityManager->flush();

        return $this->redirectToRoute('hira_choral_historique', [], Response::HTTP_SEE_OTHER);

        // $historique = new HistoriqueHiraChoral();
        // $formHistorique = $this->createForm(HistoriqueHiraChoralType::class, $historique);
        // $formHistorique->handleRequest($request);

        // if ($formHistorique->isSubmitted() && $formHistorique->isValid()) {
        //     $entityManager = $this->getDoctrine()->getManager();
        //     $entityManager->persist($historique);
        //     $entityManager->flush();

        //     return $this->redirectToRoute('hira_choral_historique', [], Response::HTTP_SEE_OTHER);
        // }

        // $historique = $this->historiqueRepo->findAll();
        // $historique_json = json_encode($historique);
        // return $this->renderForm('hira_choral/historique.html.twig', [
        //     'formHistorique' => $formHistorique,
        //     'historique_json' => $historique_json,
        // ]);
    }

    /**
     * @Route("/tableau-de-bord", name="hira_choral_dashboard", methods={"GET"})
     */
    public function dashboard(): Response
    {

        $historiques = $this->historiqueRepo->findBy(array(), array('doneAt' => 'DESC'));

        $hiraChoral = $this->hiraChoralRepo->findAll();
        $totalNbrHira = count($hiraChoral);

        $hiraCulte = [];
        $hiraHariva = [];
        $hiraRepetition = [];
        $hiraPriseDeSon = [];
        $hiraPriseDeVue = [];

        // dd($historiques);

        foreach ($historiques as $key => $historique) {
            $fotoana = $historique->getFotoana();
            $fotoana = trim(strval($fotoana));

            $hiras = $historique->getHira();
            switch ($fotoana) {
                case 'Culte':
                    foreach ($hiras as $key => $hira) {
                        array_push($hiraCulte, ['hira' => $hira, 'date' => $historique->getDoneAt()->format('d-m-Y')]);
                        // if (count($hiraCulte) == 5) {
                        //     break 3;
                        // }
                    }
                    break;
                case 'Sabata Hariva':
                    foreach ($hiras as $key => $hira) {
                        array_push($hiraHariva,  ['hira' => $hira, 'date' => $historique->getDoneAt()->format('d-m-Y')]);
                        // if (count($hiraHariva) == 5) {
                        //     break 3;
                        // }
                    }
                    break;
                case 'Répétition':
                    foreach ($hiras as $key => $hira) {
                        array_push($hiraRepetition,  ['hira' => $hira, 'date' => $historique->getDoneAt()->format('d-m-Y')]);
                        // if (count($hiraRepetition) == 5) {
                        //     break 3;
                        // }
                    }
                    break;
                case 'Prise de son':
                    foreach ($hiras as $key => $hira) {
                        array_push($hiraPriseDeSon,  ['hira' => $hira, 'date' => $historique->getDoneAt()->format('d-m-Y')]);
                        // if (count($hiraPriseDeSon) == 5) {
                        //     break 3;
                        // }
                    }
                    break;
                case 'Prise de vue':
                    foreach ($hiras as $key => $hira) {
                        array_push($hiraPriseDeVue,  ['hira' => $hira, 'date' => $historique->getDoneAt()->format('d-m-Y')]);
                        // if (count($hiraPriseDeVue) == 5) {
                        //     break 3;
                        // }
                    }
                    break;
                default:
                    foreach ($hiras as $key => $hira) {
                        array_push($hiraRepetition, ['hira' => $hira, 'date' => $historique->getDoneAt()->format('d-m-Y')]);
                        // if (count($hiraRepetition) == 5) {
                        //     break 3;
                        // }
                    }
                    break;
            }
        }

        //liste hira n'appartenant à aucun des tableaux(culte, hariva, repetition) 5 derniers
        $hiraAllHistorique = array_merge($hiraCulte, $hiraHariva, $hiraRepetition);
        $mergeHistorique = [];
        foreach ($hiraAllHistorique as $key => $hira) {
            array_push($mergeHistorique, $hira['hira']);
        }

        // transformation de historqiue2 en array of array
        $mergeIdHistorique = []; //id des hira
        foreach ($mergeHistorique as $key => $hira) {
            array_push($mergeIdHistorique, $hira->getId());
        }

        $notInHistorique = [];
        //on prend les hira qui ne sont pas dans les hitsorique dans un tableau
        foreach ($hiraChoral as $key => $hira) {
            if (!in_array($hira->getId(), $mergeIdHistorique)) {
                array_push($notInHistorique, $hira->getId());
            }
        }

        //on recherche les historiques des hira non appartenant aux trois categories
        //et on get s'ils ont des historiques ou pas
        $hiraNotIn3Historique = [];
        foreach ($notInHistorique as $key => $id) {

            $hira = $this->hiraChoralRepo->find(intval($id));
            $historiqueHira = $hira->getHistoriqueHiraChorals();

            // $historiques = $this->historiqueRepo->findBy(['hira' => $hira->getId()], array('doneAt' => 'DESC'));

            if (count($historiqueHira)  > 0) {

                $idHistoriqueHira = [];
                foreach ($historiqueHira as $key => $historique) {
                    array_push($idHistoriqueHira, $historique->getId());
                }
                //DESC sort
                rsort($idHistoriqueHira);
                // la derniere historique d'une chanson
                //date akaik ndrindra nanaovana azy
                $finalHistoriqueHiraRay = [];
                foreach ($idHistoriqueHira as $key => $id) {
                    array_push($finalHistoriqueHiraRay, $this->historiqueRepo->find(intval($id)));
                }

                array_push($hiraNotIn3Historique, ['hira' => $hira, 'date' => $finalHistoriqueHiraRay[0]->getDoneAt()->format('d-m-Y')]);
            } else {

                array_push($hiraNotIn3Historique, ['hira' => $hira, 'date' => null]);
            }
        }

        return $this->render('hira_choral/dashboard.html.twig', [
            'hiraCulte' => $hiraCulte,
            'hiraHariva' => $hiraHariva,
            'hiraRepetition' => $hiraRepetition,
            'hiraPriseDeSon' => $hiraPriseDeSon,
            'hiraPriseDeVue' => $hiraPriseDeVue,
            'totalNbrHira' => $totalNbrHira,
            'hiraNotIn3Historique' => $hiraNotIn3Historique
        ]);
    }

    /**
     * @Route("/historique", name="hira_choral_historique", methods={"GET","POST"})
     */
    public function historique(Request $request): Response
    {

        $historique = new HistoriqueHiraChoral();
        $formHistorique = $this->createForm(HistoriqueHiraChoralType::class, $historique);
        $formHistorique->handleRequest($request);

        if ($formHistorique->isSubmitted() && $formHistorique->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($historique);
            $entityManager->flush();

            return $this->redirectToRoute('hira_choral_historique', [], Response::HTTP_SEE_OTHER);
        }

        $historique = $this->historiqueRepo->findAll();
        $historique_json = json_encode($historique);
        return $this->renderForm('hira_choral/historique.html.twig', [
            'formHistorique' => $formHistorique,
            'historique_json' => $historique_json,
        ]);
    }

    /**
     * @Route("/historique-data", name="hira_choral_historique_data", methods={"GET","POST"})
     */
    public function historiqueData(Request $request): JsonResponse
    {

        $historiques = $this->historiqueRepo->findAll();

        $test = [];
        $allData = [];
        foreach ($historiques as $key => $historique) {

            $d = $historique->getDoneAt()->format('d');
            $m = $historique->getDoneAt()->format('m');
            $y = $historique->getDoneAt()->format('Y');

            $hiras = $historique->getHira();
            $titre = '';

            //un evenement pour chaque hira
            foreach ($hiras as $key => $hira) {
                $titre = $hira->getTitre();
                $test = [
                    'title' => $titre . "(" . $historique->getFotoana() . ")",
                    'description' => $historique->getFotoana(),
                    'start' => $historique->getDoneAt()->format("Y-m-d"),
                    'backgroundColor' => '#f56954', // red
                    'borderColor' => '#f56954', // red
                    'allDay' => true
                ];
                array_push($allData, $test);
            }
        }

        return new JsonResponse($allData);
    }

    /**
     * @Route("/new", name="hira_choral_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $hiraChoral = new HiraChoral();
        $form = $this->createForm(HiraChoralType::class, $hiraChoral);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($hiraChoral);
            $entityManager->flush();

            return $this->redirectToRoute('hira_choral_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('hira_choral/new.html.twig', [
            'hira_choral' => $hiraChoral,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="hira_choral_show", methods={"GET"})
     */
    public function show(HiraChoral $hiraChoral): Response
    {
        return $this->render('hira_choral/show.html.twig', [
            'hira_choral' => $hiraChoral,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="hira_choral_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, HiraChoral $hiraChoral): Response
    {
        $form = $this->createForm(HiraChoralType::class, $hiraChoral);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('hira_choral_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('hira_choral/edit.html.twig', [
            'hira_choral' => $hiraChoral,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="hira_choral_delete", methods={"POST"})
     */
    public function delete(Request $request, HiraChoral $hiraChoral): Response
    {
        if ($this->isCsrfTokenValid('delete' . $hiraChoral->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($hiraChoral);
            $entityManager->flush();
        }

        return $this->redirectToRoute('hira_choral_index', [], Response::HTTP_SEE_OTHER);
    }
}
