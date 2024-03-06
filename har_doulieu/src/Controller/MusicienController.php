<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MusicienController extends AbstractController
{
    #[Route('/musicien', name: 'app_musicien')]
    public function index(EntityManagerInterface $manager): Response
    {   
        if($this->getUser() == null){
            return $this->redirectToRoute('app_login');
        }
        if($this->getUser()->getRoles()[0] != "ROLE_ADMIN"){
            return $this->redirectToRoute('app_index');
        }
        $users = $manager->getRepository(User::class)->findAll();
        


        return $this->render('musicien/index.html.twig', [
            'users' => $users,
        ]);

        
    }
}
