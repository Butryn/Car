<?php

namespace Kasia\EpopeeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('KasiaEpopeeBundle:Default:index.html.twig');
    }

    public function bookAction($book)
    {
        return $this->render('KasiaEpopeeBundle:Default:index.html.twig', array('book'=>$book));
    }
}