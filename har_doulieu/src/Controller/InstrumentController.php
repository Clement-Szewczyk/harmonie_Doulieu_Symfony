<?php

namespace App\Controller;

use App\Entity\Instrument;
use App\Form\InstrumentType;
use App\Repository\InstrumentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/instrument')]
class InstrumentController extends AbstractController
{
    #[Route('/', name: 'app_instrument_index', methods: ['GET'])]
    public function index(InstrumentRepository $instrumentRepository): Response
    {   
        return $this->render('instrument/index.html.twig', [
            'instruments' => $instrumentRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_instrument_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $instrument = new Instrument();
        $form = $this->createForm(InstrumentType::class, $instrument);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if($form->get('locataire_musicien')->getData() != null && $form->get('locataire_eleves')->getData() != null){
                
                $this->addFlash('error', 'Vous ne pouvez pas attribuer un instrument à un musicien et à un élève en même temps');
                return $this->redirectToRoute('app_instrument_new', ['form' => $form,'instrument' => $instrument], Response::HTTP_SEE_OTHER);
            }
            if($form->get('locataire_musicien')->getData() == null && $form->get('locataire_eleves')->getData() != null){
                $instrument->setLocataireMusicien(null);
            }
            if($form->get('locataire_eleves')->getData() == null && $form->get('locataire_musicien')->getData() != null){
                $instrument->setLocataireEleves(null);
            }
            $entityManager->persist($instrument);
            $entityManager->flush();

            return $this->redirectToRoute('app_instrument_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('instrument/new.html.twig', [
            'instrument' => $instrument,
            'form' => $form,
        ]);
    }


    #[Route('/{id}/edit', name: 'app_instrument_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Instrument $instrument, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(InstrumentType::class, $instrument);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if($form->get('locataire_musicien')->getData() != null && $form->get('locataire_eleves')->getData() != null){
                
                $this->addFlash('error', 'Vous ne pouvez pas attribuer un instrument à un musicien et à un élève en même temps');
                ## Redirection vers la page d'édition de l'instrument en cours avec l'id de l'instrument
                return $this->redirectToRoute('app_instrument_edit', ['id' => $instrument->getId()], Response::HTTP_SEE_OTHER);
            }
            if($form->get('locataire_musicien')->getData() == null && $form->get('locataire_eleves')->getData() != null){
                $instrument->setLocataireMusicien(null);
            }
            if($form->get('locataire_eleves')->getData() == null && $form->get('locataire_musicien')->getData() != null){
                $instrument->setLocataireEleves(null);
            }
            $entityManager->persist($instrument);
            $entityManager->flush();

            return $this->redirectToRoute('app_instrument_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('instrument/edit.html.twig', [
            'instrument' => $instrument,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_instrument_delete', methods: ['POST'])]
    public function delete(Request $request, Instrument $instrument, EntityManagerInterface $entityManager):Response
    {
        if ($this->isCsrfTokenValid('delete'.$instrument->getId(), $request->request->get('_token'))) {
            $entityManager->remove($instrument);
            $entityManager->flush();
        }
        return $this->redirectToRoute('app_instrument_index', [], Response::HTTP_SEE_OTHER);
    }
}
