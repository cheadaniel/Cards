<?php

namespace App\Controller;

use App\Entity\Game;
use App\Form\GameFormType;
use App\Repository\ExtensionRepository;
use App\Repository\GameRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{
    #[Route('/games', name: 'games')]
    public function index(GameRepository $gameRepository): Response
    {
        $games = $gameRepository->findAll();

        return $this->render('game/index.html.twig', [
            'games' => $games,
        ]);
    }

    #[Route('/games/{gameName}', name: 'game')]
    public function game($gameName, ExtensionRepository $extensionRepository): Response
    {
        $extensions = $extensionRepository->findAll();

        return $this->render('game/game.html.twig', [
            'gameName' => $gameName,
            'extensions' => $extensions,
        ]);
    }

    #[Route('admin/games/create', name: 'create_game')]
    public function create_game(Request $request, EntityManagerInterface $entityManager): Response
    {
        $game = new Game();

        $form = $this->createForm(GameFormType::class, $game);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($game);
            $entityManager->flush();
            return $this->redirectToRoute('games');
        }


        return $this->render('game/createGame.html.twig', [
            'gameForm' => $form->createView(),
        ]);
    }

    #[Route('admin/games/delete/{gameName}', name: 'delete_game',  methods: ['GET'])]
    public function delete_game(GameRepository $gameRepository, $gameName): Response
    {
        $game = $gameRepository->findByGameName($gameName);

        if (!$game) { //verifier si le jeu existe et rediriger si ce n'est pas le cas
            return $this->redirectToRoute('games');
        }
        // il faut au préalable supprimer toutes les extensions, les cartes, les commentaires, les deck et collections associées
        // $this->deleteExtensionsAndRelatedData($game, $entityManager);
        // $this->deleteCardsAndRelatedData($game, $entityManager);
        // $this->deleteCommentsAndRelatedData($game, $entityManager);
        // $this->deleteDecksAndRelatedData($game, $entityManager);
        // $this->deleteCollectionsAndRelatedData($game, $entityManager);

        //dd($game);
        $gameRepository->remove($game, true);
        return $this->redirectToRoute('games');
    }

    #[Route('admin/games/edit/{gameName}', name: 'edit_game', methods: ['GET', 'POST'])]
    public function edit_game(Request $request, EntityManagerInterface $entityManager, GameRepository $gameRepository, $gameName): Response
    {
        $post = $gameRepository->findByGameName($gameName);
        $form = $this->createForm(gameFormType::class, $post);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('games');
        }
        return $this->render('game/editGame.html.twig', [
            'gameForm' => $form->createView(),
        ]);
    }
}
