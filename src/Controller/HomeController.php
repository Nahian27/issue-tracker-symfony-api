<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[route(path: '/', name: 'app-home', methods: ['Get'])]
    public final function Home(): JsonResponse
    {
        return new JsonResponse([
            'status' => 'success',
            'message' => 'Welcome to my issue tracker api',
        ]);
    }
}