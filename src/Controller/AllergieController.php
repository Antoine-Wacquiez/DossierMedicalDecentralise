<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AllergieController extends AbstractController
{
    #[Route('/allergie', name: 'app_allergie')]
    public function index(): Response
    {
        return $this->render('allergie/index.html.twig', [
            'controller_name' => 'AllergieController',
        ]);
    }
}
