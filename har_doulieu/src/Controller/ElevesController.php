<?php

namespace App\Controller;

use App\Entity\Eleves;
use App\Entity\User;
use App\Form\ElevesType;
use App\Repository\ElevesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


#[Route('/eleves')]
class ElevesController extends AbstractController
{
    #[Route('/', name: 'app_eleves_index', methods: ['GET'])]
    public function index(ElevesRepository $elevesRepository): Response
    {
        return $this->render('eleves/index.html.twig', [
            'eleves' => $elevesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_eleves_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $elefe = new Eleves();
        $form = $this->createForm(ElevesType::class, $elefe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($elefe);
            $entityManager->flush();

            return $this->redirectToRoute('app_eleves_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('eleves/new.html.twig', [
            'elefe' => $elefe,
            'form' => $form,
        ]);
    }


    #[Route('/{id}/edit', name: 'app_eleves_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Eleves $elefe, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response
    {
        $form = $this->createForm(ElevesType::class, $elefe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_eleves_index', [], Response::HTTP_SEE_OTHER);
        }
        

        //SI requet POST
        if($request->isMethod('POST')){
            //SI il existe une requete POST du nom de transform
            if($request->request->has('transform')){
                //On récupère les valeurs du formulaire
                $pseudo = $request->request->get('pseudo');
                $mdp = $request->request->get('mdp');
                $fede = $request->request->get('fede');


                // On crée un nouvel utilisateur
                $user = new User();
                $user->setNom($elefe->getNom());
                $user->setPrenom($elefe->getPrenom());
                $user->setPseudo($pseudo);
                $user->setEmail($elefe->getEmail());
                $user->setTelPort($elefe->getTelPort());
                $user->setTelFixe($elefe->getTelFix());
                $user->setAdresse($elefe->getAdresse());
                

                $user->setCp($elefe->getCp());
                $user->setVille($elefe->getVille());
                $user->setDateNaissance($elefe->getDateNaissance());
                $user->setDateHar(new \DateTime($fede));
                $user->setDateFede(new \DateTime($fede));
                $user->setPassword($passwordHasher->hashPassword($user,$mdp));
                $user->setPupitre($elefe->getPupitre());     

                $user->setRoles(['ROLE_USER']);
                $entityManager->persist($user);
                $entityManager->flush();

                
                $instrument = $elefe->getInstruments();
                if(!empty($instrument) && $instrument[0] != null){
                    
                    $instrument[0]->setLocataireEleves(null);
                    $instrument[0]->setLocataireMusicien($user);
                    $entityManager->persist($instrument[0]);
                    $entityManager->flush();

                }
                //exécute le formulaire de suppression
                


            }
        }
        return $this->render('eleves/edit.html.twig', [
            'elefe' => $elefe,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_eleves_delete', methods: ['POST'])]
    public function delete(Request $request, Eleves $elefe, EntityManagerInterface $entityManager): Response
    {   
        if ($this->isCsrfTokenValid('delete'.$elefe->getId(), $request->request->get('_token'))) {
            # Regarde s'il est dans la table instrument 
            $instrument = $elefe->getInstruments();
            
            if(!empty($instrument) && $instrument[0] != null){
                #Ajout d'un message flash
                $this->addFlash('error', 'Suppression Interdite, l\'élèves est lié à un instrument');
                return $this->redirectToRoute('app_eleves_index', [], Response::HTTP_SEE_OTHER);
            }
            $entityManager->remove($elefe);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_eleves_index', [], Response::HTTP_SEE_OTHER);
    }
}
