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
use Symfony\Component\HttpFoundation\JsonResponse;

class MessageController extends AbstractController
{
    #[Route('/message', name: 'app_message')]
    public function index(): Response
    {
        return $this->render('message/index.html.twig', [
            'controller_name' => 'MessageController',
        ]);
    }

    #[Route('/contact/{user_id_sender}/{user_id_recever}', name: 'conversation')]
    public function conversation($user_id_sender, $user_id_recever, UserRepository $userRepository, MessageRepository $messageRepository): Response
    {
        $oldMessages = $messageRepository->findByUsers($user_id_sender, $user_id_recever);
        $user_sender = $userRepository->find($user_id_sender);
        $user_recever = $userRepository->find($user_id_recever);

        return $this->render('user/contact_user.html.twig', [
            'user_sender' => $user_sender,
            'user_recever' => $user_recever,
            'old_messages' => $oldMessages,
        ]);
    }

    #[Route('/contact/{user_id_sender}/{user_id_recever}/message', name: 'message')]
    public function message( $user_id_sender, $user_id_recever, UserRepository $userRepository): Response
    {

        $user_sender = $userRepository->find($user_id_sender);
        $user_recever = $userRepository->find($user_id_recever);

        $message = new Message();

        $form = $this->createForm(MessageFormType::class, $message);

        return $this->render('message/send_message.html.twig', [
            'user_sender' => $user_sender,
            'user_recever' => $user_recever,
            'messageForm' => $form->createView(),
        ]);
    }

    #[Route('/contact/{user_id_sender}/{user_id_recever}/message/send', name: 'send_message')]
    public function send_message(Request $request, $user_id_sender, $user_id_recever, UserRepository $userRepository, EntityManagerInterface $entityManager) : JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $content = $data['content'];
        
        $message = new Message();
        
        
        $user_sender = $userRepository->find($user_id_sender);
        $user_recever = $userRepository->find($user_id_recever);
        
        $message->setContent($content);
        $message->setUserSenderId($user_sender);
        $message->setUserReceverId($user_recever);
        
        $parisTimeZone = new DateTimeZone('Europe/Paris');
        $createdAt = new DateTimeImmutable('now', $parisTimeZone); // Créez une nouvelle instance de DateTime avec la date et l'heure actuelles
        $message->setCreatedAt($createdAt);
        
        $entityManager->persist($message);
        $entityManager->flush();
        
        // Réponse JSON indiquant le succès de l'envoi
        $response = [
            'success' => true,
            'message' => 'ok',
        ];
        // $test = new JsonResponse($response);
        // dd($test);

        return $this->json($response);
    }
}
