<?php

namespace StockHavenBundle\Controller;

use StockHavenBundle\Entity\barcode;
use StockHavenBundle\Entity\stock;
use StockHavenBundle\Entity\item_stock;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class StockController extends Controller
{
    public function stockAction()
    {
        $stocks=$this->getDoctrine()->getRepository('StockHavenBundle:stock')->findAll();
        $nb_stocks = count($stocks);
        $user = $this->get('user.services')->format_response($this->getUser());
        $user = $this->getDoctrine()->getRepository('StockHavenBundle:user')->find($user['id']);
        $nb_item=null;

        $nb_item_in_stock= array();
        return $this->render('StockHavenBundle:site-part/stock:index.html.twig',array(
            'stocks'=>$stocks,
            'nb_stocks'=>$nb_stocks,
            'user'=>$user,
            'nb_item_in_stock'=>$nb_item_in_stock
        ));
    }

    public function stockError($message)
    {
        $stocks=$this->getDoctrine()->getRepository('StockHavenBundle:stock')->findAll();
        $nb_stocks = count($stocks);
        $user = $this->get('user.services')->format_response($this->getUser());
        $user = $this->getDoctrine()->getRepository('StockHavenBundle:user')->find($user['id']);

        return $this->render('StockHavenBundle:site-part/stock:index.html.twig',array(
            'error'=>$message,
            'stocks'=>$stocks,
            'nb_stocks'=>$nb_stocks,
            'user'=>$user
        ));
    }

    public function stockSuccess($message)
    {
        $stocks=$this->getDoctrine()->getRepository('StockHavenBundle:stock')->findAll();
        $nb_stocks = count($stocks);
        $user = $this->get('user.services')->format_response($this->getUser());
        $user = $this->getDoctrine()->getRepository('StockHavenBundle:user')->find($user['id']);
        return $this->render('StockHavenBundle:site-part/stock:index.html.twig',array(
            'success'=>$message,
            'stocks'=>$stocks,
            'nb_stocks'=>$nb_stocks,
            'user'=>$user,
        ));
    }


    public function deleteAction(Request $request)
    {
        $stock_id = $request->query->get('id');
        $stock_found = $this->getDoctrine()->getRepository('StockHavenBundle:stock')->findOneBy(array('id'=>$stock_id));
        if($stock_found)
        {
            $barcode = $this->getDoctrine()->getRepository('StockHavenBundle:barcode')->find($stock_found->getBarcodeId());
            $em=$this->getDoctrine()->getManager();
            $em->remove($stock_found);
            $em->remove($barcode);
            $em->flush();
        }
        return $this->stockSuccess("Stock deleted !!!");
    }

    
    public function createAction(Request $request)
    {
        $name = $request->query->get('name');

        $barcode = $request->query->get('barcode');
        $user=$this->getUser();

        $barcode_repo = $this->getDoctrine()->getRepository('StockHavenBundle:barcode');
        $barcode_found = $barcode_repo->findOneBy(array(
            'barcode'=>$barcode
        ));
        if($barcode_found)
        {
            return $this->stockError("Barcode already exist !!!");
        }else
        {
            $barcod = new barcode();
            $em = $this->getDoctrine()->getManager();
            $em->persist($barcod);
            $barcod->setBarcode($barcode);
        }

        $stock = new stock();
        $em = $this->getDoctrine()->getManager();
        $em->persist($stock);
        $stock->setName($name);
        $stock->setBarcodeId($barcod);
        $stock->setUserCreatorId($user);
        $stock->addUser($user);
        $em->flush();
        return $this->stockSuccess("Stock Create !!!");
    }

    public function removeUserAction(Request $request)
    {
        $stock = $request->query->get('id');
        $user=$this->get('user.services')->format_response($this->getUser());
        $user = $this->getDoctrine()->getRepository('StockHavenBundle:user')->find($user['id']);
        $stock = $this->getDoctrine()->getRepository('StockHavenBundle:stock')->find($stock);

        $em = $this->getDoctrine()->getManager();
        $em->persist($stock);
        $stock->removeUser($user);
        $em->flush();
        return $this->stockSuccess("Access to stock ".$stock->getName()." removed !!!");
    }

    public function addUserAction(Request $request)
    {
        $stock = $request->query->get('id');
        $user=$this->get('user.services')->format_response($this->getUser());
        $user = $this->getDoctrine()->getRepository('StockHavenBundle:user')->find($user['id']);
        $stock = $this->getDoctrine()->getRepository('StockHavenBundle:stock')->find($stock);

        $em = $this->getDoctrine()->getManager();
        $em->persist($stock);
        $stock->addUser($user);
        $em->flush();
        return $this->stockSuccess("Access to stock ".$stock->getName()." granted !!!");
    }
}
