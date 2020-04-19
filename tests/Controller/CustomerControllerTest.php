<?php

namespace App\Tests\Controller;

use Symfony\Component\HttpFoundation\Response;

class CustomerControllerTest extends BaseController
{

    public function testIndex(): void
    {
        $client = $this->createAuthenticatedClient();
        $client->request('GET', '/api/customer/');
        $this->assertSame(Response::HTTP_OK, $client->getResponse()->getStatusCode());
    }

    public function testShow(): void
    {
        $client = $this->createAuthenticatedClient();
        $client->request('GET', '/api/customer/10');
        $this->assertSame(Response::HTTP_OK, $client->getResponse()->getStatusCode());
    }
    public function testShowReturn403ForUnauthorizedAccess(): void
    {
        $client = $this->createAuthenticatedClient('dupont2@dupont.fr');
        $client->request('GET', '/api/customer/10');
        $this->assertSame(Response::HTTP_FORBIDDEN, $client->getResponse()->getStatusCode());
    }

    public function testNew(): void
    {
        $client = $this->createAuthenticatedClient();
        $client->request(
            'POST',
            '/api/customer/new',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'firstname'  => 'testPost',
                'name'       => 'testPost',
                'email'      => 'selmera94@example.com',
                'adress'     => '72612 Von Point Apt. 569',
                'city'       => 'Kuhntown',
                'postalCode' => 23186
            ], JSON_THROW_ON_ERROR, 512)
        );
        $this->assertSame(Response::HTTP_CREATED, $client->getResponse()->getStatusCode());

    }

    public function testDelete(): void
    {
        $client = $this->createAuthenticatedClient();
        $client->request('DELETE', '/api/customer/10');
        $this->assertSame(Response::HTTP_NO_CONTENT, $client->getResponse()->getStatusCode());
    }

    public function testDeleteReturn403ForUnauthorizedAccess(): void
    {
        $client = $this->createAuthenticatedClient('dupont2@dupont.fr');
        $client->request('DELETE', '/api/customer/10');
        $this->assertSame(Response::HTTP_FORBIDDEN, $client->getResponse()->getStatusCode());
    }
}
