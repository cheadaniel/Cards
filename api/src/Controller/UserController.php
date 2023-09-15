<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\MessageRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/user/{id}', name: 'my_account')] // Accéder à sa page de profil 
    public function user_account(UserRepository $userRepository, $id): Response
    {
        $user = $userRepository->find($id);

        return $this->render('user/my_account.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/users', name: 'app_users')] // Accéder aux profils des utilsateurs
    public function all_users(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();

        return $this->render('user/users.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route ('/contact/{id}', name: 'contact')] // Accéder à sa page de contact 
    public function contact(MessageRepository $messageRepository, UserRepository $userRepository, $id) : Response 
    {
        $receversIds = $messageRepository->findDistinctDestinatairesByUserSender($id);
    
        $recevers = [];
        foreach ($receversIds as $receverId) {
            $recever = $userRepository->find($receverId['destinataire_id']);
            if ($recever instanceof User) {
                $recevers[] = $recever;
            }
        }
    
        return $this->render('user/contact.html.twig', [
            'recevers' => $recevers
        ]);
    }
}
