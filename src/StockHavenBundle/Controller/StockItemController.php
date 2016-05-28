<?php

namespace StockHavenBundle\Controller;

use StockHavenBundle\Entity\items_stocks;
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
        $items_stocks = $this->getDoctrine()->getRepository('StockHavenBundle:items_stocks')->findAll();

        return $this->render('@StockHaven/stock-item/index.html.twig',array(
            'item'=>$item,
            'stocks'=>$stocks,
            'user'=>$user,
            'items_stocks'=>$items_stocks
        ));
    }

    public function errorSelectStock($message,$item)
    {
        $stocks = $this->getDoctrine()->getRepository('StockHavenBundle:stock')->findAll();
        $user = $this->get('user.services')->format_response($this->getUser());
        $user = $this->getDoctrine()->getRepository('StockHavenBundle:user')->find($user['id']);

        return $this->render('@StockHaven/stock-item/index.html.twig',array(
            'stocks'=>$stocks,
            'user'=>$user,
            'item'=>$item,
            'error'=>$message
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
        $items_stocks_found = $this->getDoctrine()->getRepository('StockHavenBundle:items_stocks')->findOneBy(array(
            'stockId'=>$stock,
            'itemId'=>$item
        ));

        $em = $this->getDoctrine()->getManager();

        if(!$items_stocks_found)
        {
            $items_stocks = new items_stocks();

            $em->persist($items_stocks);
            $stock->addStockItem($items_stocks);
            $item->addItemsStock($items_stocks);
            $items_stocks->setQuantity(1);

        }
        else
        {
            $quantity = $items_stocks_found->getQuantity();
            $em = $this->getDoctrine()->getManager();
            $em->persist($items_stocks_found);
            $items_stocks_found->setQuantity($quantity+1);

        }

        $em->flush();

        return $this->successSelectStock($item->getName()." add in ".$stock->getName()." !!!",$item);
    }

    public function removeItemInStockAction(Request $request)
    {
        $stock = $request->query->get('stock_id');
        $item = $request->query->get('item_id');
        $stock = $this->getDoctrine()->getRepository('StockHavenBundle:stock')->find($stock);
        $item = $this->getDoctrine()->getRepository('StockHavenBundle:item')->find($item);
        $items_stocks = $this->getDoctrine()->getRepository('StockHavenBundle:items_stocks')->findOneBy(array(
            'itemId'=>$item,
            'stockId'=>$stock
        ));
        $em = $this->getDoctrine()->getManager();
        if($items_stocks && $items_stocks->getQuantity()-1 != 0 )
        {
            $em->persist($items_stocks);
            $items_stocks->setQuantity($items_stocks->getQuantity()-1);
        }
        else
        {
            $em->persist($stock);
            $stock->removeStocksItems($items_stocks);
            return $this->errorSelectStock("No Item in this Stock !!!",$item);
        }
        $em->flush();

        return $this->successSelectStock($item->getName()." remove in ".$stock->getName()." !!!",$item);
    }
}
