<?php

namespace App\DataFixtures;

use App\Entity\TimeDay;
use App\Entity\WeekDay;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use Faker\Factory;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $getWeekDays = $manager->getRepository(WeekDay::class)->findAll();
        $getTimeDays = $manager->getRepository(TimeDay::class)->findAll();
        // Admin
        $admin = new User();
        $admin->setUsername('admin');
        $admin->setEmail('admin@admin.com');
        $admin->setPassword(password_hash('toto', PASSWORD_BCRYPT));
        $admin->setRoles(['ROLE_ADMIN']);
        $manager->persist($admin);

        // Users
        for ($i = 0; $i < 10; ++$i) {
            $user = new User();
            $user->setUsername($faker->userName);
            $user->setEmail($faker->email);
            $user->setPassword(password_hash('toto', PASSWORD_BCRYPT));

            if ($i !== 0) {
                $favoriteGamesJson = '
                  [
                    {
                      "title": "The Witcher 3: Wild Hunt",
                      "platform": "PlayStation 4",
                      "genre": "Action-RPG",
                      "release_year": 2015
                    },
                    {
                      "title": "The Legend of Zelda: Breath of the Wild",
                      "platform": "Nintendo Switch",
                      "genre": "Action-Adventure",
                      "release_year": 2017
                    },
                    {
                      "title": "Red Dead Redemption 2",
                      "platform": "Xbox One",
                      "genre": "Action-Adventure",
                      "release_year": 2018
                    }
                  ]
                ';

                $favoriteGamesData = json_decode($favoriteGamesJson, true);
                $user->setFavoriteGames($favoriteGamesData);
                do {
                    $randomWeekDay = $getWeekDays[array_rand($getWeekDays)];
                } while ($randomWeekDay->getId() === 0);
                $user->addWeekDay($randomWeekDay);

                do {
                    $randomTimeDay = $getTimeDays[array_rand($getTimeDays)];
                } while ($randomTimeDay->getId() === 0);
                $user->addTimeDay($randomTimeDay);
            }
            $manager->persist($user);
        }

        $manager->flush();
    }
}
