<?php

namespace StockHavenBundle\Controller;


use StockHavenBundle\Entity\stock;
use StockHavenBundle\Entity\store;
use StockHavenBundle\Entity\type;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TypeController extends Controller
{
    public function typeAction()
    {
        $types = $this->getDoctrine()->getRepository('StockHavenBundle:type')->findAll();
        $user = $this->get('user.services')->format_response($this->getUser());
        $user = $this->getDoctrine()->getRepository('StockHavenBundle:user')->find($user['id']);
        return $this->render('StockHavenBundle:site-part/type:index.html.twig',array(
            'types'=>$types,
            'user'=>$user
        ));
    }

    public function typeError($message)
    {
        $types = $this->getDoctrine()->getRepository('StockHavenBundle:type')->findAll();
        $user = $this->get('user.services')->format_response($this->getUser());
        $user = $this->getDoctrine()->getRepository('StockHavenBundle:user')->find($user['id']);
        return $this->render('StockHavenBundle:site-part/type:index.html.twig',array(
            'error'=>$message,
            'types'=>$types,
            'user'=>$user
        ));
    }

    public function typeSuccess($message)
    {
        $types = $this->getDoctrine()->getRepository('StockHavenBundle:type')->findAll();
        $user = $this->get('user.services')->format_response($this->getUser());
        $user = $this->getDoctrine()->getRepository('StockHavenBundle:user')->find($user['id']);
        return $this->render('StockHavenBundle:site-part/type:index.html.twig',array(
            'success'=>$message,
            'types'=>$types,
            'user'=>$user
        ));
    }

    public function deleteAction(Request $request)
    {
        $type_id = $request->query->get('id');
        $type = $this->getDoctrine()->getRepository('StockHavenBundle:type')->find($type_id);
        $item = $this->getDoctrine()->getRepository('StockHavenBundle:item')->findOneBy(array(
            'typeId'=>$type
        ));
        if($type && !$item)
        {
            $em=$this->getDoctrine()->getManager();
            $em->remove($type);
            $em->flush();
        }
        else
        {
            return $this->typeError($type->getName()." is used in Items !!!");
        }
        return $this->typeSuccess($type->getName()." deleted !!!");
    }
    
    public function createAction(Request $request)
    {
        $name = $request->query->get('name');
        $type_found = $this->getDoctrine()->getRepository('StockHavenBundle:type')->findOneBy(array('name'=>$name));
        if(!$type_found)
        {
            $type = new type();
            $em = $this->getDoctrine()->getManager();
            $em->persist($type);
            $type->setName($name);
            $em->flush();
        }else
        {
            return $this->typeError("Type Name already exist !!!");
        }
        return $this->typeSuccess("Type : ".$type->getName()." created with success !!!");
    }

    public function editViewAction(Request $request)
    {
        $type_id = $request->query->get('id');
        $type = $this->getDoctrine()->getRepository('StockHavenBundle:type')->find($type_id);

        return $this->render('@StockHaven/edit/index.html.twig',array(
            'type'=>$type
        ));

    }

    public function editAction(Request $request)
    {
        $type_id = $request->query->get('type_id');
        $name = $request->query->get('name');
        $type = $this->getDoctrine()->getRepository('StockHavenBundle:type')->find($type_id);
        if ($type->getName() != $name) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($type);
            $type->setName($name);
            $em->flush();
        } else {
            $this->typeError("Type already up to date !!!");
        }
        return $this->typeSuccess("Type edited !!!");
    }
}
