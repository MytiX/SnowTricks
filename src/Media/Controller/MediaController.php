<?php

namespace App\Media\Controller;

use Doctrine\ORM\EntityManagerInterface;
use App\Media\Repository\MediaRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MediaController extends AbstractController
{
    #[Route('/media/{id}', name: 'app_delete_media', methods: 'DELETE')]
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
}
