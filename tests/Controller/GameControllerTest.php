<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class GameControllerTest extends WebTestCase
{
    private $client;

    protected function setUp(): void
    {
        $this->client = static::createClient();
    }


    public function loginAsUser()
    {
        $this->client->request('POST', '/api/login_check', [], [], [
            'CONTENT_TYPE' => 'application/json',
        ], json_encode([
            'username' => 'test@test.com',
            'password' => '123'
        ]));

        $this->assertResponseIsSuccessful();
        $data = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('token', $data, 'Le token JWT est absent de la réponse');

        return $data['token'];
    }

    public function testAccessProtectedRouteWithoutToken()
    {
        $this->client->request('GET', '/api/games');

        $this->assertResponseStatusCodeSame(401);
    }

    public function testShowGames()
    {
        $token = $this->loginAsUser();
        $this->client->request('GET', '/api/games', [], [], [
            'HTTP_AUTHORIZATION' => 'Bearer ' . $token
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertJson($this->client->getResponse()->getContent());
    }


    public function testShowGameDetailsNotFound()
    {
        $token = $this->loginAsUser();
        $this->client->request('GET', '/api/games/9999', [], [], [
            'HTTP_AUTHORIZATION' => 'Bearer ' . $token
        ]);

        $this->assertResponseStatusCodeSame(404);
    }


    public function testAddNewGame()
    {
        $token = $this->loginAsUser();
        $this->client->request('POST', '/api/games', [], [], [
            'CONTENT_TYPE' => 'application/json',
            'HTTP_AUTHORIZATION' => 'Bearer ' . $token
        ], json_encode([
            'idDeveloper' => 1,
            'title' => 'New Game',
            'releaseDate' => "2025-02-01T00:00:00+00:00",
            'price' => 50.99,

        ]));

        $this->assertResponseStatusCodeSame(201);
    }


    public function testUpdateGame()
    {
        $token = $this->loginAsUser();
        $this->client->request('PUT', '/api/games/1', [], [], [
            'CONTENT_TYPE' => 'application/json',
            'HTTP_AUTHORIZATION' => 'Bearer ' . $token
        ], json_encode([
            'title' => 'Updated Game Title',
            'releaseDate' => '2025-02-01 12:00:00',
            'price' => 50,
            'idDeveloper' => 1
        ]));

        $this->assertResponseStatusCodeSame(204);
    }


    public function testDeleteGame()
    {
        $token = $this->loginAsUser();
        $this->client->request('DELETE', '/api/games/1', [], [], [
            'HTTP_AUTHORIZATION' => 'Bearer ' . $token
        ]);

        $this->assertResponseStatusCodeSame(204);
    }
}
