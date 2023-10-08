<?php

namespace App\Controller;

use App\Repository\CardRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    // #[Route('/home', name: 'app_home')]
    public function index(CardRepository $cardRepository): Response
    {
        // Obtenir les valeurs minimales et maximales des ID de cartes
        $minAndMaxIds = $cardRepository->findMinAndMaxCardIds();

        // Vérifier si les valeurs minimales et maximales sont définies
        if ($minAndMaxIds['minId'] !== null && $minAndMaxIds['maxId'] !== null) {
            $randomCardIds = [];

            // Générer 10 nombres aléatoires entre minId et maxId
            for ($i = 0; $i < 10; $i++) {
                $randomCardIds[] = rand($minAndMaxIds['minId'], $minAndMaxIds['maxId']);
            }
            //dd($randomCardIds);

            // Récupérer les cartes correspondantes aux ID aléatoires
            $randomCards = $cardRepository->findBy(['id' => $randomCardIds]);

            return $this->render('home/index.html.twig', [
                'randomCards' => $randomCards,
            ]);
        }
    }
}
