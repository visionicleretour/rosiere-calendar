<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
use App\Service\EventService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{

    private $em;
    private $eventService;

    public function __construct(EntityManagerInterface $em, EventService $eventService) {
        $this->em = $em;
        $this->eventService = $eventService;
    }

    #[Route('/dashboard', name: 'dashboard')]
    public function index(): Response
    {
        $events = $this->eventService->getEventsForCalendar($this->getUser());

        return $this->render('dashboard/index.html.twig', [
            'events' => $events,
        ]);
    }

    #[Route('/dashboard/new', name: 'dashboard_new_event')]
    public function newEvent(Request $request)
    {
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $event->setCreatedBy($this->getUser());
            $event->setIsAdmin(in_array('ROLE_ADMIN', $this->getUser()->getRoles()));

            $this->em->persist($event);
            $this->em->flush();

            $this->addFlash('success', 'Événement créé');
            return $this->redirectToRoute('dashboard');
        }

        return $this->renderForm('dashboard/new.html.twig', [
            'form' => $form
        ]);
    }
}
