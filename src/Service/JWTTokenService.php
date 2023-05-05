<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use mysql_xdevapi\Exception;

class JWTTokenService
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function createApiToken(User $user)
    {

        $length = 55;
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $apiToken = '';
        for ($i = 0; $i < $length; $i++) {
            $apiToken .= $characters[random_int(0, $charactersLength - 1)];
        }
        $user->setApiToken($apiToken);
        $this->userRepository->save($user, true);

    }

    public function createToken(User $user)
    {
        if ($user->getApiToken() != null) {
            return JWT::encode($user->serialize(), $user->getApiToken(), 'HS256');
        } else {
           $this->createApiToken($user);
           return JWT::encode($user->serialize(), $user->getApiToken(), 'HS256');
        }
    }

    public function decodeToken(string $token, User $user)
    {
        try {
           return JWT::decode($token, new Key($user->getApiToken(), 'HS256'));
        } catch (\Exception $e) {
            return null;
        }
    }

    public function decodePublic(string $token)
    {
        return json_decode(base64_decode(str_replace('', '/', str_replace('-', '+', explode('.', $token)[1]))));
    }

    public function verifyUserToken()
    {
        $header = $this->decodePublic(getallheaders()["X-API-TOKEN"]);
        $apiTokenUser = $this->userRepository->findOneBy(["email" => $header[0]->email]);
        $verifiedUser = $this->decodeToken(getallheaders()["X-API-TOKEN"], $apiTokenUser);
        if($verifiedUser != null)
        {
            return $apiTokenUser;
        }

        return null;

    }

}
