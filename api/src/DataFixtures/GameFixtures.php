<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Game;


class GameFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // Créez une instance de la classe Game
        $game = new Game();

        // Définissez le nom du jeu
        $game->setName('Malkyrs');

        // Définissez le chemin de l'image (à ajuster selon votre structure)
        $imagePath = 'malkyrs-logo.jpg'; // Chemin vers l'image
        $game->setImage($imagePath);

        // Enregistrez l'objet Game dans la base de données
        $manager->persist($game);

        // Définissez une référence à cette entité Game
        $this->addReference('malkyrs_game', $game);
        $manager->flush();
    }
}
