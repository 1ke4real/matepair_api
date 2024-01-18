<?php
namespace App\Service;

use App\Repository\MessageRepository;

class MessageData{

    public function buildMessageArray($message): array{
        $data = [];
        foreach ($message as $m) {
            $data[] = [
                'id' => $m->getId(),
                'content' => $m->getContent(),
                'sender' => [
                    'id' => $m->getSender()->getId(),
                    'username' => $m->getSender()->getUsername(),
                ],
                'receiver' => [
                    'id' => $m->getReceiver()->getId(),
                    'username' => $m->getReceiver()->getUsername(),
                ],
                'createdAt' => $m->getTimestamp(),
            ];
        }
        return $data;
    }
}
