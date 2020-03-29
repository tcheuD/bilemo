<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api")
 */
class SecurityController extends AbstractController
{
    /**
     * @Route("/security", name="security")
     */
    public function index()
    {
        return $this->render('security/index.html.twig', [
            'controller_name' => 'SecurityController',
        ]);
    }

    /**
     * @Route("/login_check", name="login", methods={"POST"})
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        $user = $this->getUser();
        dump($user);
        die();
        return $this->json([
            'email' => $user->getEmail(),
            'roles'    => $user->getRoles()
        ]);
    }
}
