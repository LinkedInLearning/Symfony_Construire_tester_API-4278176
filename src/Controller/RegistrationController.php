<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Nelmio\ApiDocBundle\Attribute\Model;
use Nelmio\ApiDocBundle\Attribute\Security;
use OpenApi\Attributes as OA;

final class RegistrationController extends AbstractController
{
    #[Route('/api/register', name: 'app_register', methods: ['POST'])]
    #[OA\Tag(name: 'Registration')]
    #[OA\Response(
        response: 201,
        description: 'Utilisateur créé avec succès',
        content: new OA\JsonContent(ref: new Model(type: User::class, groups: ['full']))
    )]
    #[OA\RequestBody(
        description: 'Données de l\'utilisateur à ajouter',
        content: new OA\JsonContent(ref: new Model(type: User::class, groups: ['full']))
    )]
    public function register(ValidatorInterface $validator, Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager, SerializerInterface $serializer): JsonResponse
    {
        $user = $serializer->deserialize($request->getContent(), User::class, 'json');

        // On vérifie les erreurs
        $errors = $validator->validate($user);

        if ($errors->count() > 0) {
            return new JsonResponse($serializer->serialize($errors, 'json'), JsonResponse::HTTP_BAD_REQUEST, [], true);
        }

        // Hash du mot de passe
        $hashedPassword = $passwordHasher->hashPassword($user, $user->getPassword());
        $user->setPassword($hashedPassword);

        $entityManager->persist($user);
        $entityManager->flush();

        return new JsonResponse($serializer->serialize($user, 'json', ['groups' => 'user:read']), 201, [], true);
    }
}
