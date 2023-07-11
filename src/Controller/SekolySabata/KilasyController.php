<?php

namespace App\Controller\SekolySabata;

use App\Entity\Kilasy;
use App\Entity\Mambra;
use App\Form\KilasyType;
use App\Entity\RelationKM;
use App\Repository\KilasyRepository;
use App\Repository\MambraRepository;
use App\Repository\RelationKMRepository;
use App\Service\KilasyHelper;
use Doctrine\Common\Collections\Expr\Value;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("sekoly-sabata/kilasy")
 */
class KilasyController extends AbstractController
{
    private $mambraRepo;
    private $kilasyRepo;
    private $em;
    private $relationKMRepo;
    private $flashy;
    private $kilasyHelper;

    public function __construct(
        MambraRepository $mambraRepo,
        KilasyRepository $kilasyRepo,
        EntityManagerInterface $em,
        RelationKMRepository $relationKMRepo,
        FlashyNotifier $flashy,
        KilasyHelper $kilasyHelper
    ) {
        $this->mambraRepo = $mambraRepo;
        $this->kilasyRepo = $kilasyRepo;
        $this->em = $em;
        $this->relationKMRepo = $relationKMRepo;
        $this->flashy = $flashy;
        $this->kilasyHelper = $kilasyHelper;
    }

    /**
     * @Route("/", name="kilasy_index", methods={"GET"})
     */
    public function index(KilasyRepository $kilasyRepository): Response
    {

        $kilasies = $this->kilasyRepo->findAll();
        $kilasiesArray = [];
        foreach ($kilasies as $kilasy) {
            $kilasiesArray[] = [
                'id' => $kilasy->getId(),
                'nom' => $kilasy->getNom(),
                'mpampianatra' => $this->kilasyHelper->getMpampianatras($kilasy),
                'mpanentana' => $this->kilasyHelper->getMpanentanas($kilasy),
                // 'mpanentana' => $kilasy->getMpampianatra(),
                'mambra' => count($this->mambraRepo->findMambra($kilasy))
            ];
        }
        // dd($kilasiesArray);
        return $this->render('sekolySabata/kilasy/index.html.twig', [
            'kilasies' => $kilasiesArray

        ]);
    }

    /**
     * @Route("/new", name="kilasy_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $kilasy = new Kilasy();
        $form = $this->createForm(KilasyType::class, $kilasy);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($kilasy);
            $entityManager->flush();

            return $this->redirectToRoute('kilasy_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('sekolySabata/kilasy/new.html.twig', [
            'kilasy' => $kilasy,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/ajouter-mambra/{id}", name="kilasy_ajout_mambra", methods={"GET","POST"})
     */
    public function ajoutMambra(Kilasy $kilasy, Request $request): Response
    {


        if ($request->request->has('ajout')) {
            $mambra_ids = $request->request->get('ajout');
            foreach ($mambra_ids as $key => $id) {
                $mambra =  $this->mambraRepo->find(intval($id));
                $andraikitra = $request->request->get($id . "_andr");
                $relation = new RelationKM();

                switch ($andraikitra) {
                    case 'tsotra':
                        $relation->setIsMambraTsotra(true);
                        break;
                    case 'prof':
                        $relation->setIsMpampianatra(true);
                        break;
                    case 'anim':
                        $relation->setIsMpanentana(true);
                        break;
                }
                $relation->setIsCurrent(true);
                $relation->setKilasy($kilasy);
                $relation->setMambra($mambra);
                $this->em->persist($relation);
                $this->em->flush();
            }
        }

        $trancheAge = $kilasy->getKilasyLasitra()->getTrancheAge();
        // $possibleMambra = $this->mambraRepo->findPossibleMambra($trancheAge);
        $possibleMambra = $this->mambraRepo->findAll();
        $relations = $this->relationKMRepo->findBy(['kilasy' => $kilasy, 'isCurrent' => true]);
        $mambraKilasy = [];
        foreach ($relations as $key => $relation) {
            array_push($mambraKilasy, $relation->getMambra());
        }


        $idMambraRehetra = array_map(function ($entity) {
            return $entity->getId();
        }, $possibleMambra);

        $idMambraKilasy = array_map(function ($entity) {
            return $entity->getId();
        }, $mambraKilasy);

        $tsyMambraKilasy = array_diff($idMambraRehetra, $idMambraKilasy);
        $arrayTsyMambraKilasy = [];
        foreach ($tsyMambraKilasy as $key => $value) {
            array_push($arrayTsyMambraKilasy, $this->mambraRepo->find($value));
        }

        return $this->render('sekolySabata/kilasy/ajout_mambra.html.twig', [
            'kilasy' => $kilasy,
            'mambraKilasy' => $mambraKilasy,
            'possibleMambra' => $arrayTsyMambraKilasy
        ]);
    }

