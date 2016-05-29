<?php

namespace StockHavenBundle\Controller;


use StockHavenBundle\Entity\address;
use StockHavenBundle\Entity\postalCode;
use StockHavenBundle\Entity\stock;
use StockHavenBundle\Entity\store;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class StoreController extends Controller
{
    public function storeAction()
    {
        $stores = $this->getDoctrine()->getRepository('StockHavenBundle:store')->findAll();
        $user = $this->get('user.services')->format_response($this->getUser());
        $user = $this->getDoctrine()->getRepository('StockHavenBundle:user')->find($user['id']);
        return $this->render('StockHavenBundle:site-part/store:index.html.twig',array(
            'stores'=>$stores,
            'user'=>$user
        ));
    }

    public function storeError($message)
    {
        $stores = $this->getDoctrine()->getRepository('StockHavenBundle:store')->findAll();
        $user = $this->get('user.services')->format_response($this->getUser());
        $user = $this->getDoctrine()->getRepository('StockHavenBundle:user')->find($user['id']);
        return $this->render('StockHavenBundle:site-part/store:index.html.twig',array(
            'error'=>$message,
            'stores'=>$stores,
            'user'=>$user
        ));
    }

    public function storeSuccess($message)
    {
        $stores = $this->getDoctrine()->getRepository('StockHavenBundle:store')->findAll();
        $user = $this->get('user.services')->format_response($this->getUser());
        $user = $this->getDoctrine()->getRepository('StockHavenBundle:user')->find($user['id']);
        return $this->render('StockHavenBundle:site-part/store:index.html.twig',array(
            'success'=>$message,
            'stores'=>$stores,
            'user'=>$user
        ));
    }

    public function deleteAction(Request $request)
    {
        $store = $request->query->get('id');
        $store = $this->getDoctrine()->getRepository('StockHavenBundle:store')->find($store);

        if($store)
        {
            unlink($store->getPicture());
            $em = $this->getDoctrine()->getManager();
            $em->remove($store);
            $em->flush();
        }else
        {
            return $this->storeError("Store not found !!!");
        }

        return $this->storeSuccess("Store deleted !!!");
    }
    
    public function editViewAction(Request $request)
    {
        $store_id = $request->query->get('id');
        $store = $this->getDoctrine()->getRepository('StockHavenBundle:store')->find($store_id);
        $countries = $this->getDoctrine()->getRepository('StockHavenBundle:country')->findAll();

        return $this->render('@StockHaven/edit/index.html.twig',array(
            'store'=>$store,
            'countries'=>$countries
        ));
        
    }

    public function editAction(Request $request)
    {
        $store_id = $request->request->get('store_id');
        $name = $request->request->get('name');
        $picture = $request->request->get('picture');
        $fileName = $request->request->get('fileName');

        $extensions_valid = array( 'jpg' , 'jpeg' , 'gif' , 'png' );
        $deb=strpos($picture,'base64')+7;
        $picture = substr($picture,$deb);
        $ext = strtolower(substr(strrchr($fileName,"."),1));

        $store = $this->getDoctrine()->getRepository('StockHavenBundle:store')->find($store_id);
        
        if($store->getName() != $name || $picture )
        {
            if ( in_array($ext,$extensions_valid) )
            {
                unlink($store->getPicture());
                $picture=base64_decode($picture);
                file_put_contents("static/images/".$name.".".$ext,$picture);

                $em = $this->getDoctrine()->getManager();
                $em->persist($store);
                $store->setName($name);
                $store->setPicture("static/images/".$name.".".$ext);
                $em->flush();
            }
            else
            {
                return $this->storeError("Type of file not valid !!!");
            }
        }
        else
        {
            return $this->storeError("Store already up to date !!!");
        }
        return $this->storeSuccess("Store Edited !!!");
    }
    
    public function createAction(Request $request)
    {
        $name = $request->request->get('name');
        $picture = $request->request->get('picture');
        $fileName = $request->request->get('fileName');

        $extensions_valid = array( 'jpg' , 'jpeg' , 'gif' , 'png' );
        $deb=strpos($picture,'base64')+7;
        $picture = substr($picture,$deb);
        $ext = strtolower(substr(strrchr($fileName,"."),1));
        
        $store_found = $this->getDoctrine()->getRepository('StockHavenBundle:store')->findOneBy(array('name'=>$name));
        if(!$store_found)
        {
            if ( in_array($ext,$extensions_valid) )
            {
                $picture=base64_decode($picture);
                file_put_contents("static/images/".$name.".".$ext,$picture);
            }
            $store = new store();
            $em = $this->getDoctrine()->getManager();
            $em->persist($store);
            $store->setName($name);
            if($picture)
            {
                $store->setPicture("static/images/".$name.".".$ext);
            }
            $em->flush();
        }else
        {
            return $this->storeError("Store Name already exist !!!");
        }
        return $this->storeSuccess("Success !!!");
    }
    
    public function selectStoreAction(Request $request)
    {
        $store_id = $request->query->get('id');
        $store = $this->getDoctrine()->getRepository('StockHavenBundle:store')->find($store_id);
        $address = $this->getDoctrine()->getRepository('StockHavenBundle:address')->findAll();
        
        return $this->render('@StockHaven/viewOneStore/index.html.twig',array(
            'store'=>$store,
            'address'=>$address
        ));
    }

    public function addAddressAction(Request $request)
    {
        $store_id = $request->query->get('store_id');
        $nb_box = $request->query->get('nb_box');
        $street = $request->query->get('street');
        $code = $request->query->get('code');
        $region = $request->query->get('region');
        $country = $request->query->get('country');
        $country_tab = explode(" ",$country);
        $em = $this->getDoctrine()->getManager();

        $store = $this->getDoctrine()->getRepository('StockHavenBundle:store')->find($store_id);

        $country = $this->getDoctrine()->getRepository('StockHavenBundle:country')->findOneBy(array(
            'name'=>$country_tab[0]
        ));

        $postalCode = $this->getDoctrine()->getRepository('StockHavenBundle:postalCode')->findOneBy(array(
            'code'=>$code,
            'region'=>$region,
            'countryId'=>$country
        ));

        if(!$postalCode)
        {
            $postalCode = new postalCode();
            $em->persist($postalCode);
            $postalCode->setCode($code);
            $postalCode->setRegion($region);
            $postalCode->setCountryId($country);
            $em->flush();
        }
        $address_found = $this->getDoctrine()->getRepository('StockHavenBundle:address')->findOneBy(array(
            'street'=>$street,
            'nbBox'=>$nb_box,

        ));

        if(!$address_found)
        {
            $address = new address();
            $em->persist($address);
            $address->setNbBox($nb_box);
            $address->setStreet($street);
            $address->setPostalCodeId($postalCode);
            $address->setStoreId($store);
            $em->flush();
        }
        else
        {
            return $this->selectStoreError("This Address already exist !!!",$store_id);
        }
        return $this->selectStoreSuccess("Address add in this Store !!!",$store_id);

    }
    public function selectStoreSuccess($message,$store_id)
    {
        $store = $this->getDoctrine()->getRepository('StockHavenBundle:store')->find($store_id);
        $address = $this->getDoctrine()->getRepository('StockHavenBundle:address')->findAll();

        return $this->render('@StockHaven/viewOneStore/index.html.twig',array(
            'store'=>$store,
            'address'=>$address,
            'success'=>$message
        ));
    }

    public function selectStoreError($message,$store_id)
    {
        $store = $this->getDoctrine()->getRepository('StockHavenBundle:store')->find($store_id);
        $address = $this->getDoctrine()->getRepository('StockHavenBundle:address')->findAll();

        return $this->render('@StockHaven/viewOneStore/index.html.twig',array(
            'store'=>$store,
            'address'=>$address,
            'error'=>$message
        ));
    }

    public function viewAddressAction(Request $request)
    {
        $store_id = $request->query->get('id');
        $store = $this->getDoctrine()->getRepository('StockHavenBundle:store')->find($store_id);
        $countries = $this->getDoctrine()->getRepository('StockHavenBundle:country')->findAll();
        $address = $this->getDoctrine()->getRepository('StockHavenBundle:address')->findAll();

        return $this->render('@StockHaven/addAddress/index.html.twig',array(
            'store'=>$store,
            'countries'=>$countries,
            'address'=>$address
        ));
    }
}
