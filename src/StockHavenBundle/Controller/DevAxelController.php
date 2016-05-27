<?php

namespace StockHavenBundle\Controller;

use StockHavenBundle\Entity\currency;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DevAxelController extends Controller
{
    public function currencyAction()
    {
        $currency = new currency();
        $currency->setLongName('euro');
        $currency->setShortName('EUR');
        $currency->setSymbol('€');
        $currency1 = new currency();
        $currency1->setLongName('dollar');
        $currency1->setShortName('USD');
        $currency1->setSymbol('$');
        $currency2 = new currency();
        $currency2->setLongName('livre sterling');
        $currency2->setShortName('GBP');
        $currency2->setSymbol('£');
        $em = $this->getDoctrine()->getManager();
        $em->persist($currency);
        $em->persist($currency1);
        $em->persist($currency2);
        $em->flush();
    }
}
