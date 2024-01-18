<?php

namespace App\Controller;

use App\Repository\MessageRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\MessageData;
class MessageByUserController extends AbstractController
{

    #[Route(path: 'api/message/send/{id}', name: 'message_send_by_user')]
    public function send(Request $request, int $id, MessageRepository $messageRepository, MessageData $messageData): Response
    {
        $messages = $messageRepository->findMessageSend($id);
        $data = $messageData->buildMessageArray($messages);
        if ($data === []) {
            return $this->json(['message' => 'No message found'], Response::HTTP_NOT_FOUND);
        }
        return $this->json($data);
    }
    #[Route(path: 'api/message/receive/{id}', name: 'message_receive_by_user')]
    public function receive(Request $request, int $id, MessageRepository $messageRepository, MessageData $messageData): Response
    {
        $messages = $messageRepository->findMessageReceive($id);
        $data = $messageData->buildMessageArray($messages);
        if ($data === []) {
            return $this->json(['message' => 'No message found'], Response::HTTP_NOT_FOUND);
        }
        return $this->json($data);
    }
}
