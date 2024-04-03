<?php

namespace App\Controller;

use App\Entity\Presence;
use App\Entity\Sortie;
use App\Form\PresenceType;
use App\Repository\PresenceRepository;
use App\Repository\SortiesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/presence')]
class PresenceController extends AbstractController
{
    #[Route('/', name: 'app_presence_index', methods: ['GET'])]
    public function index(PresenceRepository $presenceRepository, SortiesRepository $sortiesRepository): Response
    {   
        #Récupére les sorties
        $sortie = $sortiesRepository->findAll();
        return $this->render('presence/index.html.twig', [
            'presences' => $presenceRepository->findAll(),
            'sorties' => $sortie
        ]);
    }
}