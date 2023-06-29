<?php

namespace App\Controller\SekolySabata;

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
     * @Route("sekolysabata", name="sesa_index")
     */
    public function index(): Response
    {
        return $this->render('sekolySabata/index.html.twig');
    }
}
