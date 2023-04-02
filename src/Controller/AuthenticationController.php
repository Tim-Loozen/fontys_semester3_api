<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Security\ApiKeyAuthenticator;
use App\Service\JWTTokenService;
use App\Service\ResponseService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class AuthenticationController extends AbstractController
{
    #[Route('/register', name: 'app_registration')]
    public function register(Request $request, UserRepository $userRepository, UserPasswordHasherInterface $userPasswordHasher): JsonResponse
    {

        $data = json_decode($request->getContent());
        $user = new User();

        if ($data->firstname != null) {
            $user->setFirstname($data->firstname);
        }
        if ($data->lastname != null) {
            $user->setLastname($data->lastname);
        }
        if ($data->email != null) {
            $user->setEmail($data->email);
        }
        if ($data->password != null) {
            $user->setPassword($userPasswordHasher->hashPassword($user, $data->password));
        }

        $userRepository->save($user, true);

        return $this->json([
            "OK user has been made"
        ]);

    }

    #[Route('/login', name: 'app_login')]
    public function login(Request $request, UserRepository $userRepository, UserPasswordHasherInterface $userPasswordHasher, JWTTokenService $JWTTokenService): JsonResponse
    {
        $data = json_decode($request->getContent());
        $user = $userRepository->findOneBy(["email" => $data->email]);

        if($user != null)
        {
             if($userPasswordHasher->isPasswordValid($user, $data->password))
             {
                 return $this->json([
                    $JWTTokenService->createToken($user)
                 ]);
             }

        }

        return $this->json([
            "User is not logged in"
        ]);
    }
}
