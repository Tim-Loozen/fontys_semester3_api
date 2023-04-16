<?php

namespace App\Controller;

use App\Repository\RouteRepository;
use App\Repository\UserRepository;
use App\Service\JWTTokenService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard')]
    public function index(Request $request, UserRepository $userRepository, RouteRepository $routeRepository,  JWTTokenService $JWTTokenService): JsonResponse
    {



         if($JWTTokenService->verifyUserToken() != null)
        {



            return $this->json([
            ] );
        }


        return $this->json([
        ], 400);
    }
}
