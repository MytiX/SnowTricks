<?php

namespace App\Media\Controller;

use App\Media\Entity\Media;
use Doctrine\ORM\EntityManagerInterface;
use App\Media\Repository\MediaRepository;
use App\Tricks\Repository\TricksRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MediaController extends AbstractController
{
    #[Route('/media/delete/{id}', name: 'app_delete_media', methods: 'DELETE')]
    public function delete(int $id, Request $request, MediaRepository $mediaRepository, EntityManagerInterface $em)
    {        
        $data = json_decode($request->getContent(), true);

        $token = $data['_token'];
        
        if ($this->isCsrfTokenValid('delete'.$id, $token)) {
            
            $media = $mediaRepository->find($id);

            if (null === $media) {
                return new JsonResponse(['error' => 'Resource Not Found'], 404);
            }

            $em->remove($media);
            $em->flush();

            return new JsonResponse(['success' => 1]);
        } else {
            return new JsonResponse(['error' => 'Token Invalid'], 400);
        }
    }

    #[Route('/media/header/{tricks_id}/{media_id}', name: 'app_header_media', methods: 'PUT')]
    public function header(int $tricks_id, int $media_id, Request $request, TricksRepository $tricksRepository, EntityManagerInterface $em)
    {        
        $data = json_decode($request->getContent(), true);

        $token = $data['_token'];
        
        if ($this->isCsrfTokenValid('header'.$tricks_id.$media_id, $token)) {
            
            $tricks = $tricksRepository->find([
                'id' => $tricks_id,
            ]);

            $medias = $tricks->getMedias();

            if (null === $tricks || null === $medias) {
                return new JsonResponse(['error' => 'Resource Not Found'], 404);
            }

            foreach ($medias as $media) {
                /** @var Media $media */
                if (true === $media->getHeader()) {
                    $media->setHeader(false);
                    $old_media = $media->getId();
                }

                if ($media->getId() === $media_id) {
                    $media->setHeader(true);
                }
            }
            
            $em->flush();

            return new JsonResponse(['success' => 1, 'old_media_id' => $old_media]);
        } else {
            return new JsonResponse(['error' => 'Token Invalid'], 400);
        }
    }
}
