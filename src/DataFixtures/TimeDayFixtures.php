<?php

namespace App\DataFixtures;


use App\Entity\TimeDay;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TimeDayFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $timeDays = [
            'Matin',
            'Après-midi',
            'Soir',
        ];

        foreach ($timeDays as $timeDay) {
            $timeDayEntity = new TimeDay();
            $timeDayEntity->setName($timeDay);
            $manager->persist($timeDayEntity);
        }
        $manager->flush();
    }
}
