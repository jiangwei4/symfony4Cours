<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterUserType;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends Controller
{
    /**
     * @Route("/security", name="security")
     */
    public function index(Request $request, UserPasswordEncoderInterface $passwordEncoder, LoggerInterface $logger, EventDispatcherInterface $eventDispatcher)
    {
    $user = new User();
    $form = $this->createForm(RegisterUserType::class);
    $form->handleRequest($request);
    if($form->isSubmitted() && $form->isValid()){
        $user = $form->getData();

        $password = $passwordEncoder->encodePassword($user, $user->getPassword());
        $user->setPassword($password);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();
        $logger->info('nouvel utilisateur !');


        $event = new \UserRegisteredEvent($user);
        $eventDispatcher->dispatch(\UserRegisteredEvent::NAME,$event);


        return $this->redirectToRoute('home');
    }



        return $this->render('security/index.html.twig', [
            'controller_name' => 'SecurityController',
            'form'=>$form->createView()
        ]);
    }



}
