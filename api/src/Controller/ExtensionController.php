<?php

namespace App\Controller;

use App\Entity\Extension;
use App\Form\ExtensionFormType;
use App\Repository\CardRepository;
use App\Repository\ExtensionRepository;
use App\Repository\GameRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ExtensionController extends AbstractController
{
    #[Route('games/{gameName}/{extensionName}/', name: 'extension')]
    public function index($gameName, $extensionName, CardRepository $cardRepository): Response
    {
        $cards = $cardRepository->findCardsByGameAndExtension($gameName, $extensionName);
        //dd($cards); 

        return $this->render('extension/index.html.twig', [
            'gameName' => $gameName,
            'extensionName' => $extensionName,
            'cards' => $cards,
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

    #[Route('admin/games/{gameName}/{extensionName}/delete', name: 'delete_extension',  methods: ['GET'])]
    public function delete_extension(ExtensionRepository $extensionRepository, $gameName, $extensionName): Response
    {
        $extension = $extensionRepository->findByExtensionName($extensionName);

        if (!$extension) { //verifier si le jeu existe et rediriger si ce n'est pas le cas
            return $this->redirectToRoute('game', ['gameName' => $gameName]);
        }
        $extensionRepository->remove($extension, true);
        return $this->redirectToRoute('game', ['gameName' => $gameName]);
    }

    #[Route('admin/games/{gameName}/{extensionName}/edit', name: 'edit_extension', methods: ['GET', 'POST'])]
    public function edit_extension(Request $request, EntityManagerInterface $entityManager, ExtensionRepository $extensionRepository, $gameName, $extensionName): Response
    {
        $post = $extensionRepository->findByExtensionName($extensionName);
        $form = $this->createForm(ExtensionFormType::class, $post);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('game', ['gameName' => $gameName]);
        }
        return $this->render('extension/editExtension.html.twig', [
            'extensionForm' => $form->createView(),
        ]);
    }
}
