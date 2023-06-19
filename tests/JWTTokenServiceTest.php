<?php

namespace App\Tests;

use App\Entity\User;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class JWTTokenServiceTest extends KernelTestCase
{
    public function testCanBeCreatedByValidUser(): void
    {
        $user = new User();
        $user->setEmail("ewoehler1s@theglobeandmail.com");
        $user->setFirstname('Kenon');
        $user->setLastname('Godin');
        $user->setApiToken('BKskKL5ky8xflMnQ9rd2');

        $result = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJmaXJzdG5hbWUiOiJLZW5vbiIsImxhc3RuYW1lIjoiR29kaW4iLCJlbWFpbCI6ImV3b2VobGVyMXNAdGhlZ2xvYmVhbmRtYWlsLmNvbSIsInBvc3RDb21wYW55IjpudWxsLCJpc19hZG1pbiI6bnVsbH0.RGmdWgme1Wr7oXUstXXhoXUnWwb6fTtWF66mAPot_z4";

        if ($user->getApiToken() != null) {
            JWT::encode($user->serialize(), $user->getApiToken(), 'HS256');
        } else {
            $this->createApiToken($user);
            JWT::encode($user->serialize(), $user->getApiToken(), 'HS256');
        }

        $this->assertSame($result, JWT::encode($user->serialize(), $user->getApiToken(), 'HS256'));


    }

    public function testCanBeCreatedByValidTokenAndUser(): void
    {
        $user = new User();
        $user->setEmail("ewoehler1s@theglobeandmail.com");
        $user->setFirstname('Kenon');
        $user->setLastname('Godin');
        $user->setApiToken('BKskKL5ky8xflMnQ9rd2');

        $token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJmaXJzdG5hbWUiOiJLZW5vbiIsImxhc3RuYW1lIjoiR29kaW4iLCJlbWFpbCI6ImV3b2VobGVyMXNAdGhlZ2xvYmVhbmRtYWlsLmNvbSIsInBvc3RDb21wYW55IjpudWxsLCJpc19hZG1pbiI6bnVsbH0.RGmdWgme1Wr7oXUstXXhoXUnWwb6fTtWF66mAPot_z4";

        $result = (object)array(
            "firstname" => "Kenon",
            "lastname" => "Godin",
            "email" => "ewoehler1s@theglobeandmail.com",
            "postCompany" => null,
            "is_admin" => null,
        );
        try {
            JWT::decode($token, new Key($user->getApiToken(), 'HS256'));
        } catch (\Exception $e) {
            null;
        }

        $this->assertEquals($result, JWT::decode($token, new Key($user->getApiToken(), 'HS256')));

    }


}
