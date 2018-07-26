<?php

namespace App\Controller;

use App\Form\AdminType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(Request $request, UserRepository $userRepository)
    {
        $user = $userRepository->findAll();

        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',

            'user'=>$user,
        ]);
    }


}
