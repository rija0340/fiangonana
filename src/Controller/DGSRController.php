<?php

namespace App\Controller;

use Directory;
use App\Entity\Centre;
use App\Entity\Service;
use App\Form\CentreType;
use App\Entity\Direction;
use App\Entity\Personnel;
use App\Entity\Ville;
use App\Form\ServiceType;
use App\Form\DirectionType;
use App\Form\PersonnelType;
use App\Form\VilleType;
use App\Repository\CentreRepository;
use App\Repository\ServiceRepository;
use App\Repository\DirectionRepository;
use App\Repository\PersonnelRepository;
use App\Repository\VilleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestMatcherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DGSRController extends AbstractController
{

    private $serviceRepo;
    private $directionRepo;
    private $personnelRepo;
    private $centreRepo;
    private $villeRepo;
    private $em;
    public function __construct(VilleRepository $villeRepo, CentreRepository $centreRepo, PersonnelRepository $personnelRepo, ServiceRepository $serviceRepo, DirectionRepository $directionRepo, EntityManagerInterface $em)
    {
        $this->serviceRepo = $serviceRepo;
        $this->directionRepo = $directionRepo;
        $this->personnelRepo = $personnelRepo;
        $this->centreRepo = $centreRepo;
        $this->villeRepo = $villeRepo;
        $this->em = $em;
    }

    /**
     * @Route("/espace-client/dgsr", name="dgsr_accueil")
     */
    public function index(): Response
    {
        $services =  $this->serviceRepo->findAll();
        $directions  =  $this->directionRepo->findAll();

        return $this->render('dgsr/index.html.twig', [
            'directions' => $directions,
            'services' => $services
        ]);
    }
    /**
     * @Route("/espace-client/dgsr-creer-direction", name="dgsr_creer_direction")
     */
    public function creerDirection(Request $request): Response
    {
        $direction = new Direction();
        $form = $this->createForm(DirectionType::class, $direction);

        $form->handleRequest($request);

        //validation formulaire et save data
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($direction);
            $this->em->flush();
            return $this->redirectToRoute('dgsr_creer_direction');
        }

        return $this->render('dgsr/direction/new.html.twig', [
            'form' => $form->createView(),
            'directions' => $this->directionRepo->findAll()

        ]);
    }

    /**
     * @Route("/espace-client/dgsr-creer-service", name="dgsr_creer_service", methods={"GET","POST"})
     */
    public function creerService(Request $request): Response
    {
        $service = new Service();
        $form = $this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);

        //validation formulaire et save data
        if ($form->isSubmitted() && $form->isValid()) {

            if ($request->request->get('service')['dir'] != null) {
                $direction = new Direction;
                $direction->setNom($request->request->get('service')['dir']);
                $this->em->persist($direction);
                $this->em->flush();
                $service->setDirection($direction);
                $this->em->persist($service);
                $this->em->flush();
            } else {

                $this->em->persist($service);
                $this->em->flush();
            }
            return $this->redirectToRoute('dgsr_creer_service');
        }

        return $this->render('dgsr/service/new.html.twig', [
            'form' => $form->createView(),
            'services' => $this->serviceRepo->findAll()
        ]);
    }


    /**
     * @Route("/espace-client/dgsr-creer-personnel", name="dgsr_creer_personnel", methods={"GET","POST"})
     */
    public function creerPersonnel(Request $request): Response
    {
        $personnel = new Personnel();
        $form = $this->createForm(PersonnelType::class, $personnel);
        $form->handleRequest($request);

        //validation form 
        if ($form->isSubmitted() && $form->isValid()) {

            $this->em->persist($personnel);
            $this->em->flush();
            return $this->redirectToRoute('dgsr_creer_personnel');
        }

        return $this->render('dgsr/personnel/new.html.twig', [

            'form' => $form->createView(),
            'personnels' =>  $this->personnelRepo->findAll(),
        ]);
    }

    /**
     * @Route("/espace-client/dgsr-modifier-personnel/{id}", name="dgsr_modifier_personnel", methods={"GET","POST"})
     */
    public function editPersonnel(Request $request, Personnel $personnel): Response
    {
        $form = $this->createForm(PersonnelType::class, $personnel);
        $form->handleRequest($request);

        //validation form 
        if ($form->isSubmitted() && $form->isValid()) {

            $this->em->persist($personnel);
            $this->em->flush();
            return $this->redirectToRoute('dgsr_creer_personnel');
        }

        return $this->render('dgsr/personnel/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/espace-client/dgsr-creer-centre", name="dgsr_creer_centre", methods={"GET","POST"})
     */
    public function creerCentre(Request $request): Response
    {
        $centre = new Centre();
        $form = $this->createForm(CentreType::class, $centre);
        $form->handleRequest($request);

        //validation form 
        if ($form->isSubmitted() && $form->isValid()) {
            $centre->setCreatedAt(new \DateTime('now'));
            $this->em->persist($centre);
            $this->em->flush();
            return $this->redirectToRoute('dgsr_creer_centre');
        }

        return $this->render('dgsr/centre/new.html.twig', [

            'form' => $form->createView(),
            'centres' =>  $this->centreRepo->findAll(),
        ]);
    }


    /**
     * @Route("/espace-client/dgsr-creer-ville", name="dgsr_creer_ville", methods={"GET","POST"})
     */
    public function creerVille(Request $request): Response
    {
        $ville = new Ville();
        $form = $this->createForm(VilleType::class, $ville);
        $form->handleRequest($request);

        //validation form 
        if ($form->isSubmitted() && $form->isValid()) {


            $this->em->persist($ville);
            $this->em->flush();
            return $this->redirectToRoute('dgsr_creer_ville');
        }

        return $this->render('dgsr/ville/new.html.twig', [

            'form' => $form->createView(),
            'villes' =>  $this->villeRepo->findAll(),
        ]);
    }
}
