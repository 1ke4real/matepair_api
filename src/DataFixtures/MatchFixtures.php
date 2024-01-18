<?php

namespace App\DataFixtures;

use App\Entity\Matche;
use App\Entity\User;
use App\Enum\MatchStatus;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MatchFixtures extends Fixture{
    public function load(ObjectManager $manager): void
    {
        $getUsers = $manager->getRepository(User::class)->findAll();
        for ($i = 0; $i < 5; $i++) {
            $firstMatch = $getUsers[array_rand($getUsers)];
            do {
                $secondMatch = $getUsers[array_rand($getUsers)];
            } while ($firstMatch === $secondMatch);
            $match = new Matche();
            $match->setUserFirst($firstMatch);
            $match->setUserSecond($secondMatch);
            $match->setStatus(MatchStatus::WAITING);
            $manager->persist($match);
        }
        $manager->flush();
    }
}

