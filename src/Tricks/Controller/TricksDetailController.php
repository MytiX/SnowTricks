<?php

namespace App\Tricks\Controller;

use App\Comments\Form\CommentsType;
use App\Tricks\Repository\TricksRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TricksDetailController extends AbstractController
{
    #[Route('/tricks/detail/{id}', name: 'app_tricks_detail')]
    public function __invoke(int $id, TricksRepository $tricksRepository, Request $request, EntityManagerInterface $em): Response
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
        }

        return $this->render('tricks_detail/index.html.twig', [
            'tricks' => $tricks,
            "form" => $form->createView()
        ]);
    }
}
