<?php

namespace App\Controller;

use App\Entity\Card;
use App\Form\CardFormType;
use App\Repository\CardRepository;
use App\Repository\ExtensionRepository;
use App\Repository\GameRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CardController extends AbstractController
{
    #[Route('games/{gameName}/{extensionName}/{cardName}', name: 'card')]
    public function index($gameName, $extensionName, $cardName, CardRepository $cardRepository): Response
    {
        $card = $cardRepository->findByCardName($cardName);

        // Récupérez tous les commentaires associés à la carte
        $comments = $card->getCardCommentaryId();
        //dd($comments);

        return $this->render('card/index.html.twig', [
            'gameName' => $gameName,
            'extensionName' => $extensionName,
            'card' => $card,
            'comments'=> $comments,
        ]);
    }

    #[Route('admin/games/{gameName}/{extensionName}/card/create', name: 'create_card')]
    public function create_card(Request $request, EntityManagerInterface $entityManager, $gameName, GameRepository $gameRepository, $extensionName, ExtensionRepository $extensionRepository): Response
    {
        $game = $gameRepository->findByGameName($gameName);
        if (!$game) { //verifier si le jeu existe et rediriger si ce n'est pas le cas
            return $this->redirectToRoute('games');
        }
        $extension = $extensionRepository->findByExtensionName($extensionName);
        if (!$extension) { //verifier si l'extension existe et rediriger si ce n'est pas le cas vers la page contenant toutes les extensions du jeu
            return $this->redirectToRoute('game', ['gameName' => $gameName], Response::HTTP_SEE_OTHER);
        }

        $card = new Card();

        $form = $this->createForm(CardFormType::class, $card);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $card->setGameId($game);
            $card->setExtensionId($extension);
            $entityManager->persist($card);
            $entityManager->flush();
            return $this->redirectToRoute('extension', ['gameName' => $gameName, 'extensionName' => $extensionName], Response::HTTP_SEE_OTHER);
        }
        return $this->render('card/createCard.html.twig', [
            'cardForm' => $form->createView(),
        ]);
    }

    #[Route('admin/games/{gameName}/{extensionName}/{cardName}/delete', name: 'delete_card',  methods: ['GET'])]
    public function delete_card(CardRepository $cardRepository, $gameName, $extensionName, $cardName): Response
    {
        $card = $cardRepository->findByCardName($cardName);

        if (!$card) { //verifier si le jeu existe et rediriger si ce n'est pas le cas
            return $this->redirectToRoute('extension', ['gameName' => $gameName, 'extensionName' => $extensionName]);
        }
        $cardRepository->remove($card, true);
        return $this->redirectToRoute('extension', ['gameName' => $gameName, 'extensionName' => $extensionName]);
    }

    #[Route('admin/games/{gameName}/{extensionName}/{cardName}/edit', name: 'edit_card', methods: ['GET', 'POST'])]
    public function edit_card(Request $request, EntityManagerInterface $entityManager, CardRepository $cardRepository, $gameName, $extensionName, $cardName): Response
    {
        $post = $cardRepository->findByCardName($cardName);
        $form = $this->createForm(CardFormType::class, $post);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('extension', ['gameName' => $gameName, 'extensionName' => $extensionName]);
        }
        return $this->render('extension/editExtension.html.twig', [
            'extensionForm' => $form->createView(),
        ]);
    }
}
