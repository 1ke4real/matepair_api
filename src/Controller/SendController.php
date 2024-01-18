<?php

namespace App\Controller;

use App\Service\UserToken;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Csrf\TokenStorage\TokenStorageInterface;

class SendController extends AbstractController
{
    #[Route(path: 'api/send/{id}', name: 'send_message')]
    public function sendTo(Request $request, int $id , UserToken $userToken)
    {
        dd($userToken->getUserByToken($request));
        dd($request);

        $message = json_decode($request->getContent(), true);
        $token = $tokenStorage->getToken();
        $user = $token->getUser();
        dd($user);
    }
}
