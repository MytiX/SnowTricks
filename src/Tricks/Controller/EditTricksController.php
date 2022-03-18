<?php

namespace App\Tricks\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EditTricksController extends AbstractController
{
    #[Route('/add/tricks', name: 'app_add_tricks')]
    #[Route('/edit/tricks/{id}', name: 'app_edit_tricks')]
    public function index(?int $id = null): Response
    {
        return $this->render('edit_tricks/index.html.twig');
    }
}
