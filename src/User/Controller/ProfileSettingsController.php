<?php

namespace App\User\Controller;

use App\User\Form\UserSettingsType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProfileSettingsController extends AbstractController
{
    #[Route('/profile/settings', name: 'app_user_settings')]
    public function __invoke(Request $request, EntityManagerInterface $em)
    {
        $user = $this->getUser();

        $form = $this->createForm(UserSettingsType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $em->flush();
        }

        return $this->render('user/settings.html.twig', [
            'form' => $form->createView()
        ]);
    }
}