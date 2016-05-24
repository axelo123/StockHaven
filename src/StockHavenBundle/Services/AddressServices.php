<?php

namespace StockHavenBundle\Services;

use StockHavenBundle\Entity\address;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\DependencyInjection\ContainerInterface;

class AddressServices
{
    protected $container;

    public function __construct(ContainerInterface $container) // this is @service_container
    {
        $this->container = $container;
        $this->doctrine = $this->container->get('doctrine');
    }

    public function format_response(address $address)
    {
        if($address)
        {
            $postal_code_services=$this->container->get('postalcode.services');
            $store_services=$this->container->get('store.services');
            $postal_code_repo=$this->doctrine->getRepository('StockHavenBundle:postalCode');
            $store_repo=$this->doctrine->getRepository('StockHavenBundle:store');
            $postal_code=$postal_code_repo->find($address->getPostalCodeId());
            $store=$store_repo->find($address->getStoreId());
            return array(
                "id"=>$address->getId(),
                "postal_code"=>$postal_code_services->format_response($postal_code),
                "store"=>$store_services->format_response($store),
                "nb_box"=>$address->getNbBox(),
                "street"=>$address->getStreet()
            );
        }
        return array();

    }
}
