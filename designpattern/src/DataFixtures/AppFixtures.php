<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $passwordHarsher)
    {

    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail('user1@gmail.com');
        $user->setPassword($this->passwordHarsher->hashPassword($user, '123456'));

        $manager->persist($user);
        $manager->flush();
    }
}
