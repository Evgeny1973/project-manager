<?php

namespace App\Controller;

use phpcent\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @return Response
     */
    public function index(Client $centrifugo): Response
    {
        $centrifugo->publish('alerts', ['message' => 'PHP!']);
        
        return $this->render('app/home.html.twig');
    }
}