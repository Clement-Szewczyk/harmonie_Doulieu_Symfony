<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Pupitres;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ModifController extends AbstractController
{
    #[Route('/modif/musicien', name: 'app_modif_musicien')]
    public function index(EntityManagerInterface $manager): Response
    {   
        if($this->getUser() == null){
            return $this->redirectToRoute('app_login');
        }
        if($this->getUser()->getRoles()[0] != "ROLE_ADMIN"){
            return $this->redirectToRoute('app_index');
        }

        ## Récupère l'id en get
        $id = $_GET['id'];
        $user = $manager->getRepository(User::class)->find($id);
        $pupitres = $manager->getRepository(Pupitres::class)->findAll();
        dump($id);
        dump($user);

        return $this->render('modif/musicien.html.twig', [
            'user' => $user, 'pupitres' => $pupitres
        ]);
    }
}
