<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\PostOfficeUserRepository;
use App\Repository\UserRepository;
use App\Service\JWTTokenService;
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
        $valid = false;
        $errorMessage = "";

        if ($data != null) {
            if ($data->firstname === null) {
                $valid = false;
                $errorMessage = 'No firstname';
            }
            if ($data->lastname === null) {
                $valid = false;
                $errorMessage = 'No firstname';
            }
            if ($data->email === null) {
                $valid = false;
                $errorMessage = 'No firstname';
            }
            if ($data->password === null) {
                $valid = false;
                $errorMessage = 'No firstname';
            }

            if ($valid) {
                $user->setFirstname($data->firstname);
                $user->setLastname($data->lastname);
                $user->setEmail($data->email);
                $user->setPassword($userPasswordHasher->hashPassword($user, $data->password));
                $user->setIsAdmin(false);
                $userRepository->save($user, true);
                $errorMessage = "register_ok";
            }
        }

            return $this->json([
                $errorMessage
            ]);


    }

    #[Route('/login', name: 'app_login')]
    public function login(Request $request, UserRepository $userRepository, PostOfficeUserRepository $postOfficeUserRepository, UserPasswordHasherInterface $userPasswordHasher, JWTTokenService $JWTTokenService): JsonResponse
    {
        $data = json_decode($request->getContent());
        if ($data != null) {

            $user = $userRepository->findOneBy(["email" => $data->email]);

            if ($user != null) {
                if ($userPasswordHasher->isPasswordValid($user, $data->password) && $user->isIsAdmin()) {
                    return $this->json([
                        $JWTTokenService->createToken($user),
                        "Admin has logged in",]);
                }

                if ($userPasswordHasher->isPasswordValid($user, $data->password) && !$user->isIsAdmin()) {
                    return $this->json([
                        $JWTTokenService->createToken($user),
                        "User has logged in",
                    ]);
                }

                if ($userPasswordHasher->isPasswordValid($user, $data->password) && $user->getPostOffice() != null) {
                    return $this->json([
                        $JWTTokenService->createToken($user),
                        "Post user is logged in",
                    ]);

                }
            }
        }
        return $this->json([
        ], 400);
    }

    #[Route('/verifyToken', name: 'app_verifyToken')]
    public function verifyToken(Request $request, JWTTokenService $JWTTokenService, UserRepository $userRepository): JsonResponse
    {
        $user = $JWTTokenService->verifyUserToken();
        if ($user == null) {
            return $this->json([
                'User is not verified'
            ], 400);
        }
        return $this->json([
           $user->serialize()
        ]);
    }
}
