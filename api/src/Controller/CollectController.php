<?php

namespace App\Controller;

use App\Repository\CardCollectionRepository;
use App\Repository\CardRepository;
use App\Repository\CollectRepository;
use App\Repository\ExtensionRepository;
use App\Repository\GameRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CollectController extends AbstractController
{
    #[Route('/collection/{userName}', name: 'user_collect')]
    public function user_collection($userName, UserRepository $userRepository, CollectRepository $collectRepository): Response
    {

        $user = $userRepository->findByUserName($userName);
        $collects = $collectRepository->findCollectionByUser($user);
        //dd($collects);

        return $this->render('collect/userCollectGame.html.twig', [
            'userName' => $userName,
            'collects' =>  $collects,
        ]);
    }

    #[Route('/collection/{userName}/{gameName}', name: 'user_collect_extensions')]
    public function user_collect_game($userName, $gameName, ExtensionRepository $extensionRepository): Response
    {
        $extensions = $extensionRepository->findExtensionsByGameName($gameName);

        return $this->render('collect/userCollectExtension.html.twig', [
            'userName' => $userName,
            'gameName' => $gameName,
            'extensions' => $extensions,
        ]);
    }

    #[Route('/collection/{userName}/{gameName}/{extensionName}/', name: 'user_collect_cards')]
    public function user_collect_extension($userName, $gameName, $extensionName, CardRepository $cardRepository, UserRepository $userRepository, GameRepository $gameRepository, CollectRepository $collectRepository, CardCollectionRepository $cardCollectionRepository): Response
    {
        $user = $userRepository->findByUserName($userName);
        $game = $gameRepository->findByGameName($gameName);
        $collect = $collectRepository->findCollectionByUserAndGame($user, $game);

        $userOwnCards = $cardCollectionRepository->findCardsByCollect($collect);

        $cards = $cardRepository->findCardsByGameAndExtension($gameName, $extensionName);
        //dd($userOwnCards);



        return $this->render('collect/userCollectCards.html.twig', [
            'userName' => $userName,
            'gameName' => $gameName,
            'extensionName' => $extensionName,
            'cards' => $cards,
            'userOwnCards' => $userOwnCards,
        ]);
    }

    #[Route('tradeable/{userId}/{userCardCollectionId}', name: 'tradable')]
    public function toggleTradable($userId, $userCardCollectionId, CardCollectionRepository $cardCollectionRepository, EntityManagerInterface $entityManager)
    {
        $cardCollection = $cardCollectionRepository->find($userCardCollectionId);

        // Inversez l'état 'échangeable' (Tradable) de la carte
        $isTradable = $cardCollection->isTradable();
        $cardCollection->setTradable(!$isTradable);

        // Enregistrez les modifications dans la base de données
        $entityManager->persist($cardCollection);
        $entityManager->flush();

        return new Response(null, Response::HTTP_NO_CONTENT);
    }

    #[Route('favourite/{userId}/{userCardCollectionId}', name: 'favourite')]
    public function toggleFavourite($userId, $userCardCollectionId, CardCollectionRepository $cardCollectionRepository, EntityManagerInterface $entityManager)
    {
        $cardCollection = $cardCollectionRepository->find($userCardCollectionId);

        // Inversez l'état 'échangeable' (Tradable) de la carte
        $isFavourite = $cardCollection->isFavourite();
        $cardCollection->setFavourite(!$isFavourite);

        // Enregistrez les modifications dans la base de données
        $entityManager->persist($cardCollection);
        $entityManager->flush();

        return new Response(null, Response::HTTP_NO_CONTENT);
    }
}
