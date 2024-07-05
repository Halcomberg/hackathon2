<?php

namespace App\Controller;

use App\Service\CallApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ApiController extends AbstractController
{
    #[Route('/offers', name: 'api_index')]
    public function index(CallApiService $callApiService): Response
    {
        $contents = $callApiService->getApiData();

        return $this->render('offers/index.html.twig', ['contents' => $contents]);
    }
}
