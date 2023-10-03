<?php

namespace App\Controller;

use App\Entity\Extension;
use App\Form\ExtensionFormType;
use App\Repository\GameRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ExtensionController extends AbstractController
{
    #[Route('/extension', name: 'app_extension')]
    public function index(): Response
    {
        return $this->render('extension/index.html.twig', [
            'controller_name' => 'ExtensionController',
        ]);
    }

    #[Route('admin/games/{gameName}/extension/create', name: 'create_extension')]
    public function create_game(Request $request, EntityManagerInterface $entityManager, $gameName, GameRepository $gameRepository): Response
    {

        $game = $gameRepository->findByGameName($gameName);
        if (!$game) { //verifier si le jeu existe et rediriger si ce n'est pas le cas
            return $this->redirectToRoute('games');
        }

        $extension = new Extension();

        $form = $this->createForm(ExtensionFormType::class, $extension);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $extension->setGameId($game);
            $entityManager->persist($extension);
            $entityManager->flush();
            return $this->redirectToRoute('game', ['gameName' => $gameName], Response::HTTP_SEE_OTHER);
        }


        return $this->render('extension/createExtension.html.twig', [
            'extensionForm' => $form->createView(),
        ]);
    }
}
