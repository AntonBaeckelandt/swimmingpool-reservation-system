<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Entity\Subscription;
use App\Services\JsonGroupSerializer;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class SubscriptionController extends AbstractController
{

    /**
     * @Route("/subscriptions", name="get_subscriptions", methods={"GET"})
     */
    public function getSubscriptions(JsonGroupSerializer $serializer): Response
    {
        $subscriptions = $this->getDoctrine()->getRepository(Subscription::class)->findAll();
        return new Response($serializer->serialize(["subscriptions" => $subscriptions], "show_subscription"));
    }

    /**
     * @Route("/subscriptions/{id}", name="get_subscription", methods={"GET"})
     */
    public function getSubscription(int $id, JsonGroupSerializer $serializer): Response
    {
        $subscription = $this->getDoctrine()->getRepository(Subscription::class)->find($id);

        if (!$subscription) {
            return new Response("Subscription with id " . $id . " not found.", 404);
        }
        return new Response($serializer->serialize(["subscription" => $subscription], "show_subscription"));
    }

    /**
     * @Route("/subscriptions", name="create_subscription", methods={"POST"})
     */
    public function createSubscriptions(Request $request, JsonGroupSerializer $serializer, ValidatorInterface $validator): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $customer = $this->getDoctrine()->getRepository(Customer::class)->find($request->get("customerId"));

        $subscription = new Subscription();
        $subscription->setBoughtOn(new DateTime("now"));
        $subscription->setCustomer($customer);
        $subscription->setExpirationDate(\DateTime::createFromFormat('Y-m-d', $request->get("expirationDate")));

        $errors = $validator->validate($subscription);
        if (count($errors) > 0) {
            return new Response((string)$errors, 400);
        } else {
            $entityManager->persist($subscription);
            $entityManager->flush();
            return new Response($serializer->serialize(["subscription" => $subscription], "show_subscription"));
        }
    }

}
