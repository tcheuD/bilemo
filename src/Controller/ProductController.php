<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/product")
 */
class ProductController extends BaseController
{
    /**
     * @Route("/", name="list_products")
     * @param Request $request
     * @param ProductRepository $productRepository
     * @param SerializerInterface $serializer
     * @return Response
     */
    public function index(Request $request, ProductRepository $productRepository, SerializerInterface $serializer): Response
    {

        $page = $request->query->get('page');

        if($page === null || $page < 1) {
            $page = 1;
        }

        $products = $productRepository->findAllPaginate($page, 5);
        $data = $serializer->serialize($products, 'json', [
            'groups' => ['list']
        ]);

        return new Response($data, 200, [
            'Content-Type' => 'application/json'
        ]);
    }

    /**
     * @Route("/{id}", name="show_phone", methods={"GET"})
     * @param Product $product
     * @param ProductRepository $productRepository
     * @param SerializerInterface $serializer
     * @return Response
     */
    public function show(Product $product, ProductRepository $productRepository, SerializerInterface $serializer): Response
    {
        $product = $productRepository->find($product->getId());
        $data = $serializer->serialize($product, 'json', [
            'groups' => ['show']
        ]);

        return new Response($data, 200, [
            'Content-Type' => 'application/json'
        ]);
    }
}

