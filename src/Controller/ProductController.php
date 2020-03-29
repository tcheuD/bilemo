<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class ProductController extends AbstractController
{
    /**
     * @Route("/product", name="product")
     * @param ProductRepository $productRepository
     * @param SerializerInterface $serializer
     * @return Response
     */
    public function index(ProductRepository $productRepository, SerializerInterface $serializer)
    {
        $products = $productRepository->findAll();
        $data = $serializer->serialize($products, 'json');

        return new Response($data, 200, [
            'Content-Type' => 'application/json'
        ]);
    }
}
