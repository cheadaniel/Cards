<?php

namespace App\Controller;

use App\Entity\Game;
use App\Form\GameFormType;
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
    public function game($gameName): Response
    {

        return $this->render('game/game.html.twig', [
            'game' => $gameName,
        ]);
    }

    #[Route('admin/games/create', name:'create_game')]
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
        //dd($game);
        $gameRepository->remove($game, true);
        return $this->redirectToRoute('games');
    }
}
