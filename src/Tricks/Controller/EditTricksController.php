<?php

namespace App\Tricks\Controller;

use App\Entity\Tricks;
use App\Form\TricksType;
use App\Repository\TricksRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EditTricksController extends AbstractController
{
    #[Route('/tricks/add', name: 'app_add_tricks')]
    #[Route('/tricks/edit/{id}', name: 'app_edit_tricks')]
    public function __invoke(?int $id = null, Request $request, EntityManagerInterface $em): Response
    {
        $tricks = null;

        if ('app_edit_tricks' === $request->attributes->get('_route')) {
            if (null === $id) {
                dd('Redirect 404 Not found');
            }

            $tricks = $em->find(Tricks::class, $id);
        }

        $form = $this->createForm(TricksType::class, $tricks);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $now = new DateTime();

            /** @var Tricks $tricks */
            $tricks = $form->getData();

            if ('app_add_tricks' === $request->attributes->get('_route')) {
                $tricks->setCreatedAt($now);
            }

            $tricks->setUpdatedAt($now);

            $em->persist($tricks);
            $em->flush();
        }

        return $this->render('edit_tricks/index.html.twig', [
            'formView' => $form->createView(),
        ]);
    }
}
