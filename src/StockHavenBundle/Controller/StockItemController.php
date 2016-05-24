<?php

namespace StockHavenBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class StockItemController extends Controller
{
    public function addItemAction(Request $request)
    {
        $item = $request->query->get('id');
        $item = $this->getDoctrine()->getRepository('StockHavenBundle:item')->find($item);
        $stocks = $this->getDoctrine()->getRepository('StockHavenBundle:stock')->findAll();
        $user = $this->get('user.services')->format_response($this->getUser());
        $user = $this->getDoctrine()->getRepository('StockHavenBundle:user')->find($user['id']);

        return $this->render('@StockHaven/stock-item/index.html.twig',array(
            'item'=>$item,
            'stocks'=>$stocks,
            'user'=>$user
        ));
    }

    public function successSelectStock($message,$item)
    {
        $stocks = $this->getDoctrine()->getRepository('StockHavenBundle:stock')->findAll();
        $user = $this->get('user.services')->format_response($this->getUser());
        $user = $this->getDoctrine()->getRepository('StockHavenBundle:user')->find($user['id']);

        return $this->render('@StockHaven/stock-item/index.html.twig',array(
            'stocks'=>$stocks,
            'user'=>$user,
            'item'=>$item,
            'success'=>$message
        ));
    }

    public function addItemInStockAction(Request $request)
    {
        $stock = $request->query->get('stock_id');
        $item = $request->query->get('item_id');
        $stock = $this->getDoctrine()->getRepository('StockHavenBundle:stock')->find($stock);
        $item = $this->getDoctrine()->getRepository('StockHavenBundle:item')->find($item);

        $em = $this->getDoctrine()->getManager();
        $em->persist($stock);
        $stock->addItems($item);
        $em->flush();

        return $this->successSelectStock($item->getName()." add in ".$stock->getName()." !!!",$item);
    }

    public function removeItemInStockAction(Request $request)
    {
        $stock = $request->query->get('stock_id');
        $item = $request->query->get('item_id');
        $stock = $this->getDoctrine()->getRepository('StockHavenBundle:stock')->find($stock);
        $item = $this->getDoctrine()->getRepository('StockHavenBundle:item')->find($item);

        $em = $this->getDoctrine()->getManager();
        $em->persist($stock);
        $stock->removeItems($item);
        $em->flush();

        return $this->successSelectStock($item->getName()." remove in ".$stock->getName()." !!!",$item);
    }
}
