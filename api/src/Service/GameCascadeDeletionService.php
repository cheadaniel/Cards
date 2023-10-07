<?php

namespace App\Service;

use App\Entity\Game;
use App\Entity\Extension;
use App\Entity\Card;
use App\Entity\Comment;
use App\Entity\Deck;
use App\Entity\Collection;
use Doctrine\ORM\EntityManagerInterface;

class GameCascadeDeletionService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function deleteGame(Game $game)
    {
        // Supprimer les extensions, les cartes et autres entités en cascade
        $this->deleteExtensions($game);
        // $this->deleteDecks($game);
        // $this->deleteCollections($game);

        // Enfin, supprimez le jeu lui-même
        $this->entityManager->remove($game);
        //$this->entityManager->flush();
    }

    public function deleteExtensions(Game $game)
    {
        $extensions = $game->getGameExtensionId();

        foreach ($extensions as $extension) {
            // Supprimez les cartes liées à cette extension
            $this->deleteCardsForExtension($extension);

            // Supprimez l'extension
            $this->entityManager->remove($extension);
        }

        //$this->entityManager->flush();
    }

    public function deleteCardsForExtension(Extension $extension)
    {
        $cards = $extension->getExtensionCardId();

        foreach ($cards as $card) {
            $this->deleteComments($card);
            $this->entityManager->remove($card);
        }
        //$this->entityManager->flush();
    }

    public function deleteComments(Card $card)
    {
        $comments = $card->getCardCommentaryId();

        foreach ($comments as $comment) {
            $this->entityManager->remove($comment);
        }

        //$this->entityManager->flush();
    }

    public function deleteDecks(Game $game)
    {
        $decks = $game->getGameDeckId();

        foreach ($decks as $deck) {
            // Supprimer les cartes liées à ce deck si nécessaire
            // $this->deleteCardsForDeck($deck);

            $this->entityManager->remove($deck);
        }

        //$this->entityManager->flush();
    }

    // Ajoutez les méthodes pour supprimer les cartes pour un deck si nécessaire

    public function deleteCollections(Game $game)
    {
        $collections = $game->getGameCollectId();

        foreach ($collections as $collection) {
            // Supprimez les cartes liées à cette collection si nécessaire
            // $this->deleteCardsForCollection($collection);

            $this->entityManager->remove($collection);
        }

        //$this->entityManager->flush();
    }

    // Ajoutez les méthodes pour supprimer les cartes pour une collection si nécessaire


}
