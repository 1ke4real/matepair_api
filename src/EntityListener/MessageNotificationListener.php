<?php

namespace App\EntityListener;


use App\Entity\Message;
use App\Entity\Notification;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;

#[AsEntityListener(event: 'prePersist', entity: Message::class)]
#[AsEntityListener(event: 'preUpdate', entity: Message::class)]
class MessageNotificationListener
{
    public function __invoke(Message $message, LifecycleEventArgs $event): void
    {
        $message->setTimestamp(new \DateTime());
        $notification = new Notification();
        $notification->setUserId($message->getReceiver());
        $notification->setTitle('Nouveau message');
        $notification->setContent('Vous avez reçu un nouveau message de '.$message->getSender()->getUsername());
        $notification->setTimestamp(new \DateTime());
        $event->getObjectManager()->persist($notification);
        $event->getObjectManager()->flush();
    }

}
