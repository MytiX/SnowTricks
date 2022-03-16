<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EditTricksController extends AbstractController
{
    #[Route('/edit/tricks/{slug}', name: 'app_edit_tricks')]
    public function index(string $slug): Response
    {
        return $this->render('edit_tricks/index.html.twig');
    }
}
