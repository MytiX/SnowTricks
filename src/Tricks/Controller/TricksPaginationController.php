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
        $page = (int) $request->query->get('page');

        $tricks = $tricksRepository->findByPagination($page);

        $response = [];
        
        dump($tricks);

        if (count($tricks) == $this->getParameter('app.home.pagination')) {
            array_pop($tricks);
            $response['page'] = $page + 1;
        } else {
            $response['page'] = null;
        }

        dd($tricks);


        $content = $this->renderView('components/_card.html.twig', [
            'tricks' => $tricks,
        ]);

        $response['content'] = $content;

        return new JsonResponse($response);
    }
}