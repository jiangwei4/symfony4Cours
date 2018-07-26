<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class UserController extends Controller
{
    /**
     * @Route("/user", name="user")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request, UserRepository $userRepository)
    {
        $user = new User();
        $form = $this->createForm(UserType::class,$user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
        }

        $games = $userRepository->findAll();

        return $this->render('user/index.html.twig', array(

                'form'=>$form->createView(),
                'controller_name'=>"Donovan",
                'games'=>$games
            )

        );
    }
    /**
     * @Route("/user/{id}", name="user_id", requirements={"id"="\d+"})
     */
    public function user(Request $request, UserRepository $userRepository, int $id){

        $user = $userRepository->find($id);


        return $this->render('game/userFiche.html.twig', [
            'user' => $user,
        ]);
    }



    /**
     * @Route("/user/{byFirstname}", name="user_firstname")
     * @ParamConverter("user", options={"mapping"={"byFirstname"="firstname"}})
     */
    public function firstname(Request $request, UserRepository $userRepository, User $user){

        return $this->render('user/user.html.twig',[
                'user'=> $user,
        ]

        );

    }




    /**
     * @Route("/user/remove/{id}", name="user_remove")
     * @ParamConverter("user", options={"mapping"={"id"="id"}})
     */
    public function remove(User $user, EntityManagerInterface $entityManager)
    {
        $articles = $user->getArticles();
        foreach($articles as $article){
            $article->setUser(null);
    }
        $entityManager->remove($user);
        $entityManager->flush();
        return $this->redirectToRoute('home');

    }

}
