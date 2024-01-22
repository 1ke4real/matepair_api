<?php

namespace App\DataFixtures;



use App\Entity\WeekDay;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class WeekDayFixtures extends Fixture {
    public function load(ObjectManager $manager): void
    {
        $weekDays = [
            'Lundi',
            'Mardi',
            'Mercredi',
            'Jeudi',
            'Vendredi',
            'Samedi',
            'Dimanche',
        ];

        foreach ($weekDays as $weekDay) {
            $weekDayEntity = new WeekDay();
            $weekDayEntity->setName($weekDay);
            $manager->persist($weekDayEntity);
        }
        $manager->flush();
    }
}
