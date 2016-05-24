<?php

namespace StockHavenBundle\Services;

use StockHavenBundle\Entity\item;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ItemServices
{
    protected $container;

    public function __construct(ContainerInterface $container) // this is @service_container
    {
        $this->container = $container;
        $this->doctrine = $this->container->get('doctrine');
    }

    public function format_response(item $item)
    {
        if($item)
        {
            $barcode_services = $this->container->get('barcode.services');
            $currency_services = $this->container->get('currency.services');
            $type_services = $this->container->get('type.services');
            $type_repo=$this->doctrine->getRepository('StockHavenBundle:type');
            $type=$type_repo->find($item->getTypeId());
            $currency_repo=$this->doctrine->getRepository('StockHavenBundle:currency');
            $barcode_repo=$this->doctrine->getRepository('StockHavenBundle:barcode');
            $currency=$currency_repo->find($item->getCurrencyId());
            $barcode=$barcode_repo->find($item->getBarcodeId());
            return array(
                "id"=>$item->getId(),
                "name"=>$item->getName(),
                "type_id"=>$type_services->format_response($type),
                "quantity"=>$item->getQuantity(),
                "is_delete"=>$item->getIsDelete(),
                "count_update"=>$item->getCountUpdate(),
                "currency_id"=>$currency_services->format_response($currency),
                "price"=>$item->getPrice(),
                "description"=>$item->getDescription(),
                "barcode_id"=>$barcode_services->format_response($barcode)
            );
        }
        return array();

    }
}
