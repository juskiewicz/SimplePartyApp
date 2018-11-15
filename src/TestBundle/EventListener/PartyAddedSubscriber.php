<?php

namespace TestBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use JeroenDesloovere\Geolocation\Geolocation;
use TestBundle\Entity\Party;
use TestBundle\Mailer\Mailer;

class PartyAddedSubscriber implements EventSubscriber
{
    /**
     * @var Mailer
     */
    private $mailer;

    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function getSubscribedEvents()
    {
        return [
            Events::postPersist,
        ];
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if ($entity instanceof Party) {
            // Sent Email
            $this->mailer->sendPartyAddedEmail($entity);
        }
    }
}
