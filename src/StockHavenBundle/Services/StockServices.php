<?php

namespace StockHavenBundle\Services;

use StockHavenBundle\Entity\stock;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\DependencyInjection\ContainerInterface;

class StockServices
{
    protected $container;

    public function __construct(ContainerInterface $container) // this is @service_container
    {
        $this->container = $container;
        $this->doctrine = $this->container->get('doctrine');
    }

    public function format_response(stock $stock)
    {
        if($stock)
        {
            $user_services = $this->container->get('user.services');
            $barcode_services = $this->container->get('barcode.services');
            $user_repo=$this->doctrine->getRepository('StockHavenBundle:user');
            $barcode_repo=$this->doctrine->getRepository('StockHavenBundle:barcode');
            $user=$user_repo->find($stock->getUserCreatorId());
            $barcode=$barcode_repo->find($stock->getBarcodeId());
            return array(
                "id"=>$stock->getId(),
                "name"=>$stock->getName(),
                "user_creator_id"=>$user_services->format_response($user),
                "is_delete"=>$stock->getIsDelete(),
                "barcode_id"=>$barcode_services->format_response($barcode)
            );
        }
        return array();

    }
}
