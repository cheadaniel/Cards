<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Extension;
use App\Entity\Game;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ExtensionFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        // Créez un jeu de référence en utilisant la référence définie dans GameFixtures
        $game = $this->getReference('malkyrs_game');

        // Créez des données pour les extensions
        $extensionsData = [
            [
                'name' => 'AoE',
                'releaseDate' => new \DateTimeImmutable('2016-12-01'),
                'image' => 'malkyrs-logo.jpg',
            ],
            [
                'name' => 'Maden',
                'releaseDate' => new \DateTimeImmutable('2017-11-10'),
                'image' => 'malkyrs-logo.jpg',
            ],
            [
                'name' => 'Raids-sur-Oligar',
                'releaseDate' => new \DateTimeImmutable('2018-05-25'),
                'image' => 'malkyrs-logo.jpg',
            ],
            [
                'name' => 'Tumulte-sur-Oligar',
                'releaseDate' => new \DateTimeImmutable('2018-11-09'),
                'image' => 'malkyrs-logo.jpg',
            ],
        ];

        foreach ($extensionsData as $extensionData) {
            $extension = new Extension();
            $extension->setName($extensionData['name'])
                ->setReleaseDate($extensionData['releaseDate'])
                ->setImage($extensionData['image'])
                ->setGameId($game);

            $manager->persist($extension);
            // Ajoutez une référence à l'extension en utilisant un nom formaté
            $extensionReferenceName = strtolower(str_replace(' ', '_', $extensionData['name'])) . '-collection-' . $extensionData['releaseDate']->format('Y-m-d');
            $this->addReference($extensionReferenceName, $extension);
        }

        

        $manager->flush();
    }

    public function getDependencies()
    {
        // Spécifiez la classe de fixture dont ExtensionFixtures dépend
        return [
            GameFixtures::class,
        ];
    }
}
