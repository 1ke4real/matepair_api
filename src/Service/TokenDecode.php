<?php

namespace App\Service;

use App\Repository\UserRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;

class TokenDecode
{
    private $userRepository;

    public function __construct(UserRepository $userRepository, JWTEncoderInterface $encoder)
    {
        $this->userRepository = $userRepository;
        $this->encoder = $encoder;
    }

    public function decode(string $jwt): array
    {
        $payload = [];
        $user = [];
        $jwt = str_replace('Bearer ', '', $jwt);
        $payload = $this->encoder->decode($jwt);
        $user = $this->userRepository->findBy(['email' => $payload['email']]);

        if ($user) {
            foreach ($user as $u) {
                $user = [
                    'id' => $u->getId(),
                    'email' => $u->getEmail(),
                    'username' => $u->getUsername(),
                    'roles' => $u->getRoles(),
                    'details' => $u->getDetails(),
                    'favorite_games' => $u->getFavoriteGames(),
                    'week_days' => $u->getWeekDays(),
                    'days_time' => $u->getTimeDays(),
                ];
            }
        } else{
            $user = [
                'error' => 'User not found'
            ];
        }
        return $user;
    }
}
