<?php

namespace App\DataFixtures\Entity;

use App\Entity\Administrator;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AdministratorFixtures extends Fixture
{

    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }
    public function load(ObjectManager $manager): void
    {
        $administrator = new Administrator();
        $administrator->setUsername('admin');
        $administrator->setPassword($this->hasher->hashPassword($administrator, 'admin'));
        $administrator->setRoles(['ROLE_ADMIN']);
        $manager->persist($administrator);
        $manager->flush();
    }
}