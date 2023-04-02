<?php

namespace App\Controller;

use App\Entity\PostOffice;
use App\Service\ResponseService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PostOfficeController extends AbstractController
{
    #[Route('/post_office', name: 'app_post_office')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/PostOfficeController.php',
        ]);
    }
    #[Route('/create_post_office', name: 'post_office')]
    public function post(Request $request): JsonResponse
    {

        $data = json_decode($request->getContent(), true, 512);

        if (empty($data)) {
            return ResponseService::build(null, 400, 'No data provided', 'no_data_provided');
        }


        $user = new User();
        $user->getRoute($route);





        return ResponseService::build($data, 200, '', '');

    }


}
