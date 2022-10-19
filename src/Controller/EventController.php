<?php

namespace App\Controller;

use App\Entity\Event;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EventController extends AbstractController
{
    #[Route('/event/{id}', name: 'see_event')]
    public function seeEvent($id, EntityManagerInterface $em): Response
    {
        $event = $em->getRepository(Event::class)->findOneBy(['id' => $id]);

        if ($event->isIsAdmin() === false) {
            $event = ($event->getCreatedBy() == $this->getUser()) ? $event : null;
        }


        if ($event === null) {
            $this->addFlash('error', 'Événement introuvable');
            return $this->redirectToRoute('dashboard');
        }

        return $this->render('event/index.html.twig', [
            'event' => $event,
        ]);
    }
}
