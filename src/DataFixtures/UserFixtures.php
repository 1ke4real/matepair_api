<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use Faker\Factory;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $admin = new User();
        $admin->setEmail('admin@admin.com');
        $admin->setPassword(password_hash('toto', PASSWORD_BCRYPT));
        for ($i = 0; $i < 10; ++$i) {
            $user = new User();
            $user->setEmail($faker->email);
            $user->setPassword(password_hash('toto', PASSWORD_BCRYPT));
            $manager->persist($user);
        }
        $manager->flush();
    }
}
