<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/user/{id}', name: 'my_account')]
    public function user_account(UserRepository $userRepository, $id): Response
    {
        $user = $userRepository->find($id);

        return $this->render('user/my_account.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/users', name: 'app_users')]
    public function all_users(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();

        return $this->render('user/users.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/contact/{user_id_sender}/{user_id_recever}', name: 'contact_user')]
    public function contact_user(UserRepository $userRepository, $user_id_sender, $user_id_recever)
    {
        $user_sender = $userRepository->find($user_id_sender);
        $user_recever = $userRepository->find($user_id_recever);

        return $this->render('user/contact_user.html.twig', [
            'user_sender' => $user_sender,
            'user_recever' => $user_recever
        ]);
    }
}
