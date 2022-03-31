<?php

namespace App\Tricks\Controller;

use App\Tricks\Form\TricksType;
use Doctrine\ORM\EntityManagerInterface;
use App\Tricks\Repository\TricksRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class EditTricksController extends AbstractController
{
    #[Route('/tricks/add', name: 'app_add_tricks')]
    #[Route('/tricks/edit/{id}', name: 'app_edit_tricks')]
    public function __invoke(?int $id, Request $request, EntityManagerInterface $em, TricksRepository $tricksRepository): Response
    {
        $tricks = null;

        if (null !== $id && null === ($tricks = $tricksRepository->find($id))) {
            throw new NotFoundHttpException();
        }

        $form = $this->createForm(TricksType::class, $tricks);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $tricks = $form->getData();

            if (null === $tricks->getId()) {
                $em->persist($tricks);
            }

            $em->flush();
        }

        return $this->render('edit_tricks/index.html.twig', [
            'formView' => $form->createView(),
        ]);
    }
}
