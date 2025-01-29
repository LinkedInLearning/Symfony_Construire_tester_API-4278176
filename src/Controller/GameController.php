<?php

namespace App\Controller;

use App\Entity\Game;
use App\Repository\DeveloperRepository;
use App\Repository\GameRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
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
        $limitNbGames = $request->get('limit', 3);
        $gamesList = $gameRepository->findAllWithPage($numPage, $limitNbGames);

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



    #[Route('/api/games', name: "app_add_game", methods: ['POST'])]
    public function addNewGame(Request $request, SerializerInterface $serializer, EntityManagerInterface $entityManager, DeveloperRepository $developerRepository): JsonResponse
    {

        $newGame = $serializer->deserialize($request->getContent(), Game::class, 'json');

        $content = $request->toArray();
        if ($content['idDeveloper']) {
            $idDeveloper = $content['idDeveloper'];
            $newGame->setDeveloper($developerRepository->find($idDeveloper));
        }

        $entityManager->persist($newGame);
        $entityManager->flush();

        $jsonJeu = $serializer->serialize($newGame, 'json', ['groups' => 'getGames']);

        return new JsonResponse($jsonJeu, Response::HTTP_CREATED, [], true);
    }



    #[Route('/api/games/{id}', name: "app_update_game", methods: ['PUT'])]
    public function updateGames(Game $currentGame, Request $request, SerializerInterface $serializer, EntityManagerInterface $entityManager, DeveloperRepository $developerRepository): JsonResponse
    {
        $updatedGame = $serializer->deserialize(
            $request->getContent(),
            Game::class,
            'json',
            [AbstractNormalizer::OBJECT_TO_POPULATE => $currentGame]
        );

        $content = $request->toArray();
        if ($content['idDeveloper']) {
            $idDeveloper = $content['idDeveloper'];
            $updatedGame->setDeveloper($developerRepository->find($idDeveloper));
        }

        $entityManager->persist($updatedGame);
        $entityManager->flush();

        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
