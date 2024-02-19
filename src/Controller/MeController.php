<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\TokenDecode;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Guard\JWTTokenAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class MeController extends AbstractController
{
    #[Route('api/me', name: 'app_me')]
    public function index(Request $request, TokenDecode $tokenDecode): Response
    {
        $jwt = $request->headers->get('Authorization');
        $user = $tokenDecode->decode($jwt);
        return $this->json($user);
    }

    #[Route('api/me/update', name: 'app_me_update')]
    public function edit(Request $request, TokenDecode $tokenDecode, EntityManagerInterface $entityManager){
        $jwt = $request->headers->get('Authorization');
        $user = $tokenDecode->decode($jwt);
        $data = json_decode($request->getContent(), true);
        $user->setEmail($data['email']);
        $user->setUsername($data['username']);
        $user->setDetails($data['details']);
        $user->setFavoriteGames($data['favorite_games']);
        $user->addWeekDay($data['week_days']);
        $user->addTimeDay($data['time_days']);
        $entityManager->persist($user);
        $entityManager->flush();
        return $this->json($user);
    }
}
