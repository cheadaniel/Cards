<?php

namespace App\Controller;

use App\Entity\Card;
use App\Entity\CardCollection;
use App\Entity\Collect;
use App\Form\CardFormType;
use App\Repository\CardCollectionRepository;
use App\Repository\CardRepository;
use App\Repository\CollectRepository;
use App\Repository\ExtensionRepository;
use App\Repository\GameRepository;
use App\Repository\UserRepository;
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

        $comments = $card->getCardCommentaryId();

        return $this->render('card/index.html.twig', [
            'gameName' => $gameName,
            'extensionName' => $extensionName,
            'card' => $card,
            'comments' => $comments,
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

    #[Route('games/{gameName}/{extensionName}/{cardName}/delete', name: 'delete_card',  methods: ['GET'])]
    public function delete_card(CardRepository $cardRepository, $gameName, $extensionName, $cardName): Response
    {
        $card = $cardRepository->findByCardName($cardName);

        if (!$card) { //verifier si le jeu existe et rediriger si ce n'est pas le cas
            return $this->redirectToRoute('extension', ['gameName' => $gameName, 'extensionName' => $extensionName]);
        }
        $cardRepository->remove($card, true);
        return $this->redirectToRoute('extension', ['gameName' => $gameName, 'extensionName' => $extensionName]);
    }

    #[Route('games/{gameName}/{extensionName}/{cardName}/edit', name: 'edit_card', methods: ['GET', 'POST'])]
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

    #[Route('add/{userId}/{gameName}/{cardId}', name: 'add_card_to_collect')]
    public function incrementCardInCollection($userId, $gameName, $cardId, UserRepository $userRepository, GameRepository $gameRepository, CollectRepository $collectRepository, CardRepository $cardRepository, CardCollectionRepository $cardCollectionRepository, EntityManagerInterface $entityManager): Response
    {
        $user = $userRepository->find($userId);
        $game = $gameRepository->findByGameName($gameName);
        $card = $cardRepository->find($cardId);

        if (!$game) {
            return $this->redirectToRoute('games');
        }

        $collect = $collectRepository->findCollectionByUserAndGame($user, $game);

        if ($collect) {
            $cardCollection = $cardCollectionRepository->findOneByCardAndCollect($card, $collect);

            if ($cardCollection) {
                // Si la CardCollection existe déjà, augmente la quantité de 1
                $quantity = $cardCollection->getQuantity() + 1;
                $cardCollection->setQuantity($quantity);

                $entityManager->persist($cardCollection);
                $entityManager->flush();
            } else {
                // Si la CardCollection n'existe pas, créez-en une nouvelle avec une quantité de 1
                $cardCollect = new CardCollection();
                $cardCollect->setCardId($card);
                $cardCollect->setCollectId($collect);
                $cardCollect->setQuantity(1);

                $entityManager->persist($cardCollect);
                $entityManager->flush();
            }
        } else {
            $newCollect = new Collect();
            $newCollect->setUserId($user);
            $newCollect->setGameId($game);

            $entityManager->persist($newCollect);
            $entityManager->flush();

            // Maintenant que le Collect est persisté, on peut l'utiliser
            $cardCollect = new CardCollection();
            $cardCollect->setCardId($card);
            $cardCollect->setCollectId($newCollect); 

            $entityManager->persist($cardCollect);
            $entityManager->flush();
        }
        return new Response(null, Response::HTTP_NO_CONTENT);
    }

    #[Route('remove/{userId}/{gameName}/{cardId}', name: 'remove_card_to_collect')]
    public function decrementCardInCollection($userId, $gameName, $cardId, UserRepository $userRepository, GameRepository $gameRepository, CollectRepository $collectRepository, CardRepository $cardRepository, CardCollectionRepository $cardCollectionRepository, EntityManagerInterface $entityManager): Response
    {
        $user = $userRepository->find($userId);
        $game = $gameRepository->findByGameName($gameName);
        $card = $cardRepository->find($cardId);

        if (!$game) {
            return $this->redirectToRoute('games');
        }

        $collect = $collectRepository->findCollectionByUserAndGame($user, $game);

        if ($collect) {
            $cardCollection = $cardCollectionRepository->findOneByCardAndCollect($card, $collect);

            if ($cardCollection) {
                // Si la CardCollection existe déjà, diminue la quantité de 1 jusqu'à un minimum de 0
                $currentQuantity = $cardCollection->getQuantity();
                $newQuantity = max($currentQuantity - 1, 0);
                $cardCollection->setQuantity($newQuantity);

                $entityManager->persist($cardCollection);
                $entityManager->flush();
            }
        }

        return new Response(null, Response::HTTP_NO_CONTENT);
    }
}
