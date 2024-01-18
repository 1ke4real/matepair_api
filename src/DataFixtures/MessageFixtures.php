<?php

namespace App\DataFixtures;

use App\Entity\Message;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use Faker\Factory;
class MessageFixtures extends Fixture{
    public function load(ObjectManager $manager): void
    {
       $faker = Factory::create('fr_FR');
       $getUsers = $manager->getRepository(User::class)->findAll();
        for ($i = 0 ; $i < 5; $i++){
            $sender = $getUsers[array_rand($getUsers)];
            do {
                $receiver = $getUsers[array_rand($getUsers)];
            } while ($receiver === $sender);
            $message = new Message();
            $message->setSender($sender);
            $message->setReceiver($receiver);
            $message->setTimestamp($faker->dateTime);
            $message->setContent("tijtirjjg");
            $manager->persist($message);
        }
        $manager->flush();

    }
}
