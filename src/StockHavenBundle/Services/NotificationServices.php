<?php

namespace StockHavenBundle\Services;

use StockHavenBundle\Entity\notification;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\DependencyInjection\ContainerInterface;

class NotificationServices
{
    protected $container;

    public function __construct(ContainerInterface $container) // this is @service_container
    {
        $this->container = $container;
        $this->doctrine = $this->container->get('doctrine');
    }

    public function format_response(notification $notification)
    {
        if($notification)
        {
            $user_services=$this->container->get('user.services');
            $user_repo=$this->doctrine->getRepository('StockHavenBundle:user');
            $user=$user_repo->find($notification->getUserId());
            $stock_repo=$this->doctrine->getRepository('StockHavenBundle:stock');
            $stock_services=$this->container->get('stock.services');
            $stock=$stock_repo->find($notification->getStockId());
            
            return array(
                "id"=>$notification->getId(),
                "user"=>$user_services->format_response($user),
                "stock"=>$stock_services->format_response($stock),
                "is_valided"=>$notification->getIsValided(),
                "create_date"=>$notification->getCreateDate(),
                "is_view"=>$notification->getIsView()
            );
        }
        return array();

    }
}
