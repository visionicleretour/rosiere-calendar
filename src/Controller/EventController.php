<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EventController extends AbstractController
{
    #[Route('/event/{id}', name: 'see_event')]
    public function seeEvent($id): Response
    {
        return $this->render('event/index.html.twig', [
            'controller_name' => 'Event => '. $id,
        ]);
    }
}
