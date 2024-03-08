<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Pupitres;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;


#[Route('/musicien', name: 'app_musiciens')]
class MusicienController extends AbstractController
{
    #[Route('/', name: '')]   
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

    #[Route('/{id}', name: '_musicien')]
    public function edit(EntityManagerInterface $manager, $id, Request $request): Response
    {   
        if($this->getUser() == null){
            return $this->redirectToRoute('app_login');
        }
        if($this->getUser()->getRoles()[0] != "ROLE_ADMIN"){
            return $this->redirectToRoute('app_index');
        }
        
        $user = $manager->getRepository(User::class)->find($id);
        $pupitres = $manager->getRepository(Pupitres::class)->findAll();

        if($request->isMethod('POST')){
            # On vérifie si les champs sont remplis
            if(empty($request->request->get('nom')) || empty($request->request->get('prenom')) || empty($request->request->get('pseudo')) || empty($request->request->get('email')) || empty($request->request->get('port')) || empty($request->request->get('fixe')) || empty($request->request->get('adresse')) || empty($request->request->get('CP')) || empty($request->request->get('ville')) || empty($request->request->get('naissance')) || empty($request->request->get('doulieu')) || empty($request->request->get('fede')) || empty($request->request->get('pupitre')) || empty($request->request->get('role'))){
                # Ajoute un message flash
                $this->addFlash('error', 'Veuillez remplir tous les champs');
                return $this->redirectToRoute('app_modif_musicien', ['id' => $id]);
            }
            $user->setNom($request->request->get('nom'));
            $user->setPrenom($request->request->get('prenom'));
            $user->setPseudo($request->request->get('pseudo'));
            $user->setEmail($request->request->get('email'));
            $user->setTelPort($request->request->get('port'));
            $user->setTelFixe($request->request->get('fixe'));
            $user->setAdresse($request->request->get('adresse'));
            ## Convertir le code postal en int
            $cp = (int)$request->request->get('CP');
            $user->setCp($cp);
            $user->setVille($request->request->get('ville'));
            $user->setDateNaissance(new \DateTime($request->request->get('naissance')));
            $user->setDateHar(new \DateTime($request->request->get('doulieu')));
            $user->setDateFede(new \DateTime($request->request->get('fede')));

            $user->setPupitre($manager->getRepository(Pupitres::class)->find($request->request->get('pupitre')));
            $user->setRoles([$request->request->get('role')]);

            $manager->persist($user);
            $manager->flush();
            return $this->redirectToRoute('app_musiciens');
        }

        return $this->render('musicien/edit.html.twig', [
            'user' => $user, 'pupitres' => $pupitres
        ]);
    }

    #[Route('/{id}/delete', name: '_delete')]
    public function delete(EntityManagerInterface $manager, Request $request, $id): Response
    {   
        return $this->render('musicien/delete.html.twig', [
            'id' => $id
        ]);
    }
 
}
