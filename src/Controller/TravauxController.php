<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


class TravauxController extends AbstractController
{
    #[Route('/travaux', name: 'travaux')]
    public function index(): Response
    {
        if ($this->getUser()) 
        return $this->render('travaux/travaux.html.twig', [
            'controller_name' => 'TravauxController',
        ]);
    }
}
