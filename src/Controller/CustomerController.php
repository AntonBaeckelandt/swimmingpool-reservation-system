<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Entity\Employee;
use App\Services\JsonGroupSerializer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CustomerController extends AbstractController
{

    /**
     * @Route("/customers", name="create_customer", methods={"POST"})
     */
    public function createCustomer(Request $request, JsonGroupSerializer $serializer, ValidatorInterface $validator): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $customer = new Customer();

        $customer->setFirstName($request->get("firstName"));
        $customer->setLastName($request->get("lastName"));
        $customer->setDateOfBirth(\DateTime::createFromFormat('Y-m-d', $request->get("dateOfBirth")));
        $customer->setGender($request->get("gender"));

        $errors = $validator->validate($customer);

        if (count($errors) > 0) {
            return new Response((string)$errors, 400);
        } else {
            $entityManager->persist($customer);
            $entityManager->flush();
            return new Response($serializer->serialize(["customer" => $customer], "show_customer"));
        }
    }

}