    /**
     * @Route("/kilasy-edit-andraikitra/{id}/{andr}", name="kilasy_edit_andraikitra", methods={"GET","POST"})
     *  @Entity("mambra", expr="repository.find(id)")
     */
    public function editAndraikitra(Mambra $mambra, $andr, Request $request): Response
    {

        $relation =  $this->relationKMRepo->findOneBy(['mambra' => $mambra, 'isCurrent' => true]);
        // mettre à false tous les andraikitra
        $relation->setIsMambraTsotra(false);
        $relation->setIsMpampianatra(false);
        $relation->setIsMpanentana(false);

        switch ($andr) {
            case 'prof':
                $relation->setIsMpampianatra(true);
                break;
            case 'anim':
                $relation->setIsMpanentana(true);
                break;
            case 'tsotra':
                $relation->setIsMambraTsotra(true);
                break;

            default:
                break;
        }

        $this->em->persist($relation);
        $this->em->flush();
        $this->flashy->success("Niova ny andraikitra");
        return $this->redirectToRoute('kilasy_show', ['id' => $relation->getKilasy()->getId()]);
    }

    /**
     * @Route("/kilasy-edit-kilasy/{id}", name="kilasy_edit_kilasy", methods={"GET","POST"})
     * afindra kilasy hafa manaraka ilay olona
     */
    public function afindraKilasy(Kilasy $kilasy, Request $request): Response
    {


        if (
            $request->query->has('mambraId')
            && $request->query->get('mambraId') != ""
            && $request->query->has('classe')
            && $request->query->get('classe') != ""
        ) {

            $mambraId =  intval($request->query->get('mambraId'));
            $newClasseId = intval($request->query->get('classe'));

            $mambra = $this->mambraRepo->find($mambraId);

            $relation =  $this->relationKMRepo->findOneBy(['mambra' => $mambra, 'isCurrent' => true]);
            // mettre à false tous les andraikitra
            $relation->setIsMambraTsotra(false);
            $relation->setIsMpampianatra(false);
            $relation->setIsMpanentana(false);

            $relation->setIsCurrent(false);

            $newRelation = new RelationKM();
            $newRelation->setIsMambraTsotra(true);
            $newRelation->setIsCurrent(true);
            $newRelation->setMambra($mambra);
            $newRelation->setKilasy($this->kilasyRepo->find($newClasseId));

            $this->em->persist($newRelation);
            $this->em->flush();
            $this->flashy->success("mambra voafindra");
            return $this->redirectToRoute('kilasy_show', ['id' => $newClasseId]);
        } else {

            return $this->redirectToRoute('kilasy_show', ['id' => $kilasy->getId()]);
        }
    }

    /**
     * @Route("/data-mambra/{id}", name="kilasy_data_mambra", methods={"GET"} , requirements={"id":"\d+"})
     */

    public function dataMambra(Kilasy $kilasy, Request $request)
    {

        $mambra = $this->mambraRepo->findMambra($kilasy);
        return new JsonResponse($mambra);
    }

