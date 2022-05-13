<?php

namespace App\Tricks\Controller;

use App\Media\Entity\Media;
use App\Media\Repository\MediaRepository;
use App\Tricks\Entity\Tricks;
use App\Tricks\Form\TricksType;
use App\Media\Uploads\UploadFile;
use Doctrine\ORM\EntityManagerInterface;
use App\Tricks\Repository\TricksRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

#[Route('/tricks')]
class EditTricksController extends AbstractController
{
    #[Route('/add', name: 'app_add_tricks')]
    #[Route('/edit/{id}', name: 'app_edit_tricks')]
    public function __invoke(?int $id, Request $request, EntityManagerInterface $em, TricksRepository $tricksRepository): Response
    {
        $tricks = null;

        if (null !== $id && null === ($tricks = $tricksRepository->find($id))) {
            throw new NotFoundHttpException();
        }

        if ('app_edit_tricks' === $request->attributes->get('_route')) {
            $this->denyAccessUnlessGranted('CAN_EDIT', $tricks, 'Vous ne pouvez pas accéder à cette ressource');
        }

        $form = $this->createForm(TricksType::class, $tricks);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var Tricks $tricks */
            $tricks = $form->getData();

            $libraries = $form->get('libraries')->getData();

            if (null !== $libraries) {

                $header = false;

                if (null === $tricks->getHeaderMedia()) {
                    $header = true;
                }

                foreach ($libraries as $librarie) {
                    $media = new Media($this->getParameter('app.uploads_directory'));
                    $media->setFile($librarie);
                    if ($header) {
                        $media->setHeader($header);
                        $header = false;
                    }
                    $tricks->addMedias($media);
                }
            }

            if (null === $tricks->getId()) {
                $tricks->setUser($this->getUser());
                $em->persist($tricks);
            }

            $em->flush();

            if ($request->attributes->get('_route')) {
                return $this->redirectToRoute('app_edit_tricks', [
                    'id' => $tricks->getId(),
                ]);
            }
        }

        return $this->render('edit_tricks/index.html.twig', [
            'formView' => $form->createView(),
            'tricks' => $tricks,
        ]);
    }
}
