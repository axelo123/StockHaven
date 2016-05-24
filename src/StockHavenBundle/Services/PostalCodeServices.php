<?php

namespace StockHavenBundle\Services;

use StockHavenBundle\Entity\postalCode;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\DependencyInjection\ContainerInterface;

class PostalCodeServices
{
    protected $container;

    public function __construct(ContainerInterface $container) // this is @service_container
    {
        $this->container = $container;
        $this->doctrine = $this->container->get('doctrine');
    }

    public function format_response(postalCode $postalCode)
    {
        if($postalCode)
        {
            $country_services=$this->container->get('country.services');
            $country_repo=$this->doctrine->getRepository('StockHavenBundle:country');
            $country=$country_repo->find($postalCode->getCountryId());
            
            return array(
                "id"=>$postalCode->getId(),
                "country"=>$country_services->format_response($country),
                "code"=>$postalCode->getCode(),
                "region"=>$postalCode->getRegion()
            );
        }
        return array();

    }
}
