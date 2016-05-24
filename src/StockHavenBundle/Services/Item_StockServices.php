<?php

namespace StockHavenBundle\Services;

use StockHavenBundle\Entity\item_stock;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\DependencyInjection\ContainerInterface;

class Item_StockServices
{
    protected $container;

    public function __construct(ContainerInterface $container) // this is @service_container
    {
        $this->container = $container;
        $this->doctrine = $this->container->get('doctrine');
    }

    public function format_response(item_stock $item_stock)
    {
        if($item_stock)
        {
            $item_services=$this->container->get('item.services');
            $stock_services=$this->container->get('stock.services');
            $item_repo=$this->doctrine->getRepository('StockHavenBundle:item');
            $stock_repo=$this->doctrine->getRepository('StockHavenBundle:stock');
            $item=$item_repo->find($item_stock->getItemId());
            $stock=$stock_repo->find($item_stock->getStockId());
            return array(
                "id"=>$item_stock->getId(),
                "item"=>$item_services->format_response($item),
                "stock"=>$stock_services->format_response($stock),
                "quantity"=>$item_stock->getQuantity()
            );
        }
        return array();

    }
}
