<?php

namespace StockHavenBundle\Controller;

use StockHavenBundle\Entity\user;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthConnectController extends Controller
{
    /**
     * Verification si le user existe dans la db si oui connection et redirection a la page de start
     *
     * @param Request $request
     * @return Response
     */
    public function loginCheckAction(Request $request)
    {
        // We recover the user_id
        $username = $request->request->get('login');
        $password = $request->request->get('password');
        

        $password = sha1($password);

        // check that in the db
        $user = $this->getDoctrine()->getRepository('StockHavenBundle:user')->findOneBy(array(
            'name' => $username,
            'password' => $password,
        ));
        if($user)
        {
            // Create token
            $user->createToken();

            // Save the token in the DB
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $response =  $this->render('StockHavenBundle:site-main:index.html.twig',array(
                "user"=>$user
            ));
            $response->headers->setCookie(new Cookie('token', $user->getToken()));
            return $response;
        }else if($this->getDoctrine()->getRepository('StockHavenBundle:user')->findOneBy(array('name'=>$username)))
        {
            return $this->render('StockHavenBundle:Login:login.html.twig',array(
                "error"=>"incorrect password !!!"
            ));
        }
        return $this->render('StockHavenBundle:Login:login.html.twig',array(
            "error"=>"login does not exist !!!"
        ));
    }


    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function logoutAction(Request $request) {
        // Catch token from header
        $user=$this->getUser();
        if($user)
        {
            $token = null;
            $user->setToken($token);
            $this->container->get("security.context")->setToken(null);
            $em = $this->getDoctrine()->getManager();
            $em->flush();
        }
        return $this->redirect($this->generateUrl('sh_connection'));
    }

    /**
     * @return Response
     */
    public function StartAction()
    {
        try {
            return $this->render('StockHavenBundle:Login:login.html.twig');
        } catch (\Exception $ex) {
            return new Response("Page Not Found ...",404);
        }
    }

    /**
     * @return Response
     */
    public function RegisterAction()
    {
        try {
            return $this->render('@StockHaven/Login/register.html.twig');
        } catch (\Exception $ex) {
            return new Response("Page Not Found ...",404);
        }
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function RegisterCheckAction(Request $request)
    {
        $username = $request->request->get('login');
        $password = $request->request->get('password');
        $verifpassword = $request->request->get('re-password');
        $fullName = $request->request->get('fullName');

        $user = null;

        if($verifpassword==$password && $password) {
            if ($username && $fullName) {
                $user = $this->getDoctrine()->getRepository('StockHavenBundle:user')->findOneBy(array('name' => $username));
                if ($user) {
                    return $this->render('StockHavenBundle:Login:register.html.twig', array("error" => "Login already existing !!!"));
                }
                $user = $this->getDoctrine()->getRepository('StockHavenBundle:user')->findOneBy(array('fullName' => $fullName));
                if ($user) {
                    return $this->render('StockHavenBundle:Login:register.html.twig', array("error" => "Full Name already existing !!!"));
                }
                $user = new user();
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $user->setFullName($fullName);
                $user->setName($username);
                $user->setPassword(sha1($password));
                $user->createToken();
                $em->flush();
            }
            $response = $this->render('StockHavenBundle:site-main:index.html.twig', array("user"=>$user));
            $response->headers->setCookie(new Cookie('token', $user->getToken()));
            return $response;
        }
        return $this->render('StockHavenBundle:Login:register.html.twig',array("error"=>"fill all the field"));
    }

    /**
     * @return JsonResponse
     */
    public function StockAddAction()
    {
        return new JsonResponse(array("yolo"));
    }
}
