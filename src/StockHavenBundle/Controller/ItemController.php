<?php

namespace StockHavenBundle\Controller;

use StockHavenBundle\Entity\barcode;
use StockHavenBundle\Entity\item;
use StockHavenBundle\Entity\stock;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class ItemController extends Controller
{
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

    public function deleteAction(Request $request)
    {
        $item_id = $request->query->get('id');
        $item_found = $this->getDoctrine()->getRepository('StockHavenBundle:stock')->findOneBy(array('id'=>$item_id));
        if($item_found)
        {
            $barcode = $this->getDoctrine()->getRepository('StockHavenBundle:barcode')->find($item_found->getBarcodeId());
            $em=$this->getDoctrine()->getManager();
            $em->remove($item_found);
            $em->remove($barcode);
            $em->flush();
        }
        else
        {
            return $this->itemError("Item not found !!!");
        }
        return $this->itemSuccess("Item deleted !!!");
    }
    
    public function createAction(Request $request)
    {
        $name = $request->query->get('name');
        $price = $request->query->get('price');
        $currency = $request->query->get('currency');
        $description = $request->query->get('description');
        $barcode = $request->query->get('barcode');
        $type = $request->query->get('type');
        $store = $request->query->get('store');
        $store = $this->getDoctrine()->getRepository('StockHavenBundle:store')->findOneBy(array('name'=>$store));
        //$dateExpire = $request->query->get('dateExpire');


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
