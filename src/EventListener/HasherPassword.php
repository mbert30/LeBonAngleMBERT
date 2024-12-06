<?php

namespace App\EventListener;
use App\Entity\AdminUser;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\Common\EventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[asDoctrineListener(Events::prePersist)]
#[asDoctrineListener(Events::preUpdate)]
class HasherPassword
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            Events::prePersist,
            Events::preUpdate
        ];
    }

    public function prePersist(EventArgs $event): void
    {
        $this->encodePassword($event);
    }

    public function preUpdate(EventArgs $event): void
    {
        $this->encodePassword($event);
    }

    private function encodePassword(EventArgs $event): void
    {
        $user = $event->getObject();
        if(!$user instanceof AdminUser) {
            return;
        }

        $user->setPassword($this->passwordHasher->hashPassword($user, $user->getPlainPassword()));
    }
}