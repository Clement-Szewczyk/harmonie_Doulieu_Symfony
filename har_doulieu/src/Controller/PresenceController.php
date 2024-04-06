<?php

namespace App\Controller;
use App\Entity\Sorties;
use App\Entity\User;
use App\Entity\Presence;

use App\Repository\PresenceRepository;
use App\Repository\SortiesRepository;

use Doctrine\ORM\EntityManagerInterface;
use PhpParser\Node\Expr\New_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\Persistence\ManagerRegistry;



#[Route('/presence')]
class PresenceController extends AbstractController
{
    #[Route('/', name: 'app_presence_index')]
    public function index(PresenceRepository $presenceRepository, SortiesRepository $sortiesRepository, EntityManagerInterface $manager, Request $request): Response
    {   
        
        


        $user = $this->getUser();       
        
        
        $sortie = $sortiesRepository->findAll();
        
        if($request->isMethod('POST')){
            //Suppression des anciennes présences
            $presences = $presenceRepository->findBy(['User' => $user]);
            foreach($presences as $p){
                $manager->remove($p);
                $manager->flush();
            }
            foreach($sortie as $s){
                
                $id = $s->getId();
                $reponse = $request->request->get("presence_".$id);
                if($reponse != null){
                    $presence = new Presence();
                    $presence->setReponse($reponse);
                    $presence->setEvent($s);
                    $presence->setUser($user);
                    $manager->persist($presence);
                    $manager->flush();
                }
            }
        }


        return $this->render('presence/index.html.twig', [
            'presences' => $presenceRepository->findAll(),
            'sorties' => $sortie,
            'user' => $user
        ]);
    }

    
}