<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ErrorController extends AbstractController
{
    #[Route('/error/notfound', name: 'app_not_found', methods: ['GET'])]
    public function notfound(): Response
    {
        return $this->render('errors/notfound.html.twig');
    }

    #[Route('/error/forbidden', name: 'app_forbidden', methods: ['GET'])]
    public function forbidden(): Response
    {
        return $this->render('errors/forbidden.html.twig');
    }
}