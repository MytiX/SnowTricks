<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TricksDetailController extends AbstractController
{
    #[Route('/tricks/detail/{slug}', name: 'app_tricks_detail')]
    public function index(string $slug): Response
    {
        return $this->render('tricks_detail/index.html.twig');
    }
}
