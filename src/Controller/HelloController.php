<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class HelloController
{   
    #[Route('/', name: 'app_index')]
    public function index(): Response
    {
        return new Response("HI!");
    }
}