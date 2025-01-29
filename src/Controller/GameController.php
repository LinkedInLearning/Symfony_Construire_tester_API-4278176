<?php

namespace App\Controller;

use App\Repository\GameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class GameController extends AbstractController
{
    #[Route('/api', name: 'app_game')]
    public function index(): JsonResponse
    {
        $data = [
            'id' => 1,
            'title' => 'Mario Kart 8 Deluxe'
        ];

        //return $this->json($data);
        return new JsonResponse($data, Response::HTTP_OK, [], false);
    }
}
