<?php

namespace App\Controller;

use App\Entity\TimeDay;
use App\Entity\User;
use App\Repository\TimeDayRepository;
use App\Repository\UserRepository;
use App\Repository\WeekDayRepository;
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
    public function edit(Request $request, TokenDecode $tokenDecode, EntityManagerInterface $entityManager, UserRepository $userRepository, WeekDayRepository $weekDayRepository, TimeDayRepository $timeDayRepository){
        $jwt = $request->headers->get('Authorization');
        $user = $tokenDecode->decode($jwt);
        $data = json_decode($request->getContent(), true);
        $user = $userRepository->findOneBy(['email' => $data['email']]);
        $weekDays = $data['weekDays'];
        $timeDays = $data['timeDays'];
       if ($user instanceof User){
           $user->setEmail($data['email']);
           $user->setUsername($data['username']);
           $user->setFavoriteGames($data['favoriteGames']);
           foreach ($weekDays as $day) {
               $name = $day['name'];
               $weekDays = $weekDayRepository->findOneBy(['name' => $name]);
               $user->addWeekDay($weekDays);
           }
           foreach ($timeDays as $time) {
               $time_day = $time['name'];
               $timeDays = $timeDayRepository->findOneBy(['name' => $time_day]);
               $user->addTimeDay($timeDays);
           }
           $entityManager->persist($user);
           $entityManager->flush();
           return $this->json($user);
       }
        return $this->json(['error' => 'User not found'], Response::HTTP_NOT_FOUND);
    }
}
