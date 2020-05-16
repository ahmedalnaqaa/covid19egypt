<?php

// src/EventListener/ExceptionListener.php
namespace App\EventListener;

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

    /**
     * @var RequestStack
     */
    private $request;

    /**
     * @param LoggerInterface $logger
     * @param RequestStack $request
     */
    public function __construct(LoggerInterface $logger, RequestStack $request)
    {
        $this->logger = $logger;
        $this->request = $request;
    }

    public function onKernelException(ExceptionEvent $event)
    {
        $ipAddress = $this->request->getCurrentRequest()->getClientIp();
        $this->logger->error('Error failed for IP: ' . $ipAddress);
    }
}
