<?php

namespace App\Controller;

use App\Form\ProfileUserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProfileController extends Controller
{
    /**
     * @Route("/profile", name="profile")
     */
    public function index(Request $request, EntityManagerInterface $entityManager)
    {
        $user = $this->getUser();
        $form = $this->createForm(ProfileUserType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $entityManager->flush();
            $this->addFlash('notice','les changements ont bien été éffectués');
            return $this->redirectToRoute('home');
        }
        return $this->render('profile/index.html.twig', [
            'controller_name' => 'ProfileController',
            'form' => $form->createView(),
        ]);
    }
}
