<?php

namespace App\Controller;

use App\Entity\Message;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;// Utilisation de JWTTokenAuthenticator

class SendController extends AbstractController
{
    #[Route(path: 'api/send/{id}', name: 'send_message')]
    public function sendTo(Request $request, int $id, UserRepository $userRepository, EntityManagerInterface $entityManager)
    {
        $auth = $this->getUser()->getId();
        $user = $userRepository->find($auth);
        if (!$auth || !$user) {
            return $this->json(['message' => 'No user found'], Response::HTTP_NOT_FOUND);
        }
        $message = json_decode($request->getContent(), true);
        $message = $message['content'];

        $new = new Message();
        $new->setContent($message);
        $new->setSender($user);
        $new->setReceiver($userRepository->find($id));
        $new->setTimestamp(new \DateTime());

        $entityManager->persist($new);
        $entityManager->flush();

        return $this->json(['message' => 'Message sent'], Response::HTTP_OK);
    }
}
