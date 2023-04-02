<?php

namespace App\Service;

use App\Entity\User;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTTokenService
{
 public function createToken(User $user)
 {
     return JWT::encode($user->serialize(), $user->getApiToken(), 'HS256');

 }
 public function decodeToken(string $token, User $user)
 {
     return JWT::decode($token, New Key($user->getApiToken(), 'HS256' ));
 }
}
