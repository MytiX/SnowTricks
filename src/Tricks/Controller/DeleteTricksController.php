<?php

namespace App\Tricks\Controller;

use App\Tricks\Repository\TricksRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;

#[Route('/tricks')]
class DeleteTricksController extends AbstractController
{
    #[Route('/delete/{id}', name: 'app_delete_tricks')]
    public function __invoke(int $id, TricksRepository $tricksRepository, EntityManagerInterface $em): RedirectResponse
    {
        $tricks = $tricksRepository->find($id);

        if (null === $tricks) {
            return $this->redirectToRoute('app_home');
        }

        $this->denyAccessUnlessGranted('CAN_DELETE', $tricks);

        $em->remove($tricks);
        $em->flush();

        return $this->redirectToRoute('app_home');
    }
}