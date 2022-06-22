<?php

namespace App\Comments\Controller;

use Symfony\Component\HttpFoundation\Request;
use App\Comments\Repository\CommentsRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/api')]
class CommentsPaginationController extends AbstractController 
{
    #[Route('/comments', 'app_comments', methods: ['GET'])]
    public function __invoke(Request $request, CommentsRepository $commentsRepository)
    {
        $page = (int) $request->query->get('page');

        $comments = $commentsRepository->findByPagination($page);

        $response = [];
        
        if (count($comments) > $this->getParameter('app.tricks.comments.number.item')) {
            array_pop($comments);
            $response['page'] = $page + 1;
        } else {
            $response['page'] = null;
        }

        $content = $this->renderView('components/_comments.html.twig', [
            'comments' => $comments,
        ]);

        $response['content'] = $content;

        return new JsonResponse($response);
    }
}