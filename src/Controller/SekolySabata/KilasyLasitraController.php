<?php

namespace App\Controller\SekolySabata;

use App\Entity\KilasyLasitra;
use App\Form\KilasyLasitraType;
use App\Repository\KilasyLasitraRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/kilasy/lasitra")
 */
class KilasyLasitraController extends AbstractController
{
    /**
     * @Route("/", name="kilasy_lasitra_index", methods={"GET"})
     */
    public function index(KilasyLasitraRepository $kilasyLasitraRepository): Response
    {
        return $this->render('sekolySabata/kilasy_lasitra/index.html.twig', [
            'kilasy_lasitras' => $kilasyLasitraRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="kilasy_lasitra_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $kilasyLasitra = new KilasyLasitra();
        $form = $this->createForm(KilasyLasitraType::class, $kilasyLasitra);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($kilasyLasitra);
            $entityManager->flush();

            return $this->redirectToRoute('kilasy_lasitra_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('sekolySabata/kilasy_lasitra/new.html.twig', [
            'kilasy_lasitra' => $kilasyLasitra,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="kilasy_lasitra_show", methods={"GET"})
     */
    public function show(KilasyLasitra $kilasyLasitra): Response
    {
        return $this->render('sekolySabata/kilasy_lasitra/show.html.twig', [
            'kilasy_lasitra' => $kilasyLasitra,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="kilasy_lasitra_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, KilasyLasitra $kilasyLasitra): Response
    {
        $form = $this->createForm(KilasyLasitraType::class, $kilasyLasitra);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('kilasy_lasitra_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('sekolySabata/kilasy_lasitra/edit.html.twig', [
            'kilasy_lasitra' => $kilasyLasitra,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="kilasy_lasitra_delete", methods={"POST"})
     */
    public function delete(Request $request, KilasyLasitra $kilasyLasitra): Response
    {
        if ($this->isCsrfTokenValid('delete' . $kilasyLasitra->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($kilasyLasitra);
            $entityManager->flush();
        }

        return $this->redirectToRoute('kilasy_lasitra_index', [], Response::HTTP_SEE_OTHER);
    }
}
