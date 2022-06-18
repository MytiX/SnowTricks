<?php

namespace App\Tricks\Controller;

use App\Tricks\Repository\TricksRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TricksDetailController extends AbstractController
{
    #[Route('/tricks/detail/{id}', name: 'app_tricks_detail')]
    public function __invoke(int $id, TricksRepository $tricksRepository): Response
    {
        $tricks = $tricksRepository->find($id);

        if (null === $tricks) {
            return $this->redirectToRoute('app_home');
        }

        return $this->render('tricks_detail/index.html.twig', [
            'tricks' => $tricks,
        ]);
    }
}
