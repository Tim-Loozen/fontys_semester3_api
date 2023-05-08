<?php

namespace App\Controller;

use App\Repository\PostRouteRepository;
use App\Repository\RouteRepository;
use App\Repository\UserRepository;
use App\Service\JWTTokenService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    #[Route('/statistics', name: 'app_dashboard')]
    public function index(Request $request, UserRepository $userRepository, PostRouteRepository $postRouteRepository, JWTTokenService $JWTTokenService): JsonResponse
    {
        $user = $JWTTokenService->verifyUserToken();

        if ($user == null) {
            return $this->json([
                'User is not verified'
            ], 400);
        }

        $Postroutes = $postRouteRepository->findBy((array("user" => $user)));

        foreach ($Postroutes as $route) {
            $data[] = [
                "route" => $route->getId(),
                "earnings" => $route->getEarnings(),
                "hourly_rate" => $route->getHourlyRate(),
                "Minutes" => $route->getTime(),
                "Date" =>$route->getDate(),
            ];
        }

        return $this->json([
            $data
        ]);


    }
}
