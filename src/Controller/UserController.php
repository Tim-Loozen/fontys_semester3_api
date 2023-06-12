<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(): JsonResponse
    {

        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/UserController.php',
        ]);
    }

    #[Route('/get-users', name: 'app_users')]
    public function getAllUsers(UserRepository $userRepository): JsonResponse
    {
        $users = $userRepository->findAll();

        foreach ($users as $user) {
            $data[] = [

                'id' => $user->getId(),
                'Firstname'=> $user->getFirstname(),
                'Lastname' =>$user->getLastname(),
                'email' => $user->getEmail(),

            ];
        }
        return $this->json([
            $data
        ]);
    }

    #[Route('/edit-users/{id}', name: 'app_edit_users')]
    public function editUser(UserRepository $userRepository): JsonResponse
    {
        //todo create function to edit users

    }
    #[Route('/remove-users/{id}', name: 'app_remove_users')]
    public function removeUser(UserRepository $userRepository): JsonResponse
    {

    }






}
