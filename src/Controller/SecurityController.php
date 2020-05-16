<?php

namespace App\Controller;

use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends BaseController
{
    /**
     * Get JWT
     *
     * @Route("/login_check", name="login", methods={"POST"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Return a json web token"
     * )
     * @SWG\Tag(name="Security")
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        $user = $this->getUser();

        return $this->json([
            'email' => $user->getEmail(),
            'roles' => $user->getRoles()
        ]);
    }
}
