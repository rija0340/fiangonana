<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\AjoutProduitType;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\SerializerInterface;

class ProduitsController extends AbstractController
{
    private $em;
    private $produitRepo;

    public function __construct(ProduitRepository $produitRepo, EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->produitRepo = $produitRepo;
    }
    /**
     * @Route("/produits", name="produits")
     */
    public function index(): Response
    {
        $produits = $this->produitRepo->findAll();
        return $this->render('produits/index.html.twig', [
            'produits' =>  $produits,
        ]);
    }

    /**
     * @Route("/produits/ajouter", name="ajout_produit")
     */
    public function ajouterProduit(Request $request): Response
    {
        $produit = new Produit();
        $form = $this->createForm(AjoutProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $produit->setCreatedAt(new \DateTime());
            $produit->setEditing(false);
            $this->em->persist($produit);
            $this->em->flush();
            return $this->redirectToRoute('produits');
        }
        return $this->render('produits/ajouter.html.twig', [
            'form' => $form->createView()
        ]);
    }



    /**
     * @Route("/api/liste-produits", name="api_produits")
     */
    public function apiProduits(Request $request, SerializerInterface $serializerInterface): Response
    {
        $response = $this->json($this->produitRepo->findAll(), 200, []);
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return  $response;
    }

    /**
     * @Route("/api/produit/{id}", name="api_produit")
     */
    public function apiProduit(Request $request, SerializerInterface $serializerInterface, Produit $produit): Response
    {

        $response = $this->json($produit);
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return  $response;
    }

    /**
     * @Route("/api/ajouter-produit", name="api_ajout_produit", methods={ "GET","POST"})
     */
    public function apiAjoutProduit(Request $request, SerializerInterface $serializerInterface): Response
    {
        $jsonRecu = $request->getContent();
        $post = $serializerInterface->deserialize($jsonRecu, Produit::class, 'json');
        $post->setCreatedAt(new \DateTime());
        $post->setEditing(false);
        $this->em->persist($post);
        $this->em->flush();
        $response = $this->json($this->produitRepo->findAll(), $status = 201, []);
        $response->headers->set('Content-Type', 'application/json');
        // Allow all websites
        $response->headers->set('Access-Control-Allow-Origin', '*');
        // $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }

    // /**
    //  * @Route("/api/modifier-produit/{id}", name="api_edit_produit", methods={ "GET","POST"})
    //  */
    // public function apiModifierProduit(Produit $produit, Request $request, SerializerInterface $serializerInterface): Response
    // {
    //     $jsonRecu = $request->getContent();
    //     $post = $serializerInterface->deserialize($jsonRecu, Produit::class, 'json');
    //     $post->setCreatedAt(new \DateTime());
    //     $post->setEditing(false);
    //     $this->em->flush();
    //     $response = $this->json($this->produitRepo->findAll(), $status = 201, []);
    //     $response->headers->set('Content-Type', 'application/json');
    //     $response->headers->set('Access-Control-Allow-Origin', '*');
    //     return $response;
    // }

    /**
     * @Route("/api/modifier-produit/{id}", name="api_edit_produit", methods={ "PUT"})
     */
    public function editProduit(Request $request, Produit $produit, SerializerInterface $serializerInterface)
    {

        $jsonRecu = $request->getContent();
        $data = json_decode($jsonRecu);

        $produit->setNom($data->nom);
        $produit->setDescription($data->description);
        $this->em->flush();

        return $this->json(null, $status = 200);
        // do your stuff
    }


    /**
     * @Route("/api/supprimer-produit/{id}", name="api_delete_produit", methods={"DELETE", "GET", "POST"})
     */
    public function apiDeleteProduit(Request $request, Produit $produit): Response
    {
        // dd($request);
        // if ($this->isCsrfTokenValid('delete' . $produit->getId(), $request->request->get('_token'))) {

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($produit);
        $entityManager->flush();
        // }
        $response = $this->json($this->produitRepo->findAll(), $status = 204, []);
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Access-Control-Request-Method ', 'DELETE');
        $response->headers->set('Access-Control-Allow-Headers', ' X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method');

        return $response;
    }
}
