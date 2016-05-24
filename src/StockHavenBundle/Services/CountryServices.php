<?php

namespace StockHavenBundle\Services;

use StockHavenBundle\Entity\country;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\DependencyInjection\ContainerInterface;

class CountryServices
{
    protected $container;

    public function __construct(ContainerInterface $container) // this is @service_container
    {
        $this->container = $container;
    }

    public function format_response(country $country)
    {
        if($country)
        {
            return array(
                "id"=>$country->getId(),
                "name"=>$country->getName(),
                "shortname"=>$country->getShortName()
            );
        }
        return array();

    }
}
