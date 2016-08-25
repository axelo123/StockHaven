<?php

namespace StockHavenBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;


class NotificationController extends Controller
{
    public function notifAction()
    {

        $result=$this->getDoctrine()->getRepository('StockHavenBundle:notification')->getNotif($this->getUser()->getId());
        try
        {
            return $this->render('StockHavenBundle:site-part/notification:index.html.twig',array(
                'notifs'=>$result
            ));
        }
        catch(Exception $ex)
        {
            return new Response($ex->getMessage());
        }
    }

    public function addUserAction(Request $request)
    {
        $notif = $request->query->get('id');
        $notif = $this->getDoctrine()->getRepository('StockHavenBundle:notification')->find($notif);
        $em = $this->getDoctrine()->getManager();
        $done = false;
        if($notif)
        {
            $em->persist($notif);
            $notif->setIsValided(true);
            $em->flush();
            $done = true;

            $stock=$notif->getStockId();
            $user=$notif->getUserId();

            $em = $this->getDoctrine()->getManager();
            $em->persist($stock);
            $stock->addUser($user);
            $em->flush();
        }





        return new JsonResponse(array('success'=>$done));
    }
}
