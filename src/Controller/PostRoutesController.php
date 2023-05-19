<?php

namespace App\Controller;

use App\Entity\PostRoute;
use App\Entity\RouteRequest;
use App\Repository\RouteRequestRepository;
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
    public function index(PostRouteRepository $routeRepository, JWTTokenService $JWTTokenService): JsonResponse
    {

        $user = $JWTTokenService->verifyUserToken();


        if ($user == null) {
            return $this->json([
                "No user"
            ], 403);
        }

        $routes = $routeRepository->getRoutesByUser($user);

        if ($user->getPostOffice() === null) {
            $routes = $routeRepository->findAll();
        }

        foreach ($routes as $route) {
            $data[] = [
                'id' => $route->getId(),
                'distance' => $route->getDistance(),
                'time' => $route->getTime(),
                'startpoint' => $route->getStartpoint(),
                'status' => $route->getStatus(),
                'endpoint' => $route->getEndpoint(),
                'earnings' => $route->getEarnings(),
                'postOffice' => $route->getPostOffice()->getName(),
            ];

        }

        return $this->json([
            $data
        ]);
    }


    #[Route('/route/{route}', name: 'app_post_route_view')]
    public function postRoute(PostRoute $route, JWTTokenService $JWTTokenService): JsonResponse
    {
        $user = $JWTTokenService->verifyUserToken();
        if ($user == null) {
            return $this->json([
                'User is not verified'
            ], 400);
        }

        $data = [
            "postOffice" => $route->getPostOffice()->getName(),
            "startPoint" => $route->getStartpoint(),
            "endPoint" => $route->getEndpoint(),
            "earnings" => $route->getEarnings(),
            "description" => $route->getDescription(),
            "distance" => $route->getDistance(),
            "time" => $route->getTime(),
        ];

        return $this->json([
            $data
        ]);

    }

    #[Route('/wanttheroute', name: 'app_post_route_want')]
    public function RouteRequest(Request $request, RouteRequestRepository $routeRequestRepository, PostRouteRepository $postRouteRepository, JWTTokenService $JWTTokenService): JsonResponse
    {
        $user = $JWTTokenService->verifyUserToken();
        if ($user == null) {
            return $this->json([
                'User is not verified'
            ], 400);
        }

        $data = json_decode($request->getContent());
        $routeRequest = new RouteRequest();
        $errormessage = "";
        $valid = true;

        if ($data->postRouteId === null) {
            $errormessage = "route is empty";
            $valid = false;
        }


        $postRoute = $postRouteRepository->find($data->postRouteId);
        $postOffice = $postRoute->getPostOffice();

        if ($valid) {
            $routeRequest->setPostRoute($postRoute);
            $routeRequest->setUser($user);
            $routeRequest->setDescription($data->description);
            $routeRequest->setPostOffice($postOffice);
            $routeRequestRepository->save($routeRequest, true);
            $errormessage = "request_ok";

        }
        return $this->json([
            $errormessage
        ]);


    }

    #[Route('/get-requests', name: 'get_post_route_requests')]
    public function getRouteRequests(Request $request, JWTTokenService $JWTTokenService, RouteRequestRepository $routeRequestRepository): JsonResponse
    {
        $user = $JWTTokenService->verifyUserToken();

        if ($user == null) {
            return $this->json([
                'User is not verified'
            ], 400);
        }

        if ($user->getPostOffice() != null) {
            $routeRequests = $routeRequestRepository->findBy(array("postOffice" => $user->getPostOffice()));
        }

        if ($user->getPostOffice() === null) {
            $routeRequests = $routeRequestRepository->findBy(array("user" => $user));
        }

        foreach ($routeRequests as $r) {
            $data[] = [
                "requestId" => $r->getId(),
                "username" => $r->getUser()->getFirstname(),
                "email" => $r->getUser()->getEmail(),
                "route" => $r->getPostRoute()->getId(),
                "RequestStatus" => $r->getStatus() ?? "",
                "description" => $r->getDescription()
            ];
        }


        return $this->json([
            $data
        ]);
    }


    #[Route('/create-route', name: 'create_post_routes')]
    public function Create(Request $request, JWTTokenService $JWTTokenService, PostRouteRepository $routeRepository, UserRepository $userRepository): JsonResponse
    {
        $user = $JWTTokenService->verifyUserToken();
        if ($user == null) {
            return $this->json([
                'User is not verified'
            ], 400);
        }

        $data = json_decode($request->getContent());
        $postRoute = new PostRoute();
        $valid = true;

        $errormessage = "";

        if ($data->distance === null) {
            $valid = false;
            $errormessage = "Afstand is niet ingevuld";
        }
        if ($data->time === null) {
            $valid = false;
            $errormessage = "Tijd is niet ingevuld";
        }
        if ($data->startpoint === null) {
            $valid = false;
            $errormessage = "Startpunt is niet ingevuld";

        }
        if ($data->endpoint === null) {
            $valid = false;
            $errormessage = "Eindpunt is niet ingevuld";

        }
        if ($data->earnings === null) {
            $valid = false;
            $errormessage = "Opbrengste  zijn niet ingevuld";
        }
        if ($user->getPostOffice() === null) {
            $valid = false;
            $errormessage = "Geen post bedrijf ";
        }

        if ($valid) {
            $postRoute->setDistance($data->distance);
            $postRoute->setTime($data->time);
            $postRoute->setEarnings($data->earnings);
            $postRoute->setStartpoint($data->startpoint);
            $postRoute->setEndpoint($data->endpoint);
            $postRoute->setDescription($data->description);
            $postRoute->setPostOffice($user->getPostOffice());
            $routeRepository->save($postRoute, true);
            $errormessage = "route_ok";
        }
        return $this->json([
            $errormessage
        ]);

    }

    #[Route('/route-status', name: 'change_route_status')]
    public function changeRouteStatus(Request $request, JWTTokenService $JWTTokenService, RouteRequestRepository $routeRequestRepository, PostRouteRepository $postRouteRepository): JsonResponse
    {
        $user = $JWTTokenService->verifyUserToken();
        if ($user == null) {
            return $this->json([
                'User is not verified'
            ], 400);
        }

        $data = json_decode($request->getContent());

        foreach ($data as $value) {

            $routeRequest = $routeRequestRepository->findOneBy(array("id" => $value->requestId));
            $routeRequest->setStatus($value->RequestStatus);
            $routeRequestRepository->save($routeRequest, true);

            $errorMessage = "statusChange_ok";


            if ($routeRequest->getStatus() != "Niet toegekend") {
                $route = $routeRequest->getPostRoute()->setStatus($routeRequest->getStatus());
                $postRouteRepository->save($route, true);
            }


        }

        return $this->json([
            $errorMessage
        ]);

    }
}
