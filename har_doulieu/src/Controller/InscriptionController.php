<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Pupitres;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;


class InscriptionController extends AbstractController
{
    #[Route('/inscription', name: 'app_inscription')]
    public function index(Request $request, EntityManagerInterface $manager,UserPasswordHasherInterface $passwordHasher ): Response
    {
        $pupitres = $manager->getRepository(Pupitres::class)->findAll();
        if($request->isMethod('POST')){
            # Vérification remplissage des champs
            if(empty($request->request->get('nom')) || empty($request->request->get('prenom')) || empty($request->request->get('pseudo')) || empty($request->request->get('email')) || empty($request->request->get('port')) || empty($request->request->get('fixe')) || empty($request->request->get('adresse')) || empty($request->request->get('CP')) || empty($request->request->get('ville')) || empty($request->request->get('naissance')) || empty($request->request->get('doulieu')) || empty($request->request->get('fede')) || empty($request->request->get('mdp')) || empty($request->request->get('pupitre')) || empty($request->request->get('role'))){
                # Ajoute un message flash
                $this->addFlash('error', 'Veuillez remplir tous les champs');
                return $this->redirectToRoute('app_inscription');
            }

            dump($request->request->all());
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

            $role= $request->request->get('role');
            if($role == 0){
                exit();
            }
            elseif($role == 1){
                $user->setRoles(['ROLE_USER']);
            }
            elseif($role == 2){
                $user->setRoles(['ROLE_ADMIN']);
            }

            $manager->persist($user);
            $manager->flush();
            return $this->redirectToRoute('app_login');
        }
        return $this->render('inscription/index.html.twig', [
            'pupitres' => $pupitres,
            
        ]);
    }
}
