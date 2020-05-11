<?php

namespace App\EventListener;

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
        /** @var Test $testObj */
        $testObj = $this->em->getReference('App:Test', $test);
        /** @var User $user */
        $user = $this->em->getReference('App:User', $event->getUser()->getId());
        $symptomsStartSince = $event->getRequest()->request->get('fos_user_registration_form')['symptomsStartSince'];
        $startDate = date('Y-m-d',(strtotime ( "-{$symptomsStartSince} day" , strtotime ( date('Y-m-d')) )));
        $ymd = new \DateTime($startDate);
        $user->setSymptomsStartedAt($ymd);
        $user->setIsolationStartedAt(new \DateTime());
        $user->setIsolationEndAt(new \DateTime('+14 day'));
        if (in_array('ROLE_USER', $user->getRoles(), true)) {
            $dql = "SELECT users.assigned_doctor, COUNT(*) AS times FROM users WHERE users.roles LIKE '%ROLE_DOCTOR%' GROUP BY users.assigned_doctor ORDER BY times ASC LIMIT 1";
            $statement = $this->em->getConnection()->prepare($dql);
            $statement->execute();
            $result = $statement->fetchAll();
            if (!empty($result)) {
                $assignedDoctor = $this->em->getReference('App:User', $result[0]['assigned_doctor']);
                $user->setAssignedDoctor($assignedDoctor);
            }
        }
        if ($testObj->getId())  {
            $user->setLocation($testObj->getLocation());
            $testObj->setUser($user);
            $this->em->persist($testObj);
        }
        $this->em->persist($user);
        $this->em->flush();
    }
}
