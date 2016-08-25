<?php

namespace StockHavenBundle\Controller;

use StockHavenBundle\Entity\barcode;
use StockHavenBundle\Entity\item;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class ItemController extends Controller
{
    /**
     * affichage des items
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function itemAction()
    {
        $stores = $this->getDoctrine()->getRepository('StockHavenBundle:store')->findAll();
        $currency = $this->getDoctrine()->getRepository('StockHavenBundle:currency')->findAll();
        $items = $this->getDoctrine()->getRepository('StockHavenBundle:item')->findAll();
        $user = $this->get('user.services')->format_response($this->getUser());
        $user = $this->getDoctrine()->getRepository('StockHavenBundle:user')->find($user['id']);
        $types = $this->getDoctrine()->getRepository('StockHavenBundle:type')->findAll();
        return $this->render('StockHavenBundle:site-part/item:index.html.twig',array(
            'currency'=>$currency,
            'types'=>$types,
            'items'=>$items,
            'user'=>$user,
            'stores'=>$stores
        ));
    }

    /**
     * edition d'un item la (vue)
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editViewAction(Request $request)
    {
        $item_id = $request->query->get('id');
        $item = $this->getDoctrine()->getRepository('StockHavenBundle:item')->find($item_id);
        $stores = $this->getDoctrine()->getRepository('StockHavenBundle:store')->findAll();
        $currency = $this->getDoctrine()->getRepository('StockHavenBundle:currency')->findAll();
        $types = $this->getDoctrine()->getRepository('StockHavenBundle:type')->findAll();

        return $this->render('@StockHaven/edit/index.html.twig',array(
            'item'=>$item,
            'stores'=>$stores,
            'currency'=>$currency,
            'types'=>$types
        ));
    }

    /**
     * récupération de l'édition
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request)
    {
        $item_id = $request->query->get('item_id');
        $item_name = $request->query->get('name');
        $item_price = $request->query->get('price');
        if($item_price<0)
        {
            return $this->itemError("Price not valided !!!");
        }
        $item_currency = $request->query->get('currency');
        $item_description = $request->query->get('description');
        $item_type = $request->query->get('type');
        $item_barcode = $request->query->get('barcode');

        $item = $this->getDoctrine()->getRepository('StockHavenBundle:item')->find($item_id);

        $barcode = $this->getDoctrine()->getRepository('StockHavenBundle:barcode')->findOneBy(array(
            'barcode'=>$item_barcode
        ));
        $currency_tab = explode(" ",$item_currency);
        $currency = $this->getDoctrine()->getRepository('StockHavenBundle:currency')->findOneBy(array(
            'longName'=>$currency_tab[0]
            ));
        $type = $this->getDoctrine()->getRepository('StockHavenBundle:type')->findOneBy(array(
            'name'=>$item_type
        ));

        $em = $this->getDoctrine()->getManager();

        if($item_name != $item->getName() || $item_description != $item->getDescription() ||
            $item_price != $item->getPrice() || $item_barcode != $item->getBarcodeId()->getBarcode() ||
            $item_type != $item->getTypeId()->getName())
        {
            $em->persist($item);
            if($item_name != $item->getName())
            {
                $item->setName($item_name);
            }
            if($item_description != $item->getDescription())
            {
                $item->setDescription($item_description);
            }
            if($item_price != $item->getPrice())
            {
                $item->setPrice($item_price);
            }
            if($item_barcode != $item->getBarcodeId()->getBarcode())
            {
                $em->persist($barcode);
                $barcode->setBarcode($item_barcode);
            }
            if($item_type != $item->getTypeId()->getName())
            {
                $em->persist($type);
                $type->setName($item_type);
            }
            if($currency_tab[0] != $item->getCurrencyId()->getLongName())
            {
                $em->persist($currency);
                $currency->setLongName($currency_tab[0]);
                $currency->setShortName($currency_tab[1]);
                $currency->setSymbol($currency_tab[2]);
            }
        }
        else
        {
            return $this->itemError("Item up to date !!!");
        }

        $em->flush();

        return $this->itemSuccess("Item edited !!!");
    }

    /**
     * Message d'erreur
     *
     * @param $message
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function itemError($message)
    {
        $stores = $this->getDoctrine()->getRepository('StockHavenBundle:store')->findAll();
        $user = $this->get('user.services')->format_response($this->getUser());
        $user = $this->getDoctrine()->getRepository('StockHavenBundle:user')->find($user['id']);
        $items = $this->getDoctrine()->getRepository('StockHavenBundle:item')->findAll();
        $currency = $this->getDoctrine()->getRepository('StockHavenBundle:currency')->findAll();
        $types = $this->getDoctrine()->getRepository('StockHavenBundle:type')->findAll();
        return $this->render('StockHavenBundle:site-part/item:index.html.twig',array(
            'error'=>$message,
            'currency'=>$currency,
            'types'=>$types,
            'items'=>$items,
            'user'=>$user,
            'stores'=>$stores
        ));
    }

    /**
     * message de réussite
     *
     * @param $message
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function itemSuccess($message)
    {
        $stores = $this->getDoctrine()->getRepository('StockHavenBundle:store')->findAll();
        $user = $this->get('user.services')->format_response($this->getUser());
        $user = $this->getDoctrine()->getRepository('StockHavenBundle:user')->find($user['id']);
        $items = $this->getDoctrine()->getRepository('StockHavenBundle:item')->findAll();
        $currency = $this->getDoctrine()->getRepository('StockHavenBundle:currency')->findAll();
        $types = $this->getDoctrine()->getRepository('StockHavenBundle:type')->findAll();
        return $this->render('StockHavenBundle:site-part/item:index.html.twig',array(
            'success'=>$message,
            'currency'=>$currency,
            'types'=>$types,
            'items'=>$items,
            'user'=>$user,
            'stores'=>$stores
        ));
    }

    /**
     * suppréssion d'un item
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction(Request $request)
    {
        $item_id = $request->query->get('id');
        $item_found = $this->getDoctrine()->getRepository('StockHavenBundle:item')->findOneBy(array('id'=>$item_id));
        $items_stocks = $this->getDoctrine()->getRepository('StockHavenBundle:items_stocks')->findOneBy(array(
            'itemId'=>$item_found
        ));
        if($item_found and !$items_stocks)
        {
            $barcode = $this->getDoctrine()->getRepository('StockHavenBundle:barcode')->find($item_found->getBarcodeId());
            $em=$this->getDoctrine()->getManager();
            $em->persist($item_found);
            $em->remove($barcode);
            $em->remove($item_found);

            $em->flush();
        }
        else
        {
            return $this->itemError($item_found->getName()." is stored in a Stock !!!");
        }
        return $this->itemSuccess("Item deleted !!!");
    }

    /**
     * création d'un item
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {
        $name = $request->query->get('name');
        $price = $request->query->get('price');
        if($price<0)
        {
            return $this->itemError("Price not valided !!!");
        }
        $currency = $request->query->get('currency');
        $description = $request->query->get('description');
        $barcode = $request->query->get('barcode');
        $type = $request->query->get('type');
        $store = $request->query->get('store');
        $store = $this->getDoctrine()->getRepository('StockHavenBundle:store')->findOneBy(array('name'=>$store));


        $barcode_repo = $this->getDoctrine()->getRepository('StockHavenBundle:barcode');
        $barcode_found = $barcode_repo->findOneBy(array(
        'barcode'=>$barcode
    ));
        if($barcode_found)
        {
            return $this->itemError("Barcode already exist !!!");
        }else
        {
            $barcod = new barcode();
            $em = $this->getDoctrine()->getManager();
            $em->persist($barcod);
            $barcod->setBarcode($barcode);
        }

        $currency_tab = explode(" ",$currency);
        $currency_repo = $this->getDoctrine()->getRepository('StockHavenBundle:currency');
        $currency = $currency_repo->findOneBy(array(
            'longName'=>$currency_tab[0]
        ));

        $type_repo = $this->getDoctrine()->getRepository('StockHavenBundle:type');
        $type = $type_repo->findOneBy(array(
            'name'=>$type
        ));

        $item = new item();
        $em = $this->getDoctrine()->getManager();
        $em->persist($item);
        $item->setName($name);
        $item->setBarcodeId($barcod);
        $item->setPrice($price);
        $item->setCurrencyId($currency);
        $item->setDescription($description);
        $item->setTypeId($type);
        $item->addStore($store);
        $em->flush();
        return $this->itemSuccess("Success");
    }
}
