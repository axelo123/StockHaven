<?php

namespace StockHavenBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('StockHavenBundle::index.html.twig');
    }
}
