<?php

namespace App\Controller;

use App\Entity\Ticket;
use App\Services\JsonGroupSerializer;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class TicketController extends AbstractController
{

    /**
     * @Route("/tickets", name="get_tickets", methods={"GET"})
     */
    public function getTickets(JsonGroupSerializer $serializer): Response
    {
        $tickets = $this->getDoctrine()->getRepository(Ticket::class)->findAll();
        return new Response($serializer->serialize(["tickets" => $tickets], "show_ticket"));
    }

    /**
     * @Route("/tickets/{id}", name="get_ticket", methods={"GET"})
     */
    public function getTicket(int $id, JsonGroupSerializer $serializer): Response
    {
        $ticket = $this->getDoctrine()->getRepository(Ticket::class)->find($id);

        if (!$ticket) {
            return new Response("Ticket with id " . $id . " not found.", 404);
        }
        return new Response($serializer->serialize(["ticket" => $ticket], "show_ticket"));
    }

    /**
     * @Route("/tickets", name="create_ticket", methods={"POST"})
     */
    public function createTicket(Request $request, JsonGroupSerializer $serializer, ValidatorInterface $validator): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $ticket = new Ticket();
        $ticket->setBoughtOn(new DateTime("now"));
        $ticket->setPrice($request->get("price"));
        $ticket->setValidOn(\DateTime::createFromFormat('Y-m-d', $request->get("validDate")));

        $errors = $validator->validate($ticket);
        if (count($errors) > 0) {
            return new Response((string)$errors, 400);
        } else {
            $entityManager->persist($ticket);
            $entityManager->flush();
            return new Response($serializer->serialize(["ticket" => $ticket], "show_ticket"));
        }
    }

}
