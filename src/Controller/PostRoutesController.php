<?php

namespace App\Controller;

use App\Entity\PostRoute;
use App\Service\JWTTokenService;
use App\Repository\PostRouteRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\RouteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class PostRoutesController extends AbstractController
{
    #[Route('/routes', name: 'app_post_routes')]
    public function index(PostRouteRepository $routeRepository): JsonResponse
    {
        $routes = $routeRepository->findAll();

        foreach ($routes as $route)
        {
            $data[] = [
                'id' => $route->getId(),
                'distance' => $route->getDistance(),
                'time' => $route->getTime(),
                'startpoint' => $route->getStartpoint(),
                'endpoint' => $route->getEndpoint(),
                'earnings' => $route->getEarnings()
            ];

        }

        return $this->json([
            $data
        ]);
    }

    #[Route('/create-route', name: 'create_post_routes')]
    public function Create(Request $request, JWTTokenService $JWTTokenService ,PostRouteRepository $routeRepository, UserRepository $userRepository): JsonResponse
    {

        $user = $JWTTokenService->verifyUserToken();
        $postOffice = $user->getPostOffice();

        if($user == null)
        {
            return $this->json([
                'User is not verified'
            ], 400);
        }

        $data = json_decode($request->getContent());
        $postRoute = new PostRoute();
        $valid = true;

        $errormessage = "";

        if($data->distance === null)
        {
            $valid = false;
            $errormessage = "Afstand is niet ingevuld";
        }
        if($data->time === null)
        {
            $valid = false;
            $errormessage = "Tijd is niet ingevuld";
        }
        if($data->startpoint === null)
        {
            $valid = false;
            $errormessage = "Startpunt is niet ingevuld";

        }
        if($data->endpoint === null)
        {
            $valid = false;
            $errormessage = "Eindpunt is niet ingevuld";

        }
        if($data->earnings === null)
        {
            $valid = false;
            $errormessage = "Opbrengste  zijn niet ingevuld";
        }
        if($postOffice === null)
        {
            $valid = false;
            $errormessage = "Geen post bedrijf ";

        }

        if($valid)
        {
            $postRoute->setDistance($data->distance);
            $postRoute->setTime($data->time);
            $postRoute->setEarnings($data->earnings);
            $postRoute->setStartpoint($data->startpoint);
            $postRoute->setEndpoint($data->endpoint);

            $routeRepository->save($postRoute, true);

            return $this->json([
                'route is aangemaakt'
            ]);
        }
        else{
            return $this->json([
                $errormessage
            ], 400);
        }


    }
}
