<?php

namespace App\Tricks\Controller;

use App\Comments\Form\CommentsType;
use App\Comments\Repository\CommentsRepository;
use App\Tricks\Repository\TricksRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TricksDetailController extends AbstractController
{
    #[Route('/tricks/detail/{id}', name: 'app_tricks_detail')]
    public function __invoke(int $id, TricksRepository $tricksRepository, CommentsRepository $commentsRepository, Request $request, EntityManagerInterface $em): Response
    {
        $tricks = $tricksRepository->find($id);

        if (null === $tricks) {
            return $this->redirectToRoute('app_home');
        }

        $form = $this->createForm(CommentsType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() AND $form->isValid()) {
            $comments = $form->getData();
            $comments->setUser($this->getUser());
            $tricks->addComment($comments);
            $em->flush();
            return $this->redirectToRoute('app_tricks_detail', ['id' => $id]);
        }

        // Pagination
        $comments = $commentsRepository->findByPagination(0);

        $page = false;

        if (count($comments) > $this->getParameter('app.tricks.comments.number.item')) {
            array_pop($comments);
            $page = true;
        }

        return $this->render('tricks_detail/index.html.twig', [
            'tricks' => $tricks,
            'comments' => $comments,
            'form' => $form->createView(),
            'page' => $page,
        ]);
    }
}
