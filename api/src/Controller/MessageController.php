<?php

namespace App\Controller;

use App\Entity\Message;
use App\Form\MessageFormType;
use App\Repository\MessageRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use DateTimeImmutable;
use DateTimeZone;

class MessageController extends AbstractController
{
    #[Route('/message', name: 'app_message')]
    public function index(): Response
    {
        return $this->render('message/index.html.twig', [
            'controller_name' => 'MessageController',
        ]);
    }

    #[Route('/contact/{user_id_sender}/{user_id_recever}/sendMessage', name: 'send_message')]
    public function send_message(Request $request, EntityManagerInterface $entityManager, $user_id_sender, $user_id_recever, UserRepository $userRepository, MessageRepository $messageRepository): Response
    {
        $oldMessages = $messageRepository->findByUsers($user_id_sender, $user_id_recever);

        $user_sender = $userRepository->find($user_id_sender);
        $user_recever = $userRepository->find($user_id_recever);

        $message = new Message();
        $form = $this->createForm(MessageFormType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $message->setUserSenderId($user_sender);
            $message->setUserReceverId($user_recever);

            $parisTimeZone = new DateTimeZone('Europe/Paris');
            $createdAt = new DateTimeImmutable('now', $parisTimeZone); // Créez une nouvelle instance de DateTime avec la date et l'heure actuelles
            $message->setCreatedAt($createdAt);

            $entityManager->persist($message);
            $entityManager->flush();

            return $this->redirectToRoute('send_message', [
                'user_id_sender' => $user_id_sender,
                'user_id_recever' => $user_id_recever,
            ]);
        }
        return $this->render('user/contact_user.html.twig', [
            'user_sender' => $user_sender,
            'user_recever' => $user_recever,
            'messageForm' => $form->createView(),
            'old_messages' => $oldMessages,
        ]);
    }
}
