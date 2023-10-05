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
        $imagePath = 'public/media/images/Malkyrs/malkyrs-logo.jpg'; // Chemin vers l'image

        // Assurez-vous que le chemin de l'image est correct
        if (file_exists($imagePath)) {
            // Stockez le chemin de l'image
            $game->setImage($imagePath);
        } else {
            // Générez un message d'erreur si le fichier image n'existe pas
            throw new \Exception("L'image n'existe pas : $imagePath");
        }

        // Enregistrez l'objet Game dans la base de données
        $manager->persist($game);

        // Définissez une référence à cette entité Game
        $this->addReference('malkyrs_game', $game);
        $manager->flush();
    }
}
