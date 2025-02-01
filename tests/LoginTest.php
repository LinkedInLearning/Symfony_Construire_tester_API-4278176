<?php

namespace App\Tests;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class LoginTest extends WebTestCase
{
    private $client;
    private EntityManagerInterface $entityManager;
    private UserPasswordHasherInterface $passwordHasher;


    protected function setUp(): void
    {
        // Création du client pour les requêtes HTTP
        $this->client = static::createClient();
        $this->entityManager = static::getContainer()->get(EntityManagerInterface::class);
        $this->passwordHasher = static::getContainer()->get(UserPasswordHasherInterface::class);

        // Suppression des anciens utilisateurs et création d'un nouveau
        $this->resetDatabase();
        $this->createTestUser();
    }

    private function resetDatabase(): void
    {
        $this->entityManager->createQuery('DELETE FROM App\Entity\User')->execute();
    }

    private function createTestUser(): void
    {
        $user = new User();
        $user->setEmail('test@test.com');
        $user->setRoles(['ROLE_USER']);
        $user->setPassword($this->passwordHasher->hashPassword($user, '123'));

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    // On vérifie qu'on récupère bien un token lors de la connexion et on le retourne
    private function getToken(): string
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

    // On vérifie qu'on a bien une erreur quand on se connecte avec de mauvais identifiants
    public function testInvalidCredentials()
    {
        // Mauvais mot de passe
        $this->client->request('POST', '/api/login_check', [], [], [
            'CONTENT_TYPE' => 'application/json',
        ], json_encode([
            'username' => 'test@test.com',
            'password' => 'unmauvaismotdepasse'
        ]));

        $this->assertResponseStatusCodeSame(401, "Un mauvais mot de passe devrait retourner 401");

        // Email inexistant
        $this->client->request('POST', '/api/login_check', [], [], [
            'CONTENT_TYPE' => 'application/json',
        ], json_encode([
            'username' => 'doesnotexist@example.com',
            'password' => '123'
        ]));

        $this->assertResponseStatusCodeSame(401, "Un utilisateur inexistant devrait retourner 401");
    }
}
