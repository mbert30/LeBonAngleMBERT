<?php

namespace App\EventListener;
use App\Entity\Advert;
use App\Entity\Picture;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\Common\EventArgs;
use Doctrine\ORM\Events;

#[asDoctrineListener(Events::prePersist)]
#[asDoctrineListener(Events::preUpdate)]
class DateListener
{
    public static function getSubscribedEvents(): array
    {
        return [
            Events::prePersist,
            Events::preUpdate
        ];
    }

    public function prePersist(EventArgs $event): void
    {
        $entity = $event->getObject();
        if (!$entity instanceof Advert && !$entity instanceof Picture) {
            return;
        }
        $entity->setCreatedAt(new \DateTimeImmutable("now"));
    }
    public function preUpdate(EventArgs $event): void
    {
        $entity = $event->getObject();
        if (!$entity instanceof Advert) {
            return;
        }
        $entity->setPublishedAt(new \DateTimeImmutable("now"));
    }
}