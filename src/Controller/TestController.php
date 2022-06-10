<?php

namespace App\Controller;

use DateTime;
use App\Entity\Tag;
use App\Entity\Task;
use App\Form\TaskType;
use App\Media\Entity\Embed;
use App\Media\Entity\Picture;
use App\Media\Form\MediaType;
use App\Tricks\Form\TricksType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Media\Repository\MediaRepository;
use App\Tricks\Repository\TricksRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TestController extends AbstractController
{
    #[Route('/test', name: 'app_cgu')]
    public function index(Request $request, TricksRepository $tricksRepository, EntityManagerInterface $em, UserRepository $userRepository): Response
    {
        $tricks = $tricksRepository->find(5);
        
        $form = $this->createForm(TricksType::class, $tricks);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            /** @var Tricks $tricks */
            $tricks = $form->getData();

            $tricks->setUser($userRepository->find(1));

            foreach ($tricks->getTempMedias() as $media) {
                if (null !== ($embed = $media['embed'])) {
                    $tricks->addMedias($embed);    
                } elseif (null !== ($picture = $media['picture'])) {
                    $tricks->addMedias($picture);
                }
            }

            $em->persist($tricks);
            $em->flush();
        }

        return $this->render('test/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
