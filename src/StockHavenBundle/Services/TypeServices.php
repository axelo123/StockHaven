<?php

namespace StockHavenBundle\Services;

use StockHavenBundle\Entity\type;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\DependencyInjection\ContainerInterface;

class TypeServices
{
    protected $container;

    public function __construct(ContainerInterface $container) // this is @service_container
    {
        $this->container = $container;
    }

    public function format_response(type $type)
    {
        if($type)
        {
            return array(
                "id"=>$type->getId(),
                "name"=>$type->getName(),
                "expire_date"=>$type->getExpireDate(),
                "add_date"=>$type->getAddDate()
            );
        }
        return array();

    }
}
