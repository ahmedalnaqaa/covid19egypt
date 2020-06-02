<?php

// src/EventListener/ExceptionListener.php
namespace App\EventListener;

use App\Entity\BlackList;
use Doctrine\ORM\EntityManager;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ExceptionListener
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /** @var EntityManager  */
    private $em;

    /**
     * @param LoggerInterface $logger
     * @param EntityManager $em
     */
    public function __construct(LoggerInterface $logger, EntityManager $em)
    {
        $this->logger = $logger;
        $this->em = $em;
    }

    public function onKernelException(ExceptionEvent $event)
    {
        $ip = false;
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        if(strpos($ip,',') !== false) {
            $ip = substr($ip,0,strpos($ip,','));
        }
        if ($ip) {
            /** @var BlackList $blacklisted */
            $blacklisted = $this->em->getRepository('App:BlackList')->findOneByIp($ip);
            if ($blacklisted && $event->getThrowable()->getMessage() != 'No route found for "GET /favicon.ico"') {
                $blacklisted->setScore((1+ $blacklisted->getScore()));
                $this->em->persist($blacklisted);
                $this->em->flush();
                $this->logger->info('Existing blacklisted IP still coming back: ' . $ip);
                $this->logger->info('This ip score is: '.$blacklisted->getScore());
            } else {
                if ($event->getThrowable()->getMessage() != 'No route found for "GET /favicon.ico"') {
                    $blacklist  = new BlackList();
                    $blacklist->setIp($ip);
                    $this->em->persist($blacklist);
                    $this->em->flush();
                    $this->logger->info('New ip added to blacklist, will track it: ' . $ip);
                }}
            $this->logger->error('Error failed for IP: ' . $ip);
        }
    }
}
