<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Repository\CustomerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/customer")
 * @SWG\Tag(name="Customer")
 */
class CustomerController extends BaseController
{

    /**
     * Return a list of customer belonging to a client
     *
     * @Route("/", name="list_customers", methods={"GET"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Return a list of customers belonging to a client"
     * )
     * @SWG\Parameter(
     *     name="page",
     *     in="query",
     *     type="integer",
     *     description="Page number"
     * )
     *
     * @Security(name="Bearer")
     *
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
     * Display details about a specific customer belonging to the current client
     *
     * @Route("/{id}", name="show_customer", methods={"GET"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Return details about a client"
     * )
     *
     * @SWG\Response(
     *     response=403,
     *     description="Unauthorized access"
     * )
     *
     * @Security(name="Bearer")
     *
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
     * Add a new customer
     *
     * @Route("/new", name="new_customer", methods={"POST"})
     *
     * @SWG\Response(
     *     response=201,
     *     description="The customer has been created",
     *     @SWG\Schema(
     *       example={
     *         "firstname": "first name",
     *         "name": "name",
     *         "email": "example@bilemo.fr",
     *         "adress": "5 exampleStreet",
     *         "city:": "city",
     *         "postalCode": "1234"
     *      })
     * )
     *
     * @Security(name="Bearer")
     *
     * @param Request $request
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $entityManager
     * @param ValidatorInterface $validator
     */
    public function new(Request $request, SerializerInterface $serializer, EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        $customer = $serializer->deserialize($request->getContent(), Customer::class, 'json');
        $customer->setClient($this->getUser());

        $violations = $validator->validate($customer);

        if (count($violations) > 0) {
            $violationMessages = [];

            /** @var ConstraintViolation $violation */
            foreach ($violations as $violation) {
                $violationMessages[] = $violation->getMessage();
            }
            $errors = $serializer->serialize($violationMessages, 'json');

            return JsonResponse::fromJsonString($errors, 400);
        }

        $entityManager->persist($customer);
        $entityManager->flush();

        $data = [
            'status' => 201,
            'message' => 'L\'utilisateur a bien été ajouté'
        ];

        return new JsonResponse($data, 201);
    }

    /**
     * Delete a customer
     *
     * @Route("/{id}", name="delete_customer", methods={"DELETE"})
     *
     *  @SWG\Response(
     *     response=204,
     *     description="The customer has been deleted"
     * )
     *
     *  @SWG\Response(
     *     response=403,
     *     description="Unauthorized access"
     * )
     *
     * @SWG\Parameter(
     *     name="page",
     *     in="query",
     *     type="integer",
     *     description="Page number"
     * )
     *
     * @Security(name="Bearer")
     *
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
