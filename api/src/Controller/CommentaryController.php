<?php

namespace App\Controller;

use App\Entity\Commentary;
use App\Repository\CardRepository;
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
    public function create_commentary(Request $request, $gameName, $extensionName,$cardName, EntityManagerInterface $entityManager, CardRepository $cardRepository): JsonResponse
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
}
