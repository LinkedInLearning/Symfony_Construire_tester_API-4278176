<?php

namespace App\Controller;

use App\Repository\GameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

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

    #[Route('/api/games', name: 'app_show_games', methods: ['GET'])]
    public function showGames(SerializerInterface $serializer, GameRepository $gameRepository): JsonResponse
    {
        $gamesList = $gameRepository->findAll();

        if ($gamesList) {
            $jsonGames = $serializer->serialize($gamesList, 'json',);
            return new JsonResponse($jsonGames, Response::HTTP_OK, [], true);
        }

        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }
}
