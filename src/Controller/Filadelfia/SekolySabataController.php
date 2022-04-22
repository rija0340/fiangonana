<?php

namespace App\Controller\Filadelfia;

use App\Repository\MambraRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SekolySabataController extends AbstractController
{
    private $mambraRepo;
    public function __construct(MambraRepository $mambraRepo)
    {
        $this->mambraRepo = $mambraRepo;
    }
    /**
     * @Route("espace-client/filadelfia/kilasy-sekoly-sabata", name="kilasy_sekoly_sabata")
     */
    public function index(): Response
    {

        return $this->render('filadelfia/sekolySabata/kilasySS.html.twig', [
            'lehibe' => $this->mambraRepo->findLehibe(),
            'tanoraZokiny' => $this->mambraRepo->findTanoraZokiny(),
            'zatovo' => $this->mambraRepo->findZatovo(),
            'tanoraZandriny' => $this->mambraRepo->findTanoraZandriny(),
            'ankizy' => $this->mambraRepo->findAnkizy(),
            'mambra' => $this->mambraRepo->findAll(),
        ]);
    }
}
