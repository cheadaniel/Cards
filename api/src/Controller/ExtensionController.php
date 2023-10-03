<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
}
