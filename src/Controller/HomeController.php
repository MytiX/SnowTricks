<?php

namespace App\Controller;

use App\Tricks\Repository\TricksRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function __invoke(TricksRepository $tricksRepository): Response
    {
        $tricks = $tricksRepository->findAll();

        return $this->render('home/index.html.twig', [
            'tricks' => $tricks
        ]);
    }
}
