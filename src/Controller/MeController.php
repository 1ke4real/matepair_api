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

            // Supprimer les jours de la semaine qui n'apparaissent pas
            $existingWeekDays = $user->getWeekDays();
            foreach ($existingWeekDays as $existingWeekDay) {
                if (!in_array($existingWeekDay->getName(), array_column($weekDays, 'name'))) {
                    $user->removeWeekDay($existingWeekDay);
                }
            }

            // Supprimer les moments de la journée qui n'apparaissent pas
            $existingTimeDays = $user->getTimeDays();
            foreach ($existingTimeDays as $existingTimeDay) {
                if (!in_array($existingTimeDay->getName(), array_column($timeDays, 'name'))) {
                    $user->removeTimeDay($existingTimeDay);
                }
            }

            // Ajouter les jours de la semaine qui n'existent pas encore
            foreach ($weekDays as $day) {
                $name = $day['name'];
                if (!$user->hasWeekDayWithName($name)) {
                    $weekDay = $weekDayRepository->findOneBy(['name' => $name]);
                    if ($weekDay) {
                        $user->addWeekDay($weekDay);
                    }
                }
            }

            // Ajouter les moments de la journée qui n'existent pas encore
            foreach ($timeDays as $time) {
                $time_day = $time['name'];
                if (!$user->hasTimeDayWithName($time_day)) {
                    $timeDay = $timeDayRepository->findOneBy(['name' => $time_day]);
                    if ($timeDay) {
                        $user->addTimeDay($timeDay);
                    }
                }
            }

            $entityManager->persist($user);
            $entityManager->flush();
            return $this->json($user);
        }
        return $this->json(['error' => 'User not found'], Response::HTTP_NOT_FOUND);
    }

}
