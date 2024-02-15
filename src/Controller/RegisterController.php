<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

class RegisterController extends AbstractController
{
    #[Route('/register', name: 'app_register', methods: ['POST'])]
    public function index(Request $request, User $user, EntityManagerInterface $entityManager, UserPasswordHasherInterface $hasher): Response
    {
        $data = json_decode($request->getContent(), true);
        if ($data['email'] && $data['username'] && $data['password']) {
            $user=new User();
            $user->setEmail($data['email']);
            $user->setUsername($data['username']);
            $user->setPassword($hasher->hashPassword($user, $data['password']));
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->json(['message' => 'User created'], Response::HTTP_CREATED);
        }
        return $this->json(['message' => 'User not created'], Response::HTTP_BAD_REQUEST);
    }
}
