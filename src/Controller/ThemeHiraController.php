<?php

namespace App\Controller;

use App\Entity\ThemeHira;
use App\Form\ThemeHiraType;
use App\Repository\ThemeHiraRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/theme/hira")
 */
class ThemeHiraController extends AbstractController
{
    /**
     * @Route("/", name="theme_hira_index", methods={"GET"})
     */
    public function index(ThemeHiraRepository $themeHiraRepository): Response
    {
        return $this->render('theme_hira/index.html.twig', [
            'theme_hiras' => $themeHiraRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="theme_hira_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $themeHira = new ThemeHira();
        $form = $this->createForm(ThemeHiraType::class, $themeHira);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($themeHira);
            $entityManager->flush();

            return $this->redirectToRoute('theme_hira_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('theme_hira/new.html.twig', [
            'theme_hira' => $themeHira,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="theme_hira_show", methods={"GET"})
     */
    public function show(ThemeHira $themeHira): Response
    {
        return $this->render('theme_hira/show.html.twig', [
            'theme_hira' => $themeHira,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="theme_hira_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ThemeHira $themeHira): Response
    {
        $form = $this->createForm(ThemeHiraType::class, $themeHira);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('theme_hira_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('theme_hira/edit.html.twig', [
            'theme_hira' => $themeHira,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="theme_hira_delete", methods={"POST"})
     */
    public function delete(Request $request, ThemeHira $themeHira): Response
    {
        if ($this->isCsrfTokenValid('delete' . $themeHira->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($themeHira);
            $entityManager->flush();
        }

        return $this->redirectToRoute('theme_hira_index', [], Response::HTTP_SEE_OTHER);
    }
}
