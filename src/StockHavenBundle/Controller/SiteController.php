<?php

namespace StockHavenBundle\Controller;


use StockHavenBundle\Entity\user;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class SiteController extends Controller
{

    /**
     * la vue après connexion
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function dashboardAction()
    {
        $nbUser=$this->getDoctrine()->getRepository('StockHavenBundle:user')->findAll();
        $nbUser = count($nbUser);
        $users = $this->getDoctrine()->getRepository('StockHavenBundle:user')->findAll();
        $nbItem=$this->getDoctrine()->getRepository('StockHavenBundle:item')->findAll();
        $nbItem = count($nbItem);
        $nbStock = $this->getDoctrine()->getRepository('StockHavenBundle:stock')->findAll();
        $nbStock = count($nbStock);
        $nbStore = $this->getDoctrine()->getRepository('StockHavenBundle:store')->findAll();
        $nbStore = count($nbStore);
        $user_current = $this->getUser();
        $user_current = $this->get('user.services')->format_response($user_current);
        try
        {
            return $this->render('@StockHaven/site-part/dashboard/index.html.twig',array(
                'nbUser'=>$nbUser,
                'nbItem'=>$nbItem,
                'nbStock'=>$nbStock,
                'nbStore'=>$nbStore,
                'users'=>$users,
                'user_current'=>$user_current
            ));
        } catch (\Exception $ex)
        {
            return $this->render('@StockHaven/site-part/error/error-404.twig');
        }
    }

    /**
     * la barre de recherche présente a tout moment
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function searchAction(Request $request)
    {
        $search = $request->query->get('elem');
        $barcode_found = $this->getDoctrine()->getRepository('StockHavenBundle:barcode')->findOneBy(array('barcode'=>$search));
        $user_current = $this->get('user.services')->format_response($this->getUser());
        $user = $this->getDoctrine()->getRepository('StockHavenBundle:user')->find($user_current['id']);
        if($barcode_found)
        {
            $item = $this->getDoctrine()->getRepository('StockHavenBundle:item')->findOneBy(array('barcodeId'=>$barcode_found));
            $stock = $this->getDoctrine()->getRepository('StockHavenBundle:stock')->findOneBy(array('barcodeId'=>$barcode_found));
            if($item)
            {
                return $this->render('@StockHaven/research/index.html.twig',array(
                    'item'=>$item,
                    'user'=>$user
                ));
            }
            elseif($stock)
            {
                return $this->render('@StockHaven/research/index.html.twig',array(
                    'stock'=>$stock,
                    'user'=>$user
                ));
            }
        }
        else
        {
            $item = $this->getDoctrine()->getRepository('StockHavenBundle:item')->findOneBy(array('name'=>$search));
            $stock = $this->getDoctrine()->getRepository('StockHavenBundle:stock')->findOneBy(array('name'=>$search));
            if($item)
            {
                return $this->render('@StockHaven/research/index.html.twig',array(
                    'item'=>$item,
                    'user'=>$user
                ));
            }
            elseif($stock)
            {
                return $this->render('@StockHaven/research/index.html.twig',array(
                    'stock'=>$stock,
                    'user'=>$user
                ));
            }
        }
        return $this->render('@StockHaven/research/index.html.twig');
    }

    /**
     * si l'édition des droits est réalisé
     * @param $message
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function successDashboard($message)
    {
        $nbUser=$this->getDoctrine()->getRepository('StockHavenBundle:user')->findAll();
        $nbUser = count($nbUser);
        $users = $this->getDoctrine()->getRepository('StockHavenBundle:user')->findAll();
        $nbItem=$this->getDoctrine()->getRepository('StockHavenBundle:item')->findAll();
        $nbItem = count($nbItem);
        $nbStock = $this->getDoctrine()->getRepository('StockHavenBundle:stock')->findAll();
        $nbStock = count($nbStock);
        $nbStore = $this->getDoctrine()->getRepository('StockHavenBundle:store')->findAll();
        $nbStore = count($nbStore);
        $user_current = $this->getUser();
        $user_current = $this->get('user.services')->format_response($user_current);
        try
        {
            return $this->render('@StockHaven/site-part/dashboard/index.html.twig',array(
                'nbUser'=>$nbUser,
                'nbItem'=>$nbItem,
                'nbStock'=>$nbStock,
                'nbStore'=>$nbStore,
                'users'=>$users,
                'user_current'=>$user_current,
                'success'=>$message
            ));
        } catch (\Exception $ex)
        {
            return $this->render('@StockHaven/site-part/error/error-404.twig');
        }
    }

    /**
     * quand on ajoute un user en admin
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function AddSuperUserAction(Request $request)
    {
        $user = $request->query->get('id');
        $user = $this->getDoctrine()->getRepository('StockHavenBundle:user')->find($user);

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $user->setIsSuperUser(true);
        $em->flush();

        return $this->successDashboard($user->getFullName()." is Super User Now !!!");
    }

    /**
     * quand on retire un user d'admin
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function removeSuperUserAction(Request $request)
    {
        $user = $request->query->get('id');
        $user = $this->getDoctrine()->getRepository('StockHavenBundle:user')->find($user);

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $user->setIsSuperUser(false);
        $em->flush();

        return $this->successDashboard($user->getFullName()." is  not Super User Now !!!");
    }

    /**
     * menu d'édition de profile
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function profileAction(Request $request)
    {
        $fullName = $request->query->get('fullName');
        $password = $request->query->get('password');
        $password = sha1($password);
        $newPassword = $request->query->get('newPassword');
        $repeat_password = $request->query->get('repeatPassword');
        $user = $this->getUser();
        $user=$this->get('user.services')->format_response($user);
        $error = null;
        $success = null;

        $user=$this->getDoctrine()->getRepository('StockHavenBundle:user')->findOneBy(array('id'=>$user['id']));

        if($fullName && $fullName != $user->getFullName())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $user->setFullName($fullName);
            $em->flush();
            $success =  $this->errorAndSuccess($success,1);
        }
        else
        {
            $error = $this->errorAndSuccess($error,1);
        }

        if($newPassword && $newPassword==$repeat_password && $user->getPassword()==$password)
        {
            $newPassword = sha1($newPassword);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $user->setPassword($newPassword);
            $em->flush();
            if($success)
            {
                $success = $this->errorAndSuccess($success,2);
            }else
            {
                $success = $this->errorAndSuccess($success,3);
            }
        }else
        {
            if($error)
            {
                $error = $this->errorAndSuccess($error,2);
            }else
            {
                $error = $this->errorAndSuccess($error,3);
            }
        }
        if($error && !$success)
        {
            $error = $this->errorAndSuccess($error,4);
            return $this->messageProfile($error,null);
        }
        elseif($success && !$error)
        {
            $success = $this->errorAndSuccess($success,5);
            return $this->messageProfile(null, $success);
        }elseif($success && $error)
        {
            $error = $this->errorAndSuccess($error,4);
            $success = $this->errorAndSuccess($success,5);
            return $this->messageProfile($error, $success);
        }
    }

    /**
     * message d'erreur ou de réussite de changement de profile
     * @param $message
     * @param $condition
     * @return string
     */
    public function errorAndSuccess($message,$condition)
    {
        switch ($condition)
        {
            case 1:$message = $message."Full Name ";break;
            case 2:$message = $message."and/or Password ";break;
            case 3:$message = $message."Password ";break;
            case 4:$message = $message."not change";break;
            case 5:$message = $message."change";break;
        }
        return $message;
    }

    public function messageProfile($error,$success)
    {
        if($error && $success)
        {
            return $this->render('StockHavenBundle:site-part/profile:index.html.twig', array(
                'error'=>$error,
                'success'=>$success
            ));
        }elseif($success && !$error)
        {
            return $this->render('StockHavenBundle:site-part/profile:index.html.twig', array(
                'success'=>$success
            ));
        }elseif ($error && !$success)
        {
            return $this->render('StockHavenBundle:site-part/profile:index.html.twig', array(
                'error'=>$error
            ));
        }

    }

    /**
     * gestion du menu
     * @param $slug
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function projectsAction($slug)
    {
        try {
            return $this->render('@StockHaven/site-part/projects/index-'.$slug.'.html.twig');
        } catch (\Exception $ex) {
            return $this->render('@StockHaven/site-part/error/error-404.twig');
        }
    }

    /**
     * retourne l'erreur 404 not found
     * @param $path
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function error_404_other_ajaxAction($path)
    {
        return $this->render('@StockHaven/site-part/error/error-404.twig');
    }
}