<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use App\Service\LandRoute;

class LandRouteController extends AbstractController
{
    #[Route('/routing/{origin}/{destination}', name: 'routing', methods: 'GET')]
    public function routing(
        HttpClientInterface $httpClient,
        LandRoute $landRoute,
        string $origin, 
        string $destination
    ): Response
    {
        $route = $landRoute->find($origin, $destination);
        return $route ? new JsonResponse(['route' => $route], 200) : new JsonResponse(['route' => 'There is no land crossing'], 400);
    }
}