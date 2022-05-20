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
        $tricks = $tricksRepository->findByPagination(0);

        $page = false;

        if (count($tricks) > $this->getParameter('app.home.number.item')) {
            array_pop($tricks);
            $page = true;
        }

        return $this->render('home/index.html.twig', [
            'tricks' => $tricks,
            'page' => $page
        ]);
    }
}
