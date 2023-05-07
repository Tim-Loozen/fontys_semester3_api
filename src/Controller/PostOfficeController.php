<?php

namespace App\Controller;

use App\Entity\PostOffice;
use App\Entity\User;
use App\Repository\PostOfficeRepository;
use App\Repository\PostOfficeUserRepository;
use App\Repository\UserRepository;
use App\Service\ResponseService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class PostOfficeController extends AbstractController
{
    #[Route('/post_office', name: 'app_post_office', methods: ['GET'])]
    public function index(PostOfficeRepository $postOfficeRepository): JsonResponse
    {

        $postoffices = $postOfficeRepository->findAll();

        foreach ($postoffices as $postOffice) {
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
        $errorMessage = "";

        if ($data != null) {

            if ($data->postOfficeName === null) {
                $valid = false;
                $errorMessage = "";
            }

            if ($data->postOfficeKVK === null) {
                $valid = false;
                $errorMessage = "";
            }

            if ($valid) {
                $postOffice->setName($data->postOfficeName);
                $postOffice->setKvk(intval($data->postOfficeKVK));
                $postOfficeRepository->save($postOffice, true);
                $errorMessage = "postOffice_ok";

            }
        }

        return $this->json([
            $errorMessage
        ]);
    }

    #[Route('/create_post_office_account', name: 'post_office_account_create')]
    public function createPostOfficeAccount(Request $request, UserRepository $userRepository, PostOfficeRepository $postOfficeRepository ,UserPasswordHasherInterface $userPasswordHasher ): JsonResponse
    {
        $data = json_decode($request->getContent());
        $user = new User();
        $errorMessage = "";
        $valid = true;


        //todo add check if person has valid postcompany

        if ($data != null) {

            if ($data->firstname === null) {
                $valid = false;
                $errorMessage = "Vul een voornaam in";
            }
            if ($data->lastname === null) {
                $valid = false;
                $errorMessage = "Vul een achternaam in";
            }
            if ($data->email === null) {
                $valid = false;
                $errorMessage = "Vul een email in";
            }
            if ($data->position == null) {
                $valid = false;
                $errorMessage = "Vul een positie in";
            }
            if ($data->cellphone == null) {
                $valid = false;
                $errorMessage = "Vul een telefoonummer in";
            }
            if($data->postCompany != null)
            {
                $postOffice = $postOfficeRepository->find($data->postCompany);
            }else{
                $valid = false;
                $errorMessage = "Geen postbedrijf gevonden";
            }

            if ($valid) {
                $user->setFirstname($data->firstname);
                $user->setLastname($data->lastname);
                $user->setEmail($data->email);
                $user->setPassword($userPasswordHasher->hashPassword($user, $data->password));
                $user->setPhoneNumber($data->cellphone);
                $user->setPosition($data->position);
                $user->setIsAdmin(false);
                $user->setPostOffice($postOffice);
                $userRepository->save($user, true);
                $errorMessage = "postCompanyAccount_ok";
            }
        }
        return $this->json([
            $errorMessage
        ]);
    }


}
