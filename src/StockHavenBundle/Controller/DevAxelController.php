<?php

namespace StockHavenBundle\Controller;

use StockHavenBundle\Entity\country;
use StockHavenBundle\Entity\currency;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DevAxelController extends Controller
{
    /**
     * classe de création currency
     */
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

    /**
     * classe de création country
     */
    public function countryAction()
    {
        $country1 = new country();
        $country1->setName('Belgique');
        $country1->setShortName('BE');
        $country2 = new country();
        $country2->setName('France');
        $country2->setShortName('FR');
        $country3 = new country();
        $country3->setName('États-Unis');
        $country3->setShortName('US');
        $country4 = new country();
        $country4->setName('Royaume-Uni');
        $country4->setShortName('UK');
        $em = $this->getDoctrine()->getManager();
        $em->persist($country1);
        $em->persist($country2);
        $em->persist($country3);
        $em->persist($country4);
        $em->flush();
    }
}
