<?php

namespace StockHavenBundle\Services;

use StockHavenBundle\Entity\store;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\DependencyInjection\ContainerInterface;

class StoreServices
{
    protected $container;

    public function __construct(ContainerInterface $container) // this is @service_container
    {
        $this->container = $container;
    }

    public function format_response(store $store)
    {
        if($store)
        {
            return array(
                "id"=>$store->getId(),
                "name"=>$store->getName(),
                "picture"=>$store->getPicture()
            );
        }
        return array();

    }
}
