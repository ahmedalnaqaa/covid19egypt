<?php

// src/EventListener/ExceptionListener.php
namespace App\EventListener;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Environment;

class RequestListener
{
    /** @var EntityManager  */
    private $em;

    /* @var $twig \Twig\Environment */
    private $twig;

    public function __construct( EntityManager $em, Environment $twigEnvironment)
    {
        $this->em = $em;
        $this->twig = $twigEnvironment;
    }

    public function onKernelRequest(RequestEvent $event)
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
       if ($ip){
           $blacklisted = $this->em->getRepository('App:BlackList')->findOneByIp($ip);
           if ($blacklisted) {
               $response = new Response();

               $response->setStatusCode(Response::HTTP_FORBIDDEN);

               // Render some twig view, in our case we will render the blocked.html.twig file
               $response->setContent($this->twig->render("web/blacklisted.html.twig", [
               ]));

               // Return an HTML file
               $response->headers->set('Content-Type', 'text/html');

               // Send response
               $event->setResponse($response);
           }
       }
    }
}
