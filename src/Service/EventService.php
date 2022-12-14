<?php

namespace App\Service;

use App\Entity\Event;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class EventService
{
    public function __construct(EntityManagerInterface $em, UrlGeneratorInterface $urlGenerator) {
        $this->em = $em;
        $this->urlGenerator = $urlGenerator;
    }

    public function getEventsForCalendar(?UserInterface $user)
    {
        $events = $this->em->getRepository(Event::class)->findForUser($user);

        foreach ($events as $key => $event) {
            $events[$key]['start'] = $event['start']->format('Y-m-d\Th:i:s');
            $events[$key]['end'] = $event['end']->format('Y-m-d\Th:i:s');
            $events[$key]['url'] = $this->urlGenerator->generate('see_event', ['id' => $event['id']]);
        }

        return json_encode($events);
    }
}