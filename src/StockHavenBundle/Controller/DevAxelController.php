<?php

namespace StockHavenBundle\Controller;

use StockHavenBundle\Entity\country;
use StockHavenBundle\Entity\currency;
use StockHavenBundle\Entity\type;
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

        return ("it's ok");
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

        return ("it's ok");
    }

    /**
     * classe de création de type
     */
    public function typeAction()
    {
        $type1 = new type();
        $type1->setName("Boisson");
        $type2 = new type();
        $type2->setName("Fruit");
        $type3 = new type();
        $type3->setName("Légume");
        $type4 = new type();
        $type4->setName("Pâte");
        $type5 = new type();
        $type5->setName("Riz");
        $em = $this->getDoctrine()->getManager();
        $em->persist($type1);
        $em->persist($type2);
        $em->persist($type3);
        $em->persist($type4);
        $em->persist($type5);
        $em->flush();

        return ("it's ok");
    }
}
