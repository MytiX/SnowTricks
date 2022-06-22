<?php

namespace App\CGU\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CGUDetailController extends AbstractController
{
    #[Route('/cgu', name: 'app_cgu')]
    public function __invoke()
    {
        return $this->render('cgu/index.html.twig');
    }
}