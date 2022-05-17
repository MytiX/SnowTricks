<?php
namespace App\Tricks\Controller;

use App\Tricks\Repository\TricksRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class TricksPaginationController extends AbstractController
{
    #[Route('/tricks', name: 'app_tricks', methods:['GET'])]
    public function __invoke(Request $request, TricksRepository $tricksRepository)
    {
        $pagination = (int) $request->query->get('pagination');

        $tricks = $tricksRepository->findByPagination($pagination);

        if (count($tricks) == $this->getParameter('app.home.pagination')) {
            array_pop($tricks);
        }

        $content = $this->renderView('components/_card.html.twig', [
            'tricks' => $tricks,
        ]);

        $result = [
            'content' => $content,
            'pagination' => $pagination++
        ];

        return new JsonResponse($result);
    }
}