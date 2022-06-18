<?php

namespace App\Media\Controller;

use App\Media\Entity\Media;
use App\Media\Entity\Picture;
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
        
        if (null === $data || empty($token = $data['_token'])) {
            return new JsonResponse('Bad request', 400);
        }
        
        if (true || $this->isCsrfTokenValid('delete'.$id, $token)) {
            if (null === $media = $mediaRepository->find($id)) {
                return new JsonResponse(['error' => 'Resource Not Found'], 404);
            }

            $this->denyAccessUnlessGranted('CAN_DELETE', $media, 'Vous ne pouvez pas accéder à cette ressource');
            
            $tricks = $media->getTricks();
            $tricks->preUpdate();
            
            $em->remove($media);
            $em->flush();

            return new JsonResponse(['success' => 1]);
        } else {
            return new JsonResponse(['error' => 'Token Invalid'], 400);
        }
    }
}
