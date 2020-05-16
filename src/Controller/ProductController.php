<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Nelmio\ApiDocBundle\Annotation\Security;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/product")
 *
 * @SWG\Tag(name="Product")
 */
class ProductController extends BaseController
{
    /**
     * Show products list
     *
     * @Route("/", name="list_products", methods={"GET"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Return list of products"
     * )
     *
     * @Security(name="Bearer")
     *
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
     * Show product's details
     *
     * @Route("/{id}", name="show_phone", methods={"GET"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Return details about a product"
     * )
     *
     * @Security(name="Bearer")
     *
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

