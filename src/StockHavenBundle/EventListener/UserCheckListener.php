<?php

namespace StockHavenBundle\EventListener;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Security\Core\Authentication\Token\AnonymousToken;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class UserCheckListener
{
    protected $container;

    public function __construct(ContainerInterface $container) // this is @service_container
    {
        $this->container = $container;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        $token_cookies = $event->getRequest()->cookies->get("token");
        $token_headers = $event->getRequest()->headers->get("token");

        if($token_cookies or $token_headers)
        {
            $token = $token_cookies!= null?$token_cookies:$token_headers;
            $user = $this->user_by_token($token);
            if($user)
            {
                $token_user = new UsernamePasswordToken($user, null, 'main', array('ROLE_USER'));
                $this->container->get("security.context")->setToken($token_user);
                return;
            }
        }
        $token_user = new AnonymousToken(null,'ANONYMOUS', array('IS_AUTHENTICATED_ANONYMOUSLY'));
        $this->container->get("security.context")->setToken($token_user);
        return;
    }

    private function user_by_token($token)
    {
        return $this->container->get("doctrine")->getRepository("StockHavenBundle:user")
            ->findOneBy(array("token"=>$token));
    }
}
