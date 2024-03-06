<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HarmonieController extends AbstractController
{

    #[Route('/historique', name: 'app_historique')]
    public function historique(): Response
    {
        return $this->render('harmonie/historique.html.twig');
    }

    #[Route('/ecole', name: 'app_ecole')]
    public function ecole(): Response
    {
        return $this->render('harmonie/ecole.html.twig');
    }

    #[Route('/direction', name: 'app_direction')]
    public function direction(): Response
    {
        return $this->render('harmonie/direction.html.twig');
    }
}
