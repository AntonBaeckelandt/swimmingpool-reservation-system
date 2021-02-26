<?php

namespace App\Controller;

use App\Entity\Employee;
use App\Services\JsonGroupSerializer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class EmployeeController extends AbstractController
{

    /**
     * @Route("/employees", name="create_employee", methods={"POST"})
     */
    public function createEmployee(Request $request, JsonGroupSerializer $serializer, ValidatorInterface $validator): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $employee = new Employee();
        $employee->setFirstName($request->get("firstName"));
        $employee->setLastName($request->get("lastName"));

        $errors = $validator->validate($employee);

        if (count($errors) > 0) {
            return new Response((string)$errors, 400);
        } else {
            $entityManager->persist($employee);
            $entityManager->flush();
            return new Response($serializer->serialize(["employee" => $employee], "show_employee"));
        }
    }
}
