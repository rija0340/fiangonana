<?php

namespace App\Controller;

use App\Entity\Hira;
use App\Entity\Tononkira;
use App\Form\HiraType;
use App\Repository\HiraRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("admin/hira")
 */
class HiraController extends AbstractController
{
    /**
     * @Route("/", name="hira_index", methods={"GET"})
     */
    public function index(HiraRepository $hiraRepository): Response
    {
        return $this->render('hira/index.html.twig', [
            'hiras' => $hiraRepository->findAll(),
        ]);
    }

    /**
     * @Route("/atoato", name="atoato", methods={"GET"})
     */
    public function atoato(): Response
    {
        return $this->render('hira/atoato.html.twig', []);
    }



    /**
     * @Route("/new", name="hira_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $hira = new Hira();

        $form = $this->createForm(HiraType::class, $hira);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            foreach ($hira->getTononkiras() as $tononkira) {
                $tononkira->setHira($hira);
                $entityManager->persist($tononkira);
            }

            $entityManager->persist($hira);
            $entityManager->flush();

            return $this->redirectToRoute('hira_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('hira/new.html.twig', [
            'hira' => $hira,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="hira_show", methods={"GET"})
     */
    public function show(Hira $hira): Response
    {
        return $this->render('hira/show.html.twig', [
            'hira' => $hira,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="hira_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Hira $hira): Response
    {
        $form = $this->createForm(HiraType::class, $hira);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('hira_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('hira/edit.html.twig', [
            'hira' => $hira,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="hira_delete", methods={"POST"})
     */
    public function delete(Request $request, Hira $hira): Response
    {
        if ($this->isCsrfTokenValid('delete' . $hira->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($hira);
            $entityManager->flush();
        }

        return $this->redirectToRoute('hira_index', [], Response::HTTP_SEE_OTHER);
    }
}
