<?php

declare(strict_types=1);

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

final class HomeController extends AbstractController
{
    /**
     * @Route("", name="home", methods={"GET"})
     *
     * @return JsonResponse
     */
    public function home(): JsonResponse
    {
        return $this->json([
            'name' => 'JSON API',
        ]);
    }
}
