<?php

namespace App\Controller;

use App\Repository\GameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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
    public function showGames(Request $request, SerializerInterface $serializer, GameRepository $gameRepository): JsonResponse
    {
        $numPage = $request->get('page', 1);
        $limit = $request->get('limit', 3);
        $gamesList = $gameRepository->findAllWithPagination($numPage, $limit);

        if ($gamesList) {
            $jsonGames = $serializer->serialize($gamesList, 'json', ['groups' => 'getGames']);
            return new JsonResponse($jsonGames, Response::HTTP_OK, [], true);
        }

        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }


    #[Route('/api/games/{id}', name: 'app_show_game_details', methods: ['GET'])]
    public function showDetailsGame(int $id, SerializerInterface $serializer, GameRepository $gameRepository): JsonResponse
    {
        $game = $gameRepository->find($id);

        if ($game) {
            $jsonGameDetails = $serializer->serialize($game, 'json', ['groups' => 'getGames']);
            return new JsonResponse($jsonGameDetails, Response::HTTP_OK, [], true);
        }

        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }
}
