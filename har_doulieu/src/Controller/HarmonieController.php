<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use DateTime;

#[Route('/harmonie')]
class HarmonieController extends AbstractController
{

    #[Route('/historique', name: 'app_historique')]
    public function historique(): Response
    {
        return $this->render('harmonie/historique.html.twig');
    }

    #[Route('/ecole', name: 'app_ecole')]
    public function ecole(): Response
    {
        return $this->render('harmonie/ecole.html.twig');
    }

    #[Route('/direction', name: 'app_direction')]
    public function direction(): Response
    {
        return $this->render('harmonie/direction.html.twig');
    }

    #[Route('/contact', name: 'app_contact')]
    public function contact(): Response
    {
        return $this->render('harmonie/contact.html.twig');
    }

    #[Route('/repetitions', name: 'repetitions')]
    public function repet(): Response
    {
        // Logique pour calculer la prochaine répétition
        $nextRehearsalDate = new DateTime();
        if ($nextRehearsalDate->format('N') != 3) {
            $nextRehearsalDate->modify('next Wednesday');
        }
        $nextRehearsalDate->setTime(20, 0);

        // Formater la date en français avec le jour de la semaine
        $formatter = new \IntlDateFormatter('fr_FR', \IntlDateFormatter::FULL, \IntlDateFormatter::NONE);
        $formattedDate = $formatter->format($nextRehearsalDate);


        // Passer les données à la vue
        return $this->render('harmonie/repetitions.html.twig', [
            'formattedDate' => $formattedDate,
        ]);
    }
}
