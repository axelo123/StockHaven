<?php

/**
 * Created by PhpStorm.
 * User:
 * Date: 07/03/2016
 * Time: 14:06
 */

namespace StockHavenBundle\Services;

use StockHavenBundle\Entity\user;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\DependencyInjection\ContainerInterface;

class UserServices
{
    protected $container;

    public function __construct(ContainerInterface $container) // this is @service_container
    {
        $this->container = $container;
    }

    public function format_response($user)
    {
            return array(
                "name"=>$user->getName(),
                "password"=>$user->getPassword(),
                "token"=>$user->getToken(),
                "id"=>$user->getId(),
                "fullName"=>$user->getFullName(),
                "isSuperUser"=>$user->getIsSuperUser()
            );
    }
}
