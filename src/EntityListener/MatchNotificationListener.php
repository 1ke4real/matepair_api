<?php

namespace App\EntityListener;

use App\Entity\Matche;
use App\Entity\Notification;
use App\Enum\MatchStatus;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\Persistence\Event\LifecycleEventArgs;

#[AsEntityListener(event: 'prePersist', entity: Matche::class)]
#[AsEntityListener(event: 'preUpdate', entity: Matche::class)]

class MatchNotificationListener
{
    public function __invoke(Matche $match, LifecycleEventArgs $event): void
    {
        if ($match->getStatus() === MatchStatus::ACCEPTED) {

                $firstNotification = new Notification();
                $firstNotification->setUserId($match->getUserFirst());
                $firstNotification->setTitle('Match accepté');
                $firstNotification->setContent('Votre match avec ' . $match->getUserSecond()->getUsername() . ' a été accepté');
                $firstNotification->setTimestamp(new \DateTime());

                $secondNotification = new Notification();
                $secondNotification->setUserId($match->getUserSecond());
                $secondNotification->setTitle('Match accepté');
                $secondNotification->setContent('Votre match avec ' . $match->getUserFirst()->getUsername() . ' a été accepté');
                $secondNotification->setTimestamp(new \DateTime());

                $event->getObjectManager()->persist($firstNotification);
                $event->getObjectManager()->persist($secondNotification);
                $event->getObjectManager()->flush();

        }
    }
}
