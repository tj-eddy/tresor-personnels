<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // user superadmin
        $user = new User();
        $user->setEmail('3ddy.rakoto@gmail.com');
        $user->setUsername('Eddy RAKOTOARIVONY');
        $user->setPassword(password_hash('123456789', 'argon2i'));
        $user->setRoles(['ROLE_SUPERADMIN']);
        $manager->persist($user);

        $manager->flush();
    }
}
