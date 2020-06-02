<?php

namespace App\Handler;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Router;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;

class LoginSuccessHandler implements AuthenticationSuccessHandlerInterface
{
    /** @var Router $router */
    protected $router;

    /** @var Security $security */
    protected $security;

    public function __construct(Router $router, Security $security)
    {
        $this->router = $router;
        $this->security = $security;
    }

    /**
     * Handle authentication after user login
     *
     * @param Request $request
     * @param TokenInterface $token
     * @return RedirectResponse
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        $url = 'index';
        if (!in_array('ROLE_DOCTOR', $token->getUser()->getRoles()) && sizeof($token->getUser()->getRoles()) == 1) {
            $url = 'user';
        } elseif (in_array('ROLE_DOCTOR', $token->getUser()->getRoles())) {
            $url = 'doctor';
        }
        return new RedirectResponse($this->router->generate($url));
    }
}