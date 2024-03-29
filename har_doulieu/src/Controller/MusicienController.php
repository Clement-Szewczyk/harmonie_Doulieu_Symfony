<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Pupitres;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route('/musicien')]
class MusicienController extends AbstractController
{
    #[Route('/', name: 'app_musicien_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {   
        
        return $this->render('musicien/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    /*#[Route('/new', name: 'app_musicien_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher ): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $mdp = $form->get('password')->getData();
            $user->setPassword($passwordHasher->hashPassword($user,$mdp));
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_musicien_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('musicien/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }*/


    #[Route('/new', name: 'app_musicien_new')]
    public function new(Request $request, EntityManagerInterface $manager,UserPasswordHasherInterface $passwordHasher ): Response
    {
        $pupitres = $manager->getRepository(Pupitres::class)->findAll();
        
        if($request->isMethod('POST')){
            # Vérification remplissage des champs
            if(empty($request->request->get('nom')) || empty($request->request->get('prenom')) || empty($request->request->get('pseudo')) || empty($request->request->get('email')) || empty($request->request->get('port')) || empty($request->request->get('adresse')) || empty($request->request->get('CP')) || empty($request->request->get('ville')) || empty($request->request->get('naissance')) || empty($request->request->get('doulieu')) || empty($request->request->get('fede')) || empty($request->request->get('mdp')) || empty($request->request->get('pupitre')) || empty($request->request->get('role'))){
                # Ajout d'un message flash
                $this->addFlash('error', 'Veuillez remplir tous les champs');
                return $this->redirectToRoute('app_musicien_new');
            }

            # Vérification de l'unicité du pseudo
            $pseudo = $manager->getRepository(User::class)->findOneBy(['pseudo' => $request->request->get('pseudo')]);
            if($pseudo != null){
                # Ajout d'un message flash
                $this->addFlash('error', 'Ce pseudo est déjà utilisé');
                return $this->redirectToRoute('app_musicien_new');
            }

            
            $user = new User();
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
            $user->setPassword($passwordHasher->hashPassword($user,$request->request->get('mdp')));
            $user->setPupitre($manager->getRepository(Pupitres::class)->find($request->request->get('pupitre')));     

            $user->setRoles([$request->request->get('role')]);
            $manager->persist($user);
            $manager->flush();
            return $this->redirectToRoute('app_musicien_index');
        }
        return $this->render('musicien/new.html.twig', [
            'pupitres' => $pupitres, 
        ]);
    }


    #[Route('/{id}/edit', name: 'app_musicien_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, EntityManagerInterface $manager, $id): Response
    {
        $user = $manager->getRepository(User::class)->find($id);
        $pupitres = $manager->getRepository(Pupitres::class)->findAll();
        
        

        if($request->isMethod('POST')){
            # On vérifie si les champs sont remplis
            if(empty($request->request->get('nom')) || empty($request->request->get('prenom')) || empty($request->request->get('pseudo')) || empty($request->request->get('email')) || empty($request->request->get('port')) || empty($request->request->get('adresse')) || empty($request->request->get('CP')) || empty($request->request->get('ville')) || empty($request->request->get('naissance')) || empty($request->request->get('doulieu')) || empty($request->request->get('fede')) || empty($request->request->get('pupitre')) || empty($request->request->get('role'))){
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
            return $this->redirectToRoute('app_musicien_index');
        }

        return $this->render('musicien/edit.html.twig', [
            'user' => $user, 'pupitres' => $pupitres
        ]);
    }

    #[Route('/{id}', name: 'app_musicien_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            # Regarde s'il est dans la table instrument 
            $instrument = $user->getInstruments();
            
            if(!empty($instrument) && $instrument[0] != null){
                
                #Ajout d'un message flash
                $this->addFlash('error', 'Suppression Interdite, le musicien est lié à un instrument');
                return $this->redirectToRoute('app_musicien_index', [], Response::HTTP_SEE_OTHER);

            }
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_musicien_index', [], Response::HTTP_SEE_OTHER);
    }
}
