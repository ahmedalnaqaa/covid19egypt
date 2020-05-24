<?php

namespace App\Doctrine;

use App\Entity\Cases;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\EntityManager;

class CasesEntityListener
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * DoctrineUserListener constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param LifecycleEventArgs $args
     * @return bool
     * @throws \Doctrine\ORM\ORMException
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        /** @var Cases $entity */
        $entity = $args->getEntity();
        if ($entity instanceof Cases) {
            /** @var Cases $lastCase */
            $lastCase = $this->em->getRepository('App:Cases')->findOneBy([],['id' => 'DESC']);
            $entity->setNewDailyRecovered(($entity->getTotalRecovered() - $lastCase->getTotalRecovered()));
            $entity->setNewDailyPoToNe(($entity->getTotalPoToNe() - $lastCase->getTotalPoToNe()));

            return true;
        }
        return true;
    }
}