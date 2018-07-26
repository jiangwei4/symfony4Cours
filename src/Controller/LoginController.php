<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\LoginUserType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
    public function index(AuthenticationUtils $authenticationUtils)
    {
        $user = new User();
        $form= $this->createForm(LoginUserType::class, $user);

        return $this->render('login/index.html.twig', [
            'controller_name' => 'LoginController',
            'form' => $form->createView(),
        ]);
    }
}
