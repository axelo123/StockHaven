<?php

namespace StockHavenBundle\Controller;

use StockHavenBundle\Entity\barcode;
use StockHavenBundle\Entity\notification;
use StockHavenBundle\Entity\saveOperation;
use StockHavenBundle\Entity\stock;
use StockHavenBundle\Entity\item_stock;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class StockController extends Controller
{
    /**
     * page d'affichage des stocks
     * @return \Symfony\Component\HttpFoundation\Response
     */
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

    /**
     * message d'erreur
     * @param $message
     * @return \Symfony\Component\HttpFoundation\Response
     */
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

    /**
     * message de réussite
     * @param $message
     * @return \Symfony\Component\HttpFoundation\Response
     */
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

    /**
     * la vue d'édition de stock
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editViewAction(Request $request)
    {
        $stock_id = $request->query->get('id');
        $stock = $this->getDoctrine()->getRepository('StockHavenBundle:stock')->find($stock_id);
        
        return $this->render('@StockHaven/edit/index.html.twig',array(
            'stock'=>$stock
        ));
    }

    /**
     * l'action d'édition d'un stock
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request)
    {
        $stock_id = $request->query->get('stock_id');
        $stock_name = $request->query->get('name');
        $barcode_name = $request->query->get('barcode');

        $stock = $this->getDoctrine()->getRepository('StockHavenBundle:stock')->find($stock_id);

        $barcode = $this->getDoctrine()->getRepository('StockHavenBundle:barcode')->findOneBy(array(
            'barcode'=>$barcode_name
        ));

        $em = $this->getDoctrine()->getManager();

        if($stock_name != $stock->getName())
        {
            $em->persist($stock);
            $stock->setName($stock_name);
        }
        elseif ($barcode_name != $barcode->getBarcode())
        {
            $em->persist($barcode);
            $barcode->setBarcode($barcode_name);
        }
        else
        {
            return $this->stockError("Stock up to date !!!");
        }

        $em->flush();

        $operation = $this->getDoctrine()->getRepository('StockHavenBundle:operation')->findOneBy(array(
            'name'=>"UPDATE"
        ));
        $save_operation = new saveOperation();
        $em->persist($save_operation);
        $save_operation->setOperationId($operation);
        $save_operation->setElementName($stock->getName());
        $save_operation->setTypeElement("stock");
        $save_operation->setModificationDate(new \DateTime());
        $em->flush();

        return $this->stockSuccess("Stock edited !!!");
    }

    /**
     * suppréssion d'un stock
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction(Request $request)
    {
        $stock_id = $request->query->get('id');
        $stock_found = $this->getDoctrine()->getRepository('StockHavenBundle:stock')->findOneBy(array('id'=>$stock_id));
        $stockName = $stock_found->getName();
        $items_stocks = $this->getDoctrine()->getRepository('StockHavenBundle:items_stocks')->findBy(array(
            'stockId'=>$stock_found
        ));
        if($stock_found)
        {
            $em=$this->getDoctrine()->getManager();

            $barcode = $this->getDoctrine()->getRepository('StockHavenBundle:barcode')->find($stock_found->getBarcodeId());
            if($items_stocks)
            {
                foreach ($items_stocks as $item_stock)
                {
                    $em->remove($item_stock);
                }
                //$stock_found->removeItemsStock($items_stocks->getItemId());

            }
            $em->persist($stock_found);
            foreach($stock_found->getUsers() as $user)
            {
                $operation = $this->getDoctrine()->getRepository('StockHavenBundle:operation')->findOneBy(array(
                    'name'=>"DELETE"
                ));
                $save_operation = new saveOperation();
                $em->persist($save_operation);
                $save_operation->setOperationId($operation);
                $save_operation->setElementName($stock_found->getName());
                $save_operation->setTypeElement("stock");
                $save_operation->setModificationDate(new \DateTime());
                $em->flush();

                $stock_found->removeUser($user);
            }
            $em->remove($stock_found);
            $em->remove($barcode);

            $em->flush();
        }
        return $this->stockSuccess("Stock ".$stockName." deleted !!!");
    }


    /**
     * création d'un nouveau stock
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
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

        $operation = $this->getDoctrine()->getRepository('StockHavenBundle:operation')->findOneBy(array(
            'name'=>"CREATE"
        ));
        $save_operation = new saveOperation();
        $em->persist($save_operation);
        $save_operation->setOperationId($operation);
        $save_operation->setElementName($stock->getName());
        $save_operation->setTypeElement("stock");
        $save_operation->setModificationDate(new \DateTime());
        $em->flush();

        return $this->stockSuccess("Stock : ".$stock->getName()." is created !!!");
    }

    /**
     * suppréssion d'un user dans un stock
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function removeUserAction(Request $request)
    {
        $stock = $request->query->get('id');
        $user=$this->get('user.services')->format_response($this->getUser());
        $user = $this->getDoctrine()->getRepository('StockHavenBundle:user')->find($user['id']);
        $stock = $this->getDoctrine()->getRepository('StockHavenBundle:stock')->find($stock);
        $notif = $this->getDoctrine()->getRepository('StockHavenBundle:notification')->findOneBy(array(
            'stockId'=>$stock,'userId'=>$user
        ));

        $em = $this->getDoctrine()->getManager();
        $em->persist($stock);
        if($notif)
        {
            $em->remove($notif);
        }

        $stock->removeUser($user);
        $em->flush();
        return $this->stockSuccess("Access to stock ".$stock->getName()." removed !!!");
    }

    /**
     * ajout d'un user dans un stock
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addUserAction(Request $request)
    {

        try
        {
            $stock = $request->query->get('id');
            $stock = $this->getDoctrine()->getRepository('StockHavenBundle:stock')->find($stock);
            $user=$this->get('user.services')->format_response($this->getUser());
            $user = $this->getDoctrine()->getRepository('StockHavenBundle:user')->find($user['id']);
            $notif = $this->getDoctrine()->getRepository('StockHavenBundle:notification')->findOneBy(array(
                'stockId'=>$stock->getId(),'userId'=>$this->getUser()->getId()
            ));

            if(!$notif)
            {
                $notif = new notification();

                $em = $this->getDoctrine()->getManager();
                $em->persist($notif);
                $notif->setStockId($stock);

                $notif->setUserId($user);

                $notif->setCreateDate(new \DateTime());
                $notif->setIsValided(false);
                $em->flush();
            }
            else
            {
                return $this->stockError("Already send notification at owner for ".$stock->getName()." !!!");
            }
            return $this->stockSuccess("Send Notification at owner for ".$stock->getName()." !!!");
        }
        catch(Exception $ex)
        {
            return new Response($ex->getMessage());
        }

    }
}
