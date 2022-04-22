<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\InscriptionType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class InscriptionController extends AbstractController
{


    private $passwordEncoder;

    public function __construct(

        UserPasswordHasherInterface $passwordEncoder

    ) {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @Route("/inscription", name="inscription")
     */
    public function inscription(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(InscriptionType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user = $form->getData();
            $password = $this->passwordEncoder->hashPassword($user, $user->getPassword());
            $user->setRoles(['ROLE_CLIENT']);

            $user->setPassword($password);
            //$user->setUsername($request->request->get('client_register')['nom']);
            $user->setCreatedAt(new \DateTime('now'));
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('home');
        }
        return $this->render('client/inscription.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }
}
