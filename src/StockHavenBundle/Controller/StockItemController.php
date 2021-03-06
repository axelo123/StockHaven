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
            'user'=>$user
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
            $stock->addStocksItems($items_stocks);
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
        if($items_stocks && $items_stocks->getQuantity() > 1 )
        {
            $em->persist($items_stocks);
            $items_stocks->setQuantity($items_stocks->getQuantity()-1);
        }
        elseif($items_stocks)
        {
            $em->persist($items_stocks);
            $items_stocks->setQuantity(0);
            $stock->removeStocksItems($items_stocks);
            $item->removeItemsStock($items_stocks);
            $em->remove($items_stocks);
            $em->flush();

            return $this->errorSelectStock("No ".$item->getName()." in this Stock now !!!",$item);
        }
        elseif (!$items_stocks)
        {
            return $this->errorSelectStock("No ".$item->getName()." in this Stock !!!",$item);
        }
        $em->flush();

        return $this->successSelectStock($item->getName()." remove in ".$stock->getName()." !!!",$item);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function removeStockInItemsAction(Request $request)
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
        if($items_stocks && $items_stocks->getQuantity() > 1 )
        {
            $em->persist($items_stocks);
            $items_stocks->setQuantity($items_stocks->getQuantity()-1);
        }
        elseif($items_stocks)
        {
            $em->persist($items_stocks);
            $items_stocks->setQuantity(0);
            $stock->removeStocksItems($items_stocks);
            $item->removeItemsStock($items_stocks);
            $em->remove($items_stocks);
            $em->flush();

            return $this->errorSelectItem("No ".$item->getName()." in this Stock now !!!",$stock);
        }
        elseif (!$items_stocks)
        {
            return $this->errorSelectItem("No ".$item->getName()." in this Stock !!!",$stock);
        }
        $em->flush();

        return $this->successSelectItem($item->getName()." remove in ".$stock->getName()." !!!",$stock);
    }

    /**
     * Vue avec message d'erreur pour un stock
     * @param $message
     * @param $stock
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function errorSelectItem($message,$stock)
    {
        $items = $this->getDoctrine()->getRepository('StockHavenBundle:item')->findAll();
        $user = $this->get('user.services')->format_response($this->getUser());
        $user = $this->getDoctrine()->getRepository('StockHavenBundle:user')->find($user['id']);

        return $this->render('@StockHaven/viewOneStock/index.html.twig',array(
            'stock'=>$stock,
            'user'=>$user,
            'items'=>$items,
            'error'=>$message
        ));
    }

    /**
     * @param $message
     * @param $stock
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function successSelectItem($message,$stock)
    {
        $items = $this->getDoctrine()->getRepository('StockHavenBundle:item')->findAll();
        $user = $this->get('user.services')->format_response($this->getUser());
        $user = $this->getDoctrine()->getRepository('StockHavenBundle:user')->find($user['id']);

        return $this->render('@StockHaven/viewOneStock/index.html.twig',array(
            'stock'=>$stock,
            'user'=>$user,
            'items'=>$items,
            'success'=>$message
        ));
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addStockInItemAction(Request $request)
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
            $stock->addStocksItems($items_stocks);
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

        return $this->successSelectItem($item->getName()." add in ".$stock->getName()." !!!",$stock);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addStockAction(Request $request)
    {
        $stock_id = $request->query->get('id');
        $stock = $this->getDoctrine()->getRepository('StockHavenBundle:stock')->find($stock_id);
        $items = $this->getDoctrine()->getRepository('StockHavenBundle:item')->findAll();
        $user = $this->get('user.services')->format_response($this->getUser());
        $user = $this->getDoctrine()->getRepository('StockHavenBundle:user')->find($user['id']);
        $items_stocks = $this->getDoctrine()->getRepository('StockHavenBundle:items_stocks')->findAll();

        return $this->render('@StockHaven/viewOneStock/index.html.twig',array(
            'items'=>$items,
            'stock'=>$stock,
            'user'=>$user
        ));
    }
}
