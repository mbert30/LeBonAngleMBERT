<?php

namespace App\EventListener;

use App\Entity\Advert;
use DateTimeImmutable;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\Common\EventArgs;
use Doctrine\ORM\Events;
use Symfony\Bridge\Twig\Mime\NotificationEmail;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Mailer\MailerInterface;

#[asDoctrineListener(Events::preUpdate)]
class WorkflowStateChangeListener
{
    private MailerInterface $mailer;


    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function preUpdate(EventArgs $event): void
    {
        $entity = $event->getObject();
        if(!$entity instanceof Advert && $entity->getState() === 'published') {
            return;
        }
        $entity->setPublishedAt(new DateTimeImmutable());
        $this->mailer->send((new NotificationEmail())
                ->subject('Votre annonce a bien été publiée')
                ->from('wG7oO@example.com')
                ->to($entity ->getEmail())
        );
    }
}