<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Card;
use App\Entity\Game;
use App\Entity\Extension;
use Symfony\Component\Serializer\SerializerInterface;

class CardFixtures extends Fixture implements DependentFixtureInterface
{
    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function load(ObjectManager $manager)
    {
        // Récupérez les extensions créées dans ExtensionFixtures
        $setDeBaseExtension = $this->getReference('aoe-collection-2016-12-01');
        $madenExtension = $this->getReference('maden-collection-2017-11-10');
        $raidsSurOligarExtension = $this->getReference('raids-sur-oligar-collection-2018-05-25');
        $tumulteSurOligarExtension = $this->getReference('tumulte-sur-oligar-collection-2018-11-09');

        // Chargez les données JSON pour chaque extension
        $setDeBaseCardsData = $this->loadJsonData('public/data/AoE-2016-12-01.json');
        $madenCardsData = $this->loadJsonData('public/data/Maden-2017-11-10.json');
        $raidsSurOligarCardsData = $this->loadJsonData('public/data/Raids_sur_Oligar-2018-05-25.json');
        $tumulteSurOligarCardsData = $this->loadJsonData('public/data/Tumulte_sur_Oligar-2018-11-09.json');

        // Créez des cartes à partir des données JSON et associez-les aux extensions correspondantes
        $this->createCards($manager, $setDeBaseExtension, $setDeBaseCardsData);
        $this->createCards($manager, $madenExtension, $madenCardsData);
        $this->createCards($manager, $raidsSurOligarExtension, $raidsSurOligarCardsData);
        $this->createCards($manager, $tumulteSurOligarExtension, $tumulteSurOligarCardsData);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            ExtensionFixtures::class,
        ];
    }

    private function loadJsonData(string $jsonFilePath): array
    {
        // Chargez le contenu du fichier JSON
        $jsonData = file_get_contents($jsonFilePath);

        // Désérialisez le JSON en un tableau associatif
        return $this->serializer->decode($jsonData, 'json');
    }

    private function createCards(ObjectManager $manager, Extension $extension, array $cardsData)
    {
        foreach ($cardsData as $cardData) {
            $card = new Card();
            $card->setName($cardData['name'] ?? null)
                ->setArtist($cardData['artist'] ?? null)
                ->setDescription($cardData['description'] ?? null)
                ->setImage($cardData['image'] ?? null)
                ->setNumber($cardData['number'] ?? null)
                ->setRarity($cardData['rarity'] ?? null)
                ->setType($cardData['type'] ?? null)
                ->setGameId($extension->getGameId())
                ->setExtensionId($extension);

            $manager->persist($card);
        }
    }
}
