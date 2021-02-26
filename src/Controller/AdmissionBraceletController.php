<?php

namespace App\Controller;

use App\Entity\AdmissionBracelet;
use App\Services\JsonGroupSerializer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AdmissionBraceletController extends AbstractController
{

    /**
     * @Route("/bracelets", name="get_bracelets", methods={"GET"})
     */
    public function getBracelets(JsonGroupSerializer $serializer): Response
    {
        $bracelets = $this->getDoctrine()->getRepository(AdmissionBracelet::class)->findAll();
        return new Response($serializer->serialize(["bracelets" => $bracelets], "show_bracelet"));
    }

    /**
     * @Route("/bracelets/{id}", name="get_bracelet", methods={"GET"})
     */
    public function getBracelet(int $id, JsonGroupSerializer $serializer): Response
    {
        $bracelet = $this->getDoctrine()->getRepository(AdmissionBracelet::class)->find($id);

        if (!$bracelet) {
            return new Response("Bracelet with id " . $id . " not found.", 404);
        }
        return new Response($serializer->serialize(["bracelet" => $bracelet], "show_bracelet"));
    }

    /**
     * @Route("/bracelets", name="create_bracelet", methods={"POST"})
     */
    public function createBracelet(Request $request, JsonGroupSerializer $serializer, ValidatorInterface $validator): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $bracelet = new AdmissionBracelet();
        $errors = $validator->validate($bracelet);
        if (count($errors) > 0) {
            return new Response((string)$errors, 400);
        } else {
            $entityManager->persist($bracelet);
            $entityManager->flush();
            return new Response($serializer->serialize(["bracelet" => $bracelet], "show_bracelet"));
        }
    }
}
