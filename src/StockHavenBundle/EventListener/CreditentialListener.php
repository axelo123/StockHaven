<?php

/**
 * Created by PhpStorm.
 * User:
 * Date: 07/03/2016
 * Time: 14:06
 */

namespace StockHavenBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Authentication\Token\AnonymousToken;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class CreditentialListener
{
    protected $container;

    public function __construct(ContainerInterface $container) // this is @service_container
    {
        $this->container = $container;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        $request   = $event->getRequest();

       $token = $request->headers->get('token');

        if($token) {

            $repository = $this->container->get('doctrine')->getRepository('StockHavenBundle:user');

            $user = $repository->findOneBy(array('token' => $token));
            if($user)
            {
                // log in valid user
                $this->container->get('security.context')->setToken(
                    new UsernamePasswordToken($user->getName(),$user->getPassword(), 'main' ,array('ROLE_USER')) );
                //$this->container->get('security.context')->setToken(new AnonymousToken(null, 'viktor', array('ROLE_USER')));
                return;
            }
        }
        // Login as anonymous user
        $this->container->get('security.context')->setToken(new AnonymousToken(null, 'anonymous', array('IS_AUTHENTICATED_ANONYMOUSLY')));
    }
}