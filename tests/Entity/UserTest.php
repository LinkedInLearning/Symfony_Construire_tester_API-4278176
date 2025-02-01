<?php

namespace App\Tests\Entity;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserTest extends KernelTestCase
{

    private ValidatorInterface $validator;

    protected function setUp(): void
    {
        self::bootKernel(); // Démarre Symfony pour accéder au container
        $this->validator = static::getContainer()->get(ValidatorInterface::class);
    }

    public function testSomething(): void
    {
        $user = new User();
        $user->setEmail("test@test.com");
        $user->setRoles(["ROLE_USER"]);
        $user->setPassword("123");

        // Valide l'objet entier avec ses contraintes définies dans l'entité
        $errors = $this->validator->validate($user);
        $this->assertCount(0, $errors);


        // Test avec un email vide
        $user->setEmail("");
        $errors = $this->validator->validate($user);
        $this->assertCount(2, $errors);


        // Test avec un email trop court (moins de 3 caractères)
        $user->setEmail("t");
        $errors = $this->validator->validate($user);
        $this->assertCount(1, $errors);
    }
}
