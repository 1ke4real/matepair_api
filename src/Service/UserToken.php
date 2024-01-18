<?php

namespace App\Service;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class UserToken{
    public function getUserByToken(Request $request): array{
       $token =  $request->headers->get('Authorization');
       $user = $token->getUserFromToken();
       dd($user);
    }
}
