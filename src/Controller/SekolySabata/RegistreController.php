<?php

namespace App\Controller\SekolySabata;

use App\Entity\FianaranaLesona;
use App\Entity\Registre;
use App\Form\RegistreType;
use App\Repository\KilasyRepository;
use App\Repository\MambraRepository;
use App\Repository\RegistreRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("sekoly-sabata/registre")
 */
class RegistreController extends AbstractController
{

    private $kilasyRepo;
    private $mambraRepo;
    private $registreRepo;
    private $em;
    private $flashy;
    public function __construct(
        KilasyRepository $kilasyRepo,
        MambraRepository $mambraRepo,
        EntityManagerInterface $em,
        RegistreRepository $registreRepo,
        FlashyNotifier $flashy
    ) {
        $this->registreRepo = $registreRepo;
        $this->kilasyRepo = $kilasyRepo;
        $this->mambraRepo = $mambraRepo;
        $this->em = $em;
        $this->flashy = $flashy;
    }

    /**
     * @Route("/", name="registre_index", methods={"GET"})
     */
    public function index(RegistreRepository $registreRepository): Response
    {
        // get all dates
        $registres = $registreRepository->findAll();

        $dates = [];
        foreach ($registres as $registre) {
            array_push($dates, $registre->getCreatedAt()->format('d-m-Y'));
        }

        return $this->render('sekolySabata/registre/index.html.twig', [
            'registres' => $registreRepository->findAll(),
            'dates' => $dates
        ]);
    }

    /**
     * @Route("/new", name="registre_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        // dd($request);
        $registre = new Registre();
        $form = $this->createForm(RegistreType::class, $registre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //ajout nombre de personne dans kilasy dans bdd 
            $kilasy  = $registre->getKilasy();
            $mambra = $this->mambraRepo->findMambra($kilasy);
            $registre->setNbrMambraKilasy(count($mambra));

            //validation nombre saisie
            $entityManager = $this->getDoctrine()->getManager();
            // unique date et kilasy , should be done dans entity @unique
            $existingRegistres = $this->registreRepo->findBy(['createdAt' => $registre->getCreatedAt(), 'kilasy' => $registre->getKilasy()]);
            $valide = $this->validation($registre);

            if (count($existingRegistres) > 0 || $valide == false) {

                $this->flashy->error("Le registre existe ou erreur de données");
                return $this->redirectToRoute('registre_new');
            }

            $entityManager->persist($registre);
            $entityManager->flush();

            return $this->redirectToRoute('registre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('sekolySabata/registre/new.html.twig', [
            'registre' => $registre,
            'form' => $form,
        ]);
    }

    /**
     * cette fonction valide la logique des nombres saisie dans formulaire
     * @param entity registre 
     * @return boolean
     */
    public function  validation($registre)
    {
        //mambra tonga <= mambra rejistra
        $mambraRejistra = $this->mambraRepo->findMambra($registre->getKilasy());
        $mambraRejistra = count($mambraRejistra);
        $mambraTonga = $registre->getMambraTonga();
        $nianatraImpito = $registre->getNianatraImpito();
        $tongaRehetra = $registre->getTongaRehetra();

        // dd($mambraRejistra, $mambraTonga, $nianatraImpito, $tongaRehetra);
        if ($mambraTonga > $mambraRejistra) {
            return false;
        }
        if (($nianatraImpito > $mambraRejistra)
            || ($nianatraImpito > $tongaRehetra)
        ) {
            return false;
        }
        return true;
    }


    /**
     * @Route("/new-mambra", name="registre_new_mambra", methods={"GET","POST"})
     */
    public function newWithMambra(Request $request): Response
    {

        if ($request->request->has("mambra") && $request->request->has("registre")) {
            $mambras =  $request->request->get('mambra');
            $registreData = $request->request->get('registre');


            $registre = new Registre();
            $registre->setCreatedAt(new DateTime($registreData['createdAt']));
            $kilasy = $this->kilasyRepo->find(intval($registreData['kilasy']));
            $registre->setKilasy($kilasy);
            $registre->setCreatedAt(new DateTime($registreData['createdAt']));
            $registre->setMpamangy($registreData['mpamangy']);
            $registre->setAsaSoa($registreData['asaSoa']);
            $registre->setFampianaranaBaiboly($registreData['fampianaranaBaiboly']);
            $registre->setBokyTrakta($registreData['bokyTrakta']);
            $registre->setSemineraKaoferansa($registreData['semineraKaoferansa']);
            $registre->setAlasarona($registreData['alasarona']);
            $registre->setNahavitaFampTaratasy($registreData['nahavitaFampTaratasy']);
            $registre->setBatisaTami($registreData['batisaTami']);
            $registre->setFanatitra($registreData['fanatitra']);
            $registre->setMambraTonga(7);
            $registre->setNianatraImpito(7);

            $this->em->persist($registre);
            $this->em->flush();

            //mambra et fianarana lesona
            foreach ((array) $mambras as $key => $val) {
                if (str_contains($key, "presence")) {
                    if ($val == "on") {
                        $presence = explode("_", $key);
                        $id = $presence[1];
                        $mambra = $this->mambraRepo->find(intval($id));

                        // create new entity fianaranaLesona
                        $fianaranaL = new FianaranaLesona();
                        $fianaranaL->setPresence(true);
                        $fianaranaL->setMambra($mambra);
                        $fianaranaL->setRegistre($registre);
                        // isa nianarana lesona
                        $fianaranaL->setNombre(intval($mambras['impito_' . $id]));
                        $this->em->persist($fianaranaL);
                        $this->em->flush();
                    }
                }
            }

            return $this->redirectToRoute('registre_index');
            // traitement registre

        }


        $kilasy = $this->kilasyRepo->findAll();
        // $mambra = $this->mambraRepo->findMambra($kilasy);

        return $this->render('sekolySabata/registre/new_with_mambra.html.twig', [

            'kilasy' => $kilasy,
            // 'mambra' => $mambra,

        ]);
    }


    /**
     * @Route("/{id}", name="registre_show", methods={"GET"})
     */
    public function show(Registre $registre): Response
    {
        return $this->render('sekolySabata/registre/show.html.twig', [
            'registre' => $registre,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="registre_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Registre $registre): Response
    {
        $form = $this->createForm(RegistreType::class, $registre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('registre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('sekolySabata/registre/edit.html.twig', [
            'registre' => $registre,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="registre_delete", methods={"POST"})
     */
    public function delete(Request $request, Registre $registre): Response
    {
        if ($this->isCsrfTokenValid('delete' . $registre->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($registre);
            $entityManager->flush();
        }

        return $this->redirectToRoute('registre_index', [], Response::HTTP_SEE_OTHER);
    }
}
