<?php

namespace App\Controller;

use App\Entity\Message;
use App\Form\MessageFormType;
use App\Repository\UserRepository;
use DateTimeImmutable;
use DateTimeZone;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

}
