<?php

namespace App\Controller;

use entity\Message;
use App\Repository\MessageRepository;
use App\Repository\SortiesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class IndexController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(MessageRepository $messageRepository, SortiesRepository $sortiesRepository): Response
    {   
        // Récupérer le dernier message
        $message = $messageRepository->findOneBy([],['id'=>'DESC']);
        // Récupérer les sorties qui ne sont pas passées et les trier par date croissante avec une limite de 3
       
        $sort = $sortiesRepository->findBy([], ['date' => 'ASC']);
        $sorties = [];
        $i = 0;
        foreach ($sort as $s) {
            
            if ($s->getDate() >= new \DateTime()) {
                $sorties[] = $s;
            }
            if($i == 3){
                break;
            }
            $i++;
        }


        return $this->render('index/index.html.twig',[
            'message' => $message ?? 'Aucun message n\'a été trouvé',
            'sorties' => $sorties ?? 'Aucune sortie n\'a été trouvée'
        ]);
    }
}
