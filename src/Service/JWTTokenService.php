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

    public function createToken(User $user)
    {
        return JWT::encode($user->serialize(), $user->getApiToken(), 'HS256');

    }

    public function decodeToken(string $token, User $user)
    {
        try {
            $decodedToken = JWT::decode($token, new Key($user->getApiToken(), 'HS256'));
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
        return $verifiedUser;
    }

}
