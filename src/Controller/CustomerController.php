<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Repository\CustomerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/customer")
 */
class CustomerController extends BaseController
{

    /**
     * @Route("/", name="list_customers")
     * @param CustomerRepository $customerRepository
     * @param SerializerInterface $serializer
     * @return Response
     */
    public function index(CustomerRepository $customerRepository, SerializerInterface $serializer): Response
    {
        $customers = $customerRepository->findByClient($this->getUser());
        $data = $serializer->serialize($customers, 'json', [
            'groups' => ['list']
        ]);

        return new Response($data, 200, [
            'Content-Type' => 'application/json'
        ]);
    }

    /**
     * @Route("/{id}", name="show_customer", methods={"GET"})
     * @param Customer $customer
     * @param CustomerRepository $customerRepository
     * @param SerializerInterface $serializer
     * @return Response
     */
    public function show(Customer $customer, CustomerRepository $customerRepository, SerializerInterface $serializer): Response
    {
        $customer = $customerRepository->find($customer->getId());
        if ($customer->getClient() === $this->getUser()) {
            $data = $serializer->serialize($customer, 'json', [
                'groups' => ['show']
            ]);

            return new Response($data, 200, [
                'Content-Type' => 'application/json'
            ]);
        }

        $data = [
            'status' => 403,
            'message' => 'Acces interdit'
        ];
        return new JsonResponse($data, 403);
    }

    /**
     * @Route("/new", name="new_customer", methods={"POST"})
     * @param Request $request
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $entityManager
     * @return JsonResponse
     */
    public function new(Request $request, SerializerInterface $serializer, EntityManagerInterface $entityManager): JsonResponse
    {
        /** @var  $customer  Customer*/
        $customer = $serializer->deserialize($request->getContent(), Customer::class, 'json');
        $customer->setClient($this->getUser());

        $entityManager->persist($customer);
        $entityManager->flush();
        $data = [
            'status' => 201,
            'message' => 'Le téléphone a bien été ajouté'
        ];

        return new JsonResponse($data, 201);
    }
}
