<?php

namespace App\Controller;

use App\Entity\PostOffice;
use App\Repository\PostOfficeRepository;
use App\Service\ResponseService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PostOfficeController extends AbstractController
{
    #[Route('/post_office', name: 'app_post_office',methods: ['GET'] )]
    public function index(PostOfficeRepository $postOfficeRepository): JsonResponse
    {

        $postoffices = $postOfficeRepository->findAll();

        foreach($postoffices as  $postOffice)
        {
            $data[] = [
                'id' => $postOffice->getId(),
                'name' => $postOffice->getName(),
                'kvk' => $postOffice->getKvk(),
            ];

        }

        return $this->json([
            $data
        ]);

    }
    #[Route('/create_post_office', name: 'post_office')]
    public function createPostOffice(Request $request, PostOfficeRepository $postOfficeRepository): JsonResponse
    {
        $data = json_decode($request->getContent());
        $postOffice = new PostOffice();
        $valid = true;

        if($data != null) {

            if ($data->postOfficeName === null) {
                $valid = false;
            }

            if ($data->postOfficeKVK === null) {
                $valid = false;
            }

            if($valid) {

                $postOffice->setName($data->postOfficeName);
                $postOffice->setKvk(intval($data->postOfficeKVK));

                $postOfficeRepository->save($postOffice, true);

                return $this->json([
                    "Postoffice has been made"
                ]);
            }
        }
        return $this->json([
        ]);
    }


}
