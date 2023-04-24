<?php

namespace App\Controller;

use App\Entity\PostOffice;
use App\Entity\PostOfficeUser;
use App\Repository\PostOfficeRepository;
use App\Repository\PostOfficeUserRepository;
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

    #[Route('/post_office_account', name: 'post_office_account', methods: ['GET'])]
    public function indexAccount(PostOfficeUserRepository $postOfficeUserRepository): JsonResponse
    {
        $postOfficeUsers  = $postOfficeUserRepository->findAll();
        foreach ($postOfficeUsers as $postOffice) {
            $data[] = [
                'id' => $postOffice->getId(),
                'email' => $postOffice->getEmail(),
                'firstname' => $postOffice->getFirstname(),
                'lastname' => $postOffice->getLastname(),
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

        if ($data != null) {

            if ($data->postOfficeName === null) {
                $valid = false;
            }

            if ($data->postOfficeKVK === null) {
                $valid = false;
            }

            if ($valid) {

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

    #[Route('/create_post_office_account', name: 'post_office_account_create')]
    public function createPostOfficeAccount(Request $request, PostOfficeUserRepository $postOfficeUserRepository,  UserPasswordHasherInterface $userPasswordHasher ): JsonResponse
    {
        $data = json_decode($request->getContent());
        $postOfficeUser = new PostOfficeUser();
        $errorMessage = "";
        $valid = true;

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

            if ($valid) {

                $postOfficeUser->setFirstname($data->firstname);
                $postOfficeUser->setLastname($data->lastname);
                $postOfficeUser->setEmail($data->email);
                $postOfficeUser->setPassword($userPasswordHasher->hashPassword($postOfficeUser, $data->password));
                $postOfficeUser->setPhoneNumber($data->cellphone);
                $postOfficeUser->setPosition($data->position);
                $postOfficeUser->setRole("default");

                $postOfficeUserRepository->save($postOfficeUser, true);


                return $this->json([
                    "Account voor het postbedrijf is aangemaakt"
                ]);
            }
        }
        return $this->json([
        ]);
    }


}
