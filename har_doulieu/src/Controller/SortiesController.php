<?php

namespace App\Controller;

use App\Entity\Presence;
use App\Entity\Sorties;
use App\Repository\UserRepository;
use App\Form\SortiesType;
use App\Repository\SortiesRepository;
use App\Repository\PresenceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/sorties')]
class SortiesController extends AbstractController
{
    #[Route('/', name: 'app_sorties_index', methods: ['GET'])]
    public function index(SortiesRepository $sortiesRepository): Response
    {
        return $this->render('sorties/index.html.twig', [
            'sorties' => $sortiesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_sorties_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $sorty = new Sorties();
        $form = $this->createForm(SortiesType::class, $sorty);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($sorty);
            $entityManager->flush();

            return $this->redirectToRoute('app_sorties_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('sorties/new.html.twig', [
            'sorty' => $sorty,
            'form' => $form,
        ]);
    }


        

    #[Route('/{id}/edit', name: 'app_sorties_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Sorties $sorty, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SortiesType::class, $sorty);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_sorties_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('sorties/edit.html.twig', [
            'sorty' => $sorty,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_sorties_delete', methods: ['POST'])]
    public function delete(Request $request, Sorties $sorty, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sorty->getId(), $request->request->get('_token'))) {
            $entityManager->remove($sorty);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_sorties_index', [], Response::HTTP_SEE_OTHER);
    }



    #[Route('/export', name: 'app_sorties_export', methods: ['GET'])]
    public function exportSorties(PresenceRepository $presenceRepository, SortiesRepository $sortiesRepository, UserRepository $userRepository): Response
    {
        // Récupérer toutes les présences
        $presences = $presenceRepository->findAll();

        // Récupérer tous les musiciens
        $musiciens = $userRepository->findAll();

        // Initialiser un tableau pour stocker les CSV rows de chaque musicien
        $musiciensCSVRows = [];

        // Parcourir toutes les présences
        foreach ($presences as $presence) {
            // Récupérer les informations sur le musicien et l'instrument
            $musicien = $presence->getUser()->getNom() . ' ' . $presence->getUser()->getPrenom();
            $instrument = $presence->getUser()->getPupitre()->getNom();
            // Vérifier si le musicien a déjà été traité
            if (isset($musiciensCSVRows[$musicien])) {
                continue; // Passer à la prochaine présence si le musicien a déjà été traité
            }

            

            // Initialiser la ligne pour ce musicien
            $csvRow = "\"$musicien\", $instrument,";

            // Ajouter le CSV row au tableau des musiciens
            $musiciensCSVRows[$musicien] = $csvRow;
            
        }

        //Ajout des musiciens sans présence
        foreach ($musiciens as $musicien) {
            $instrument = $musicien->getPupitre()->getNom();
            $musicien = $musicien->getNom() . ' ' . $musicien->getPrenom();
            
            if (!isset($musiciensCSVRows[$musicien])) {
                $csvRow = "\"$musicien\", $instrument,";
                $musiciensCSVRows[$musicien] = $csvRow;
            }
        }

        // Initialiser les en-têtes du fichier CSV
        $csvContent = "Musicien,Instrument,";

        // Récupérer tous les titres de sortie
        $sorties = $sortiesRepository->findAll();

        // Ajouter les titres de sortie comme en-têtes de colonnes
        foreach ($sorties as $sortie) {
            $csvContent .= $sortie->getTitre() . ',';
        }

        // Supprimer la virgule finale et ajouter un retour à la ligne
        $csvContent = rtrim($csvContent, ',') . "\n";

        // Parcourir les musiciens triés et ajouter leur CSV row au contenu CSV
        foreach ($musiciensCSVRows as $musicien => $csvRow) {
            // Parcourir toutes les sorties et récupérer la réponse pour chaque sortie
            foreach ($sorties as $sortie) {
                $presenceTrouvee = false; // Variable pour suivre si la présence du musicien dans cette sortie est trouvée
                foreach ($sortie->getPresences() as $presence) {
                    // Vérifier si la présence appartient au musicien actuel
                    if ($presence->getUser()->getNom() . ' ' . $presence->getUser()->getPrenom() === $musicien) {
                        $reponse = $presence->getReponse();
                        if ($reponse == '1') {
                            $reponse = 'Oui';
                        } elseif ($reponse == '0') {
                            $reponse = 'Non';
                        } elseif ($reponse == '2') {
                            $reponse = '?';
                        } else {
                            $reponse = ' ';
                        }
                        // Ajouter la réponse au CSV row
                        $csvRow .= "$reponse,";
                        $presenceTrouvee = true; // Mettre à true pour indiquer que la présence a été trouvée
                        break; // Sortir de la boucle de présence pour cette sortie
                    }
                }
                // Si la présence n'est pas trouvée pour cette sortie, ajouter une cellule vide
                if (!$presenceTrouvee) {
                    $csvRow .= ",";
                }
            }
            // Ajouter la ligne CSV complétée au contenu CSV
            $csvContent .= rtrim($csvRow, ',') . "\n";
        }


        // Définir les en-têtes de réponse avec l'encodage UTF-8
        $response = new Response($csvContent, 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="export_sorties.csv"',
        ]);

        return $response;
        
        
        /*return new Response(
            '<html><body><h1>Hello</h1></body></html>'
        );*/
    }



















}
