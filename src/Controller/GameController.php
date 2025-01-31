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
use Nelmio\ApiDocBundle\Attribute\Model;
use Nelmio\ApiDocBundle\Attribute\Security;
use OpenApi\Attributes as OA;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class GameController extends AbstractController
{

    #[Route('/api/getExternalData', name: 'app_other_api', methods: 'GET')]
    public function getSymfonyDoc(HttpClientInterface $httpClient): JsonResponse
    {
        $response = $httpClient->request(
            'GET',
            'https://api.github.com/repos/symfony/symfony-docs'
        );
        return new JsonResponse($response->getContent(), $response->getStatusCode(), [], true);
    }

    /*#[Route('/api', name: 'app_game')]
    public function index(): JsonResponse
    {
        $data = [
            'id' => 1,
            'title' => 'Mario Kart 8 Deluxe'
        ];

        //return $this->json($data);
        return new JsonResponse($data, Response::HTTP_OK, [], false);
    }*/

    #[Route('/api/games', name: 'app_show_games', methods: ['GET'])]
    #[OA\Response(
        response: 200,
        description: 'Retourne la liste des jeux',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: Game::class, groups: ['full']))
        )
    )]
    #[OA\Parameter(
        name: 'page',
        in: 'query',
        description: 'Numéro de la page désiré',
        schema: new OA\Schema(type: 'string')
    )]
    #[OA\Parameter(
        name: 'limit',
        in: 'query',
        description: 'Nombre de jeux désirés',
        schema: new OA\Schema(type: 'string')
    )]
    #[OA\Tag(name: 'Read')]
    #[Security(name: 'bearerAuth')]
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
    #[OA\Tag(name: 'Read')]
    #[Security(name: 'bearerAuth')]
    #[OA\Response(
        response: 200,
        description: 'Retourne les détails d\'un jeu',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: Game::class, groups: ['full']))
        )
    )]
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
    #[OA\Tag(name: 'Create')]
    #[Security(name: 'bearerAuth')]
    #[OA\Response(
        response: 201,
        description: 'Jeu créé avec succès',
        content: new OA\JsonContent(ref: new Model(type: Game::class, groups: ['full']))
    )]
    #[OA\RequestBody(
        description: 'Données du jeu à ajouter',
        content: new OA\JsonContent(ref: new Model(type: Game::class, groups: ['full']))
    )]
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
    #[OA\Tag(name: 'Update')]
    #[Security(name: 'bearerAuth')]
    #[OA\Response(
        response: 200,
        description: 'Met à jour les informations d\'un jeu',
        content: new OA\JsonContent(ref: new Model(type: Game::class, groups: ['full']))
    )]
    #[OA\RequestBody(
        description: 'Données du jeu à mettre à jour',
        content: new OA\JsonContent(ref: new Model(type: Game::class, groups: ['full']))
    )]
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



    #[Route('/api/games/{id}', name: 'app_delete_game', methods: ['DELETE'])]
    #[OA\Tag(name: 'Delete')]
    #[Security(name: 'bearerAuth')]
    public function deleteGame(Game $game, EntityManagerInterface $entityManager): JsonResponse
    {
        $entityManager->remove($game);
        $entityManager->flush();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
