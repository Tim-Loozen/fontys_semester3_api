<?php

namespace App\Controller;

use  App\Service\FaAuthService;
use App\Entity\User;
use App\Repository\PostOfficeUserRepository;
use App\Repository\UserRepository;
use App\Service\JWTTokenService;
use OTPHP\TOTP;
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
            $MFA_Enabled = "";

            if ($user != null) {
                if ($userPasswordHasher->isPasswordValid($user, $data->password) && $user->isIsAdmin()) {
                    if ($user->getMFAKey() != null) {
                        $MFA_Enabled = "MFA_enabled";
                    }
                    return $this->json([
                        $JWTTokenService->createToken($user),
                        $MFA_Enabled,
                        "Admin has logged in",]);
                }

                if ($userPasswordHasher->isPasswordValid($user, $data->password) && !$user->isIsAdmin() && $user->getPostOffice() === null) {
                    if ($user->getMFAKey() != null) {
                        $MFA_Enabled = "MFA_enabled";
                    }
                    return $this->json([
                        $JWTTokenService->createToken($user),
                        "User has logged in",
                        $MFA_Enabled,
                    ]);
                }

                if ($userPasswordHasher->isPasswordValid($user, $data->password) && $user->getPostOffice() != null) {
                    if ($user->getMFAKey() != null) {
                        $MFA_Enabled = "MFA_enabled";
                    }
                    return $this->json([
                        $JWTTokenService->createToken($user),
                        "Post user is logged in",
                        $MFA_Enabled,
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

    #[Route('/create-2fa', name: 'create_mfa')]
    public function MfaCreate(Request $request, JWTTokenService $JWTTokenService, UserRepository $userRepository): JsonResponse
    {
        $user = $JWTTokenService->verifyUserToken();

        if ($user == null) {
            return $this->json([
                'User is not verified'
            ], 400);
        }

        $otp = TOTP::create();
        $secret = $otp->getSecret();

        $otp->setLabel($_ENV['APP_NAME']);
        $grCodeUri = $otp->getQrCodeUri(
            'https://api.qrserver.com/v1/create-qr-code/?data=' . $secret . '&size=300x300&ecc=M',
            $secret
        );
        return $this->json([
            "MFa_enabled",
            $secret,
            $grCodeUri
        ]);

    }

    #[Route('/verify-2fa', name: 'verify_mfa')]
    public function MfaVerify(Request $request, JWTTokenService $JWTTokenService, UserRepository $userRepository): JsonResponse
    {
        $user = $JWTTokenService->verifyUserToken();
        $data = json_decode($request->getContent());
        $valid  = false;

        if ($user == null) {
            return $this->json([
                'User is not verified'
            ], 400);
        }

        if($user->getMFAKey() != null && $data->input != null)
        {
            $key =  $user->getMFAKey();
            $valid = true;

        } else if($data->key != null && $data->input != null) {
            $key =  $data->key;
            $valid = true;
        }

           if ($user != null && $valid) {

               $otp = TOTP::create($key);
               $result = $otp->verify($data->input);

               if ($result && $key != null) {
                   $user->setMFAKey($key);
                   $userRepository->save($user, true);

                   return $this->json([
                       $result,
                       "verify_ok"
                   ]);
               }
           }

        return $this->json([
            "no_data",
        ], 400);

    }


}
