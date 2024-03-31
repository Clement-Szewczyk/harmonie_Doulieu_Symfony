<?php

namespace App\Controller;

use entity\Message;
use App\Repository\MessageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class IndexController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(MessageRepository $messageRepository): Response
    {   
        // Récupérer le dernier message
        $message = $messageRepository->findOneBy([],['id'=>'DESC']);
        dump($message);
        return $this->render('index/index.html.twig',[
           'message' => $message ?? 'Aucun message n\'a été trouvé'
        ]);
    }
}
