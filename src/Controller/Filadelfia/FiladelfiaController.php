<?php

namespace App\Controller\Filadelfia;

use App\Entity\Mambra;
use App\Entity\Famille;
use App\Form\AddMembreFamilleType;
use App\Form\MambraType;
use App\Form\FamilleType;
use App\Repository\MambraRepository;
use App\Repository\FamilleRepository;
use Doctrine\ORM\EntityManagerInterface;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Security\Http\Firewall;

class FiladelfiaController extends AbstractController
{
    private $em;
    private $mambraRepo;
    private $familleRepo;
    private $flashy;
    public function __construct(FlashyNotifier $flashy, FamilleRepository $familleRepo, EntityManagerInterface $em, MambraRepository $mambraRepo)
    {
        $this->em = $em;
        $this->mambraRepo = $mambraRepo;
        $this->familleRepo = $familleRepo;
        $this->flashy = $flashy;
    }
    /**
     * @Route("espace-client/filadelfia", name="filadelfia_accueil")
     */
    public function index(Request $request): Response
    {
        $familles = $this->familleRepo->findAll();

        return $this->render('filadelfia/index.html.twig', [
            'familles' => $familles,
            'mambras' => $this->mambraRepo->findAll(),

        ]);
    }


    /**
     * @Route("/espace-client/filadelfia-creer-mambra", name="filadelfia_creer_mambra", methods={"GET","POST"})
     */
    public function creerMambra(Request $request): Response
    {
        $mambra = new Mambra();
        $form = $this->createForm(MambraType::class, $mambra);
        $form->handleRequest($request);

        //validation form 
        if ($form->isSubmitted() && $form->isValid()) {
            if ($request->get('mambra')['nouvelle_famille'] != null) {
                //ajouter la nouvelle famille au table famille
                $famille = new Famille();
                $famille->setNom($request->get('mambra')['nouvelle_famille']);
                $this->em->persist($famille);
                $this->em->flush();
                $mambra->setFamille($famille);
            } else {
                $mambra->setFamille($this->familleRepo->find($request->get('mambra')['famille']));
            }

            $this->em->persist($mambra);
            $this->em->flush();
            return $this->redirectToRoute('filadelfia_accueil');
        }

        return $this->render('filadelfia/mambra/new.html.twig', [

            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/espace-client/filadelfia-details-mambra/{id}", name="filadelfia_details_mambra", methods={"GET","POST"})
     */
    public function detailsMambra(Request $request, Mambra $mambra): Response
    {
        return $this->render('filadelfia/mambra/show.html.twig', [
            'mambra' => $mambra
        ]);
    }

    /**
     * @Route("/espace-client/filadelfia-modifier-mambra/{id}", name="filadelfia_modifier_mambra", methods={"GET","POST"})
     */
    public function modifierMambra(Request $request, Mambra $mambra): Response
    {
        $form = $this->createForm(MambraType::class, $mambra);
        $form->handleRequest($request);
        //validation form
        if ($form->isSubmitted() && $form->isValid()) {

            if ($request->request->get('mambra')['nouvelle_famille'] != null) {
                //ajouter la nouvelle famille au table famille
                $famille = new Famille();
                $famille->setNom($request->request->get('mambra')['nouvelle_famille']);
                $this->em->persist($famille);
                $this->em->flush();
                $mambra->setFamille($famille);
            } else {
                $mambra->setFamille($this->familleRepo->find($request->request->get('mambra')['famille']));
            }

            $this->em->persist($mambra);
            $this->em->flush();
            return $this->redirectToRoute('filadelfia_accueil');
        }

        return $this->render('filadelfia/mambra/edit.html.twig', [
            'mambra' => $mambra,
            'id' => $mambra->getId(),
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/espace-client/filadelfia-creer-famille", name="filadelfia_creer_famille", methods={"GET","POST"})
     */
    public function creerFamille(Request $request): Response
    {
        $famille = new Famille();

        $form = $this->createForm(FamilleType::class, $famille);
        $form->handleRequest($request);

        //validation form 
        if ($form->isSubmitted() && $form->isValid()) {
            // dd($request);
            //enregistrement mambre de famille si n'est pas vide
            if ($request->get('famille')['mambra'] != null) {
                if ($request->get('famille')['sexe'] != 0) {
                    $mambra = new Mambra();
                    $mambra->setPrenom($request->get('famille')['mambra']);
                    $mambra->setSexe($request->get('famille')['sexe']);
                    $mambra->setFamille($famille);
                    $this->em->persist($mambra);
                    $this->em->flush();
                } else {
                    $this->flashy->error("Veuillez choisir le sexe");
                    return $this->redirectToRoute('filadelfia_creer_famille');
                }
            }

            //enregistere dans bdd de famille
            $this->em->persist($famille);
            $this->em->flush();

            return $this->redirectToRoute('filadelfia_accueil');
        }

        return $this->render('filadelfia/famille/new.html.twig', [
            'form' => $form->createView(),
            'familles' => $this->familleRepo->findAll(),
            'mambras' => $this->mambraRepo->findAll()
        ]);
    }
    /**
     * @Route("/espace-client/filadelfia-details-famille/{id}", name="filadelfia_details_famille", methods={"GET","POST"})
     */
    public function detailsFamille(Request $request, Famille $famille): Response
    {

        return $this->render('filadelfia/famille/show.html.twig', [
            'famille' => $famille,

        ]);
    }

    /**
     * @Route("/espace-client/filadelfia-modifier-famille/{id}", name="filadelfia_modifier_famille", methods={"GET","POST"})
     */
    public function modifierFamille(Request $request, Famille $famille): Response
    {
        $form = $this->createForm(FamilleType::class, $famille);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // dd($request);
            //enregistrement mambre de famille si n'est pas vide
            if ($request->request->get('famille')['mambra'] != null) {
                if ($request->request->get('famille')['sexe'] != 0) {
                    $mambra = new Mambra();
                    $mambra->setNom($request->request->get('famille')['mambra']);
                    $mambra->setSexe($request->request->get('famille')['sexe']);
                    $mambra->setFamille($famille);
                    $this->em->persist($mambra);
                    $this->em->flush();
                } else {
                    $this->flashy->error("Veuillez choisir le sexe");
                    return $this->redirectToRoute('filadelfia_accueil');
                }
            }

            //enregistrer dans bdd de famille
            $this->em->persist($famille);
            $this->em->flush();
            return $this->redirectToRoute('filadelfia_accueil');
        }

        return $this->render('filadelfia/famille/edit.html.twig', [
            'form' => $form->createView(),
            'id' => $famille->getId()
        ]);
    }

    /**
     * @Route("/espace-client/filadelfia-ajout-membre-famille/{id}", name="filadelfia_ajout_membre_famille", methods={"GET","POST"})
     */
    public function ajoutMembreFamille(Request $request, Famille $famille): Response
    {

        $mambra = new Mambra();

        $form = $this->createForm(AddMembreFamilleType::class, $mambra);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $mambra->setFamille($famille);
            $this->em->persist($mambra);
            $this->em->flush();

            return $this->redirectToRoute('filadelfia_accueil');
        }

        return $this->render('filadelfia/formAjoutMembreFamille.html.twig', [
            'form' => $form->createView(),
            'famille' => $famille,
            'id' => $famille->getId()
        ]);
    }

    /**
     * @Route("/espace-client/filadelfia-supprimer-mambra/{id}", name="filadelfia_supprimer_mambra", methods={"POST","DELETE"})
     * 
     */
    public function supprimerMambra(Request $request, Mambra $mambra)
    {

        if ($this->isCsrfTokenValid('delete' . $mambra->getId(), $request->get('_token'))) {
            $this->em->remove($mambra);
            $this->em->flush();
            $this->flashy->success("Supprim?? avec succ??s");
        }
        return $this->redirectToRoute('filadelfia_accueil');
    }


    /**
     * @Route("/espace-client/filadelfia-supprimer-famille/{id}", name="filadelfia_supprimer_famille", methods={"POST","DELETE"})
     * 
     */
    public function supprimerFamille(Request $request, Famille $famille)
    {

        if ($this->isCsrfTokenValid('delete' . $famille->getId(), $request->get('_token'))) {
            $this->em->remove($famille);
            $this->em->flush();
            $this->flashy->success("Supprim?? avec succ??s");
        }
        return $this->redirectToRoute('filadelfia_accueil');
    }
}
