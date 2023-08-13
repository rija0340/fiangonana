<?php

namespace App\Controller;

use App\Entity\Raharaha;
use App\Form\RaharahaType;
use App\Repository\RaharahaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/raharaha")
 */
class RaharahaController extends AbstractController
{
    /**
     * @Route("/", name="raharaha_index", methods={"GET"})
     */
    public function index(RaharahaRepository $raharahaRepository): Response
    {
        return $this->render('raharaha/index.html.twig', [
            'raharahas' => $raharahaRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="raharaha_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $raharaha = new Raharaha();
        $form = $this->createForm(RaharahaType::class, $raharaha);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($raharaha);
            $entityManager->flush();

            return $this->redirectToRoute('raharaha_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('raharaha/new.html.twig', [
            'raharaha' => $raharaha,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="raharaha_show", methods={"GET"})
     */
    public function show(Raharaha $raharaha): Response
    {
        return $this->render('raharaha/show.html.twig', [
            'raharaha' => $raharaha,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="raharaha_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Raharaha $raharaha): Response
    {
        $form = $this->createForm(RaharahaType::class, $raharaha);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('raharaha_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('raharaha/edit.html.twig', [
            'raharaha' => $raharaha,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="raharaha_delete", methods={"POST"})
     */
    public function delete(Request $request, Raharaha $raharaha): Response
    {
        if ($this->isCsrfTokenValid('delete'.$raharaha->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($raharaha);
            $entityManager->flush();
        }

        return $this->redirectToRoute('raharaha_index', [], Response::HTTP_SEE_OTHER);
    }
}
