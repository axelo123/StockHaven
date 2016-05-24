<?php

namespace StockHavenBundle\Services;

use StockHavenBundle\Entity\saveOperation;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\DependencyInjection\ContainerInterface;

class SaveOperationServices
{
    protected $container;

    public function __construct(ContainerInterface $container) // this is @service_container
    {
        $this->container = $container;
        $this->doctrine = $this->container->get('doctrine');
    }

    public function format_response(saveOperation $save_operation)
    {
        if($save_operation)
        {
            $stock_services = $this->container->get('stock.services');
            $operation_services = $this->container->get('operation.services');
            $user_services = $this->container->get('user.services');
            $item_services = $this->container->get('item.services');
            $stock_repo=$this->doctrine->getRepository('StockHavenBundle:stock');
            $operation_repo=$this->doctrine->getRepository('StockHavenBundle:operation');
            $item_repo=$this->doctrine->getRepository('StockHavenBundle:item');
            $item=$item_repo->find($save_operation->getItemId());
            $operation=$operation_repo->find($save_operation->getOperationId());
            $stock=$stock_repo->find($save_operation->getStockId());
            return array(
                "id"=>$save_operation->getId(),
                "stock_id"=>$stock_services->format_response($stock),
                "operation_id"=>$operation_services->format_response($operation),
                "modification_date"=>$save_operation->getModificationDate(),
                "item_id"=>$item_services->format_response($item)
            );
        }
        return array();

    }
}
