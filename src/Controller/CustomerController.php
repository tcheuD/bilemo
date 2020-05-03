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
     * @param Request $request
     * @param CustomerRepository $customerRepository
     * @param SerializerInterface $serializer
     * @return Response
     */
    public function index(Request $request, CustomerRepository $customerRepository, SerializerInterface $serializer): Response
    {

        $page = $request->query->get('page');

        if($page === null || $page < 1) {
            $page = 1;
        }

        $customers = $customerRepository->findByClient($this->getUser(), $page, 5);

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

    /**
     * @Route("/{id}", name="delete_customer", methods={"DELETE"})
     * @param Customer $customer
     * @param EntityManagerInterface $entityManager
     * @param CustomerRepository $customerRepository
     * @return JsonResponse
     */
    public function delete(Customer $customer, EntityManagerInterface $entityManager, CustomerRepository $customerRepository): JsonResponse
    {
        $customer = $customerRepository->find($customer->getId());

        if ($customer->getClient() === $this->getUser()) {
            $entityManager->remove($customer);
            $entityManager->flush();

            return new JsonResponse(null, 204);
        }

        $data = [
            'status' => 403,
            'message' => 'Acces interdit'
        ];

        return new JsonResponse($data, 403);
    }
}
