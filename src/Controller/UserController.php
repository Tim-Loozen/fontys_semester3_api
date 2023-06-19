<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\JWTTokenService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/edit-users/{user}', name: 'app_edit_users')]
    public function editUser(User $user, JWTTokenService $JWTTokenService): JsonResponse
    {

        $user = $JWTTokenService->verifyUserToken();
        if ($user == null) {
            return $this->json([
                'User is not verified'
            ], 400);
        }

        $data = [
          "firstname" => $user->getFirstname(),
          "lastname" => $user->getLastname(),
          "email" => $user->getEmail(),
          "password" => $user->getPassword(),
          "cellphone" => $user->getPhoneNumber(),

        ];

        return $this->json([
            $data
        ]);

    }
    #[Route('/update-users', name: 'app_update_user')]
    public function updateUser(Request $request ,UserRepository $userRepository): JsonResponse
    {
        $data = json_decode($request->getContent());
        if($data != null) {
            $updatedUser = $userRepository->find($data->id);
            $updatedUser->setFirstname($data->firstname);
            $updatedUser->setLastname($data->lastname);
            $updatedUser->setEmail($data->email);
            $userRepository->save($updatedUser, true);
            return $this->json([
                'Userupdate_ok'
            ]);
        }

        return $this->json([

        ]);


    }


    #[Route('/remove-users/{id}', name: 'app_remove_users')]
    public function removeUser(UserRepository $userRepository): JsonResponse
    {

    }






}
