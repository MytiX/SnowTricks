<?php

namespace App\Controller;

use App\Media\Form\MediaType;
use App\Tricks\Form\TricksType;
use App\Media\Repository\MediaRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CGUController extends AbstractController
{
    #[Route('/cgu', name: 'app_cgu')]
    public function index(Request $request): Response
    {
        $form = $this->createForm(TricksType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            dd($form->getData());
        }

        return $this->render('cgu/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
