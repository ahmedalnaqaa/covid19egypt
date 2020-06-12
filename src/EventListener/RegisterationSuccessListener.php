<?php

namespace App\EventListener;

use App\Entity\Chat;
use App\Entity\Test;
use App\Entity\User;
use Doctrine\ORM\EntityManager;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\FOSUserEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Listener responsible to change the redirection at the end of the password resetting
 */
class RegisterationSuccessListener implements EventSubscriberInterface
{
    private $router;

    private $em;

    public function __construct(UrlGeneratorInterface $router, EntityManager $em)
    {
        $this->router = $router;
        $this->em = $em;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            FOSUserEvents::REGISTRATION_COMPLETED => [
                ['onRegistrationCompleted', -10],
            ],
        ];
    }

    public function onRegistrationCompleted(FilterUserResponseEvent $event)
    {
        $test = $event->getRequest()->request->get('fos_user_registration_form')['test'];
        $type = $event->getRequest()->request->get('fos_user_registration_form')['type'];
        /** @var Test $testObj */
        $testObj = $this->em->getReference('App:Test', $test);
        if ($testObj->getId()) {
            /** @var User $user */
            $user = $this->em->getReference('App:User', $event->getUser()->getId());
            $symptomsStartSince = $event->getRequest()->request->get('fos_user_registration_form')['symptomsStartSince'];
            $startDate = date('Y-m-d',(strtotime ( "-{$symptomsStartSince} day" , strtotime ( date('Y-m-d')) )));
            $ymd = new \DateTime($startDate);
            $user->setSymptomsStartedAt($ymd);
            if ($type == 'isolation') {
                $user->setIsolationStartedAt(new \DateTime());
                $user->setIsolationEndAt(new \DateTime('+14 day'));
            }
            $qb = $this->em->createQueryBuilder();
            $qb->select('u')
                ->from('App:User', 'u')
                ->where($qb->expr()->like('u.roles', ':roles'))
                ->setParameter('roles', '%"ROLE_DOCTOR"%');

            $doctors = $qb->getQuery()->getResult();
            $assignedDoctor = $doctors[array_rand($doctors)];
            if (in_array('ROLE_USER', $user->getRoles(), true)) {
                if ($assignedDoctor && $type == 'isolation') {
                    $user->setAssignedDoctor($assignedDoctor);
                }
            }
            if ($testObj->getId())  {
                $user->setLocation($testObj->getLocation());
                $testObj->setUser($user);
                $this->em->persist($testObj);
            }
            $this->em->persist($user);
            $chat = new Chat();
            $chat->setPatient($user);
            $chat->setDoctor($assignedDoctor);
            $this->em->persist($chat);
            $this->em->flush();
        }
    }
}
