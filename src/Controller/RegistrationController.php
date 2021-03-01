<?php

namespace App\Controller;

use App\Entity\AdmissionBracelet;
use App\Entity\Employee;
use App\Entity\Registration;
use App\Entity\Subscription;
use App\Entity\Ticket;
use App\Repository\TicketRepository;
use App\Services\JsonGroupSerializer;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RegistrationController extends AbstractController
{

    /**
     * @Route("/registrations", name="get_registrations", methods={"GET"})
     */
    public function getRegistrations(JsonGroupSerializer $serializer): Response
    {
        $registrations = $this->getDoctrine()->getRepository(Registration::class)->findAll();
        return new Response($serializer->serialize(["registrations" => $registrations], "show_registration"));
    }

    /**
     * @Route("/registrations/{id}", name="get_registration", methods={"GET"})
     */
    public function getRegistration(int $id, JsonGroupSerializer $serializer): Response
    {
        $registration = $this->getDoctrine()->getRepository(Registration::class)->find($id);

        if (!$registration) {
            return new Response("Registration with id " . $id . " not found.", 404);
        }
        return new Response($serializer->serialize(["registration" => $registration], "show_registration"));
    }

    /**
     * @Route("/registrations", name="create_registration", methods={"POST"})
     */
    public function createRegistration(Request $request, JsonGroupSerializer $serializer, ValidatorInterface $validator): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $employeeId = $request->get("employeeId");
        $braceletId = $request->get("braceletId");
        $employee = $this->getDoctrine()->getRepository(Employee::class)->find($employeeId);
        $bracelet = $this->getDoctrine()->getRepository(AdmissionBracelet::class)->find($braceletId);

        $registration = new Registration();
        $registration->setRegisteredBy($employee);
        $registration->setBracelet($bracelet);
        $registration->setCheckInTimestamp(new DateTime("now"));
        $registration->setType($request->get("type"));

        $paymentMethod = $request->get("paymentMethod");
        if ($paymentMethod["type"] == "ticket") {
            $ticketId = $paymentMethod["ticketId"];
            $ticket = $this->getDoctrine()->getRepository(Ticket::class)->find($ticketId);
            if (!$ticket) {
                return new Response("Ticket not found", 404);
            }
            $registration->setTicket($ticket);
        } else if ($paymentMethod["type"] == "subscription") {
            $subscriptionId = $paymentMethod["subscriptionId"];
            $subscription = $this->getDoctrine()->getRepository(Subscription::class)->find($subscriptionId);
            if (!$subscriptionId) {
                return new Response("Subscription not found", 404);
            }
            $registration->setSubscription($subscription);
        }

        $errors = $validator->validate($registration);

        if (count($errors) > 0) {
            return new Response((string)$errors, 400);
        } else {
            $entityManager->persist($registration);
            $entityManager->flush();
            return new Response($serializer->serialize(["registration" => $registration], "show_registration"));
        }
    }

    /**
     * @Route("/registrations/{id}", name="update_registration", methods={"PATCH"})
     */
    public function updateCheckOut(Request $request, JsonGroupSerializer $serializer): Response
    {
        $id = $request->attributes->get('id');
        $entityManager = $this->getDoctrine()->getManager();
        $registration = $this->getDoctrine()->getRepository(Registration::class)->find($id);

        if (!$registration) {
            return $this->json("Registration with id " . $id . " not found.", 404);
        } else if ($registration->getCheckOutTimestamp() != null) {
            return $this->json("Registration with id " . $id . " has already been checked out.", 400);
        }

        $registration->setCheckOutTimestamp(new DateTime("now"));
        $entityManager->flush();
        return new Response($serializer->serialize(["registration" => $registration], "show_registration"));
    }

}
