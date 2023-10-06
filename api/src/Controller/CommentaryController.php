<?php

namespace App\Controller;

use App\Entity\Commentary;
use App\Repository\CardRepository;
use App\Repository\CommentaryRepository;
use DateTimeImmutable;
use DateTimeZone;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentaryController extends AbstractController
{

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }
    #[Route('/commentary', name: 'app_commentary')]
    public function index(): Response
    {
        return $this->render('commentary/index.html.twig', [
            'controller_name' => 'CommentaryController',
        ]);
    }

    #[Route('games/{gameName}/{extensionName}/{cardName}/commentary/create', name: 'create_commentary')]
    public function create_commentary(Request $request, $gameName, $extensionName, $cardName, EntityManagerInterface $entityManager, CardRepository $cardRepository): JsonResponse
    {

        // Récupérez l'utilisateur actuellement connecté 
        $user = $this->security->getUser();

        // Récuperer la carte associé 
        $card = $cardRepository->findByCardName($cardName);

        $data = json_decode($request->getContent(), true);
        $content = $data['content'];

        // Pour eviter les caractéres => " ' < >
        $contentVerif = htmlspecialchars($content);

        // Créez un nouvel objet Commentary
        $comment = new Commentary();
        $comment->setContent($content);
        $comment->setUserId($user);
        $comment->setCardId($card);

        $parisTimeZone = new DateTimeZone('Europe/Paris');
        $createdAt = new DateTimeImmutable('now', $parisTimeZone);

        $comment->setCreatedAt($createdAt);

        // Persistez le commentaire dans la base de données
        $entityManager->persist($comment);
        $entityManager->flush();

        // Réponse JSON indiquant le succès de l'envoi
        $response = [
            'success' => true,
            'message' => 'ok',
        ];
        return $this->json($response);
    }

    #[Route('/commentary/{userId}/{commentary_id}/delete', name: 'delete_commentary',  methods: ['GET'])]
    public function delete_commentary(CommentaryRepository $commentaryRepository, $userId, $commentary_id): Response
    {
        $commentary = $commentaryRepository->find($commentary_id);
        $commentaryRepository->remove($commentary, true);
        return new Response(null, Response::HTTP_NO_CONTENT);
    }

    #[Route('commentary/edit/{commentary_id}', name: 'edit_commentary', methods: ['GET', 'POST'])]
    public function edit_commentary(Request $request, CommentaryRepository $commentaryRepository, $commentary_id, EntityManagerInterface $entityManager): JsonResponse
    {

        $data = json_decode($request->getContent(), true);
        $content = $data['content'];

        $commentary = $commentaryRepository->find($commentary_id);
        $commentary->setContent($content);
        $parisTimeZone = new DateTimeZone('Europe/Paris');
        $createdAt = new DateTimeImmutable('now', $parisTimeZone); // Créer une nouvelle instance de DateTime avec la date et l'heure actuelles
        $commentary->setCreatedAt($createdAt);
        $entityManager->flush();

        $response = [
            'success' => true,
            'message' => 'ok',
        ];
        return $this->json($response);
    }
}
