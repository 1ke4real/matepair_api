<?php

namespace App\Service;

use App\Repository\UserRepository;
use App\Repository\WeekDayRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use App\Entity\User;
class TokenDecode
{
    private $userRepository;

    public function __construct(UserRepository $userRepository, JWTEncoderInterface $encoder, WeekDayRepository $weekDayRepository)
    {
        $this->userRepository = $userRepository;
        $this->encoder = $encoder;
        $this->weekDayRepository = $weekDayRepository;
    }

    public function decode(string $jwt): array
    {
        $payload = [];
        $user = [];
        $jwt = str_replace('Bearer ', '', $jwt);
        $payload = $this->encoder->decode($jwt);
        $user = $this->userRepository->findOneBy(['email' => $payload['email']]);
        if ($user instanceof User){
            return [
                'id' => $user->getId(),
                'email' => $user->getEmail(),
                'username' => $user->getUsername(),
                'roles' => $user->getRoles(),
                'details' => $user->getDetails(),
                'favoriteGames' => $user->getFavoriteGames(),
                'weekDays' =>$user->getWeekDays(),
                'timeDays' => $user->getTimeDays(),
            ];
        }
//        if ($user instanceof User) {
//            foreach ($user as $u) {
//                $user = [
//                    'id' => $u->getId(),
//                    'email' => $u->getEmail(),
//                    'username' => $u->getUsername(),
//                    'roles' => $u->getRoles(),
//                    'details' => $u->getDetails(),
//                    'favoriteGames' => $u->getFavoriteGames(),
//                    'weekDays' =>$u->getWeekDays(),
//                    'timeDays' => $u->getTimeDays(),
//                ];
//            }
//        } else{
//            $user = [
//                'error' => 'User not found'
//            ];
//        }
    }
}