    /**
     * @Route("/{id}", name="kilasy_show", methods={"GET"})
     */
    public function show(Kilasy $kilasy): Response
    {


        //selectionner toutes les classes qui ont un classe lasitra même que 
        // $kilasy et autres classes sup à $kilasy
        $classes = $this->kilasyRepo->findAllWithout($kilasy);

        //
        $trancheKilasy = $kilasy->getKilasyLasitra()->getTrancheAge();
        $maxTrancheKilasy = $this->getMaxInTranche($trancheKilasy);

        $values = [];
        $ids = [];

        //selectionner id des classes sup à $kilasy
        foreach ($classes as $key => $classe) {

            $tranche =  $classe->getKilasyLasitra()->getTrancheAge();
            $id = $classe->getId();
            $maxIntranche = $this->getMaxInTranche($tranche);
            // dd($maxIntranche);
            if ($maxIntranche > $maxTrancheKilasy) {
                array_push($values, $this->getMaxInTranche($tranche));
                array_push($ids, $id);
            }
        }

        $j = 0;
        for ($i = 0; $i < count($values); $i++) {
            if ($j == 0) {
                $min = $values[0];
                $key = 0;
                $j++;
            }

            if ($min > $values[$i]) {
                $min = $values[$i];
                $key = $i;
            }
        }

        $mambra = $this->mambraRepo->findMambra($kilasy);
        $classe = null;
        if (count($ids) > 0) {
            $classe = $this->kilasyRepo->find(intval($ids[$key]));
        }

        //kilasy parallele à $kilasy(meme lasitra)
        $lasitrak = $kilasy->getKilasyLasitra();
        $currentClasses = $this->kilasyRepo->findBy(['kilasyLasitra' => $lasitrak]);

        // //kilasy sup à $kilasy
        // $classes = [];
        // if (!is_null($classe)) {
        //     $lasitra  = $classe->getKilasyLasitra();
        //     $classes = $this->kilasyRepo->findBy(['kilasyLasitra' => $lasitra]);
        // }
        // dd($classes);

        // $classes = array_merge($classes, $currentClasses);
        return $this->render('sekolySabata/kilasy/show.html.twig', [
            'kilasy' => $kilasy,
            'mambra' => $mambra,
            'classes' => $classes
        ]);
    }
    public function getMaxInTranche($tranche)
    {
        // dd($tranche);
        $tranche = trim($tranche);

        if (str_contains($tranche, ",")) {

            $maxInTranche = explode(",", $tranche);
            $maxKey =  array_key_last($maxInTranche);
            $maxInTranche =  $maxInTranche[$maxKey];
            $maxInTranche = explode("_", $maxInTranche);
            $maxInTranche = intval($maxInTranche[1]);
        } else {
            if (str_contains("_", $tranche)) {
                $maxInTranche = explode("_", $tranche);
                $maxInTranche = intval($maxInTranche[1]);
            } else {
                $maxInTranche = 35;
            }
        }
        // dd($tranche, $maxInTranche);

        return $maxInTranche;
    }

    /**
     * @Route("/{id}/edit", name="kilasy_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Kilasy $kilasy): Response
    {
        $form = $this->createForm(KilasyType::class, $kilasy);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('kilasy_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('sekolySabata/kilasy/edit.html.twig', [
            'kilasy' => $kilasy,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="membre_kilasy_delete", methods={"POST"})
     */
    public function removeMemberFromClass(Request $request, Kilasy $kilasy): Response
    {
        $mambraID = $request->get('mambraID');
        $mambraID = intval($mambraID);

        if ($this->isCsrfTokenValid('delete' . $kilasy->getId(), $request->request->get('_token'))) {
            $relation = $this->relationKMRepo->findOneBy(['mambra' => $mambraID]);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($relation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('kilasy_show', ['id' => $kilasy->getId()]);
    }

    /**
     * @Route("/{id}", name="kilasy_delete", methods={"POST"})
     */
    public function delete(Request $request, Kilasy $kilasy): Response
    {
        if ($this->isCsrfTokenValid('delete' . $kilasy->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($kilasy);
            $entityManager->flush();
        }

        return $this->redirectToRoute('kilasy_index', [], Response::HTTP_SEE_OTHER);
    }
}
