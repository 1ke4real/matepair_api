<?php

namespace App\Controller;


use App\Entity\Notification;
use App\Repository\NotificationRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;


class NotificationByUserController extends AbstractController{
    #[Route(path: 'api/notification/me', name: 'notification_send_by_user')]
    public function __invoke(Request $request, UserRepository $userRepository)
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->json(['message' => 'No user found'], Response::HTTP_NOT_FOUND);
        }
        $user = $userRepository->find($user->getId());
        $notifications = $user->getNotifications();
        if ($notifications === []) {
            return $this->json(['message' => 'No notification found'], Response::HTTP_NOT_FOUND);
        }
        return $this->json($user->getNotifications());
    }
}
