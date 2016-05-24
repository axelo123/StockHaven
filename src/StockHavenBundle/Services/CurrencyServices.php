<?php

namespace StockHavenBundle\Services;

use StockHavenBundle\Entity\currency;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\DependencyInjection\ContainerInterface;
class CurrencyServices
{
    protected $container;

    public function __construct(ContainerInterface $container) // this is @service_container
    {
        $this->container = $container;
    }

    public function format_response(currency $currency)
    {
        if($currency)
        {
            return array(
                "id"=>$currency->getId(),
                "long_name"=>$currency->getLongName(),
                "short_name"=>$currency->getShortName(),
                "symbol"=>$currency->getSymbol()
            );
        }
        return array();

    }
}
