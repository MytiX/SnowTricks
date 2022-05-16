<?php
namespace App\Tricks\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TricksPaginationController extends AbstractController
{
    #[Route('/tricks', name: 'app_tricks')]
    public function __invoke()
    {
        dd('test');
    }
}