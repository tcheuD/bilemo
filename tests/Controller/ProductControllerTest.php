<?php

namespace App\Tests\Controller;

use Symfony\Component\HttpFoundation\Response;

class ProductControllerTest extends BaseController
{

    public function testIndex(): void
    {
        $client = $this->createAuthenticatedClient();
        $client->request('GET', '/api/product/');
        $this->assertSame(Response::HTTP_OK, $client->getResponse()->getStatusCode());
    }

    public function testShow(): void
    {
        $client = $this->createAuthenticatedClient();
        $client->request('GET', '/api/product/10');
        $this->assertSame(Response::HTTP_OK, $client->getResponse()->getStatusCode());
    }

}
