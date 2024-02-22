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
        $AllWeekDays = $weekDayRepository->findAll();
        $AllTimeDays = $timeDayRepository->findAll();
        $weekDays = $data['weekDays'];
        $timeDays = $data['timeDays'];
       if ($user instanceof User){
           $user->setEmail($data['email']);
           $user->setUsername($data['username']);
           $user->setFavoriteGames($data['favoriteGames']);
           foreach ($AllWeekDays as $day) {
               $dayName = $day->getName();
               $found = false;
               foreach ($weekDays as $receivedDay) {
                   if ($receivedDay['name'] === $dayName) {
                       $found = true;
                       break;
                   }
               }
               if (!$found) {
                   $user->removeWeekDay($day);
               }
           }
           foreach ($AllTimeDays as $timeDay) {
               $timeDayName = $timeDay->getName();
               $found = false;
               foreach ($timeDays as $receivedTimeDay) {
                   if ($receivedTimeDay['name'] === $timeDayName) {
                       $found = true;
                       break;
                   }
               }
               if (!$found) {
                   $user->removeTimeDay($timeDay);
               }
           }
           $entityManager->persist($user);
           $entityManager->flush();
           return $this->json($user);
       }
        return $this->json(['error' => 'User not found'], Response::HTTP_NOT_FOUND);
    }
}
