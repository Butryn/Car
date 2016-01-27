<?php

namespace CarBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
		// entity menager sĹuĹźy do zarzadzania polaczeniami z baza
		$em = $this->container->get('doctrine')->getManager();
		// repozytorium sluzo do laczenia z konkretna encja
		$repo = $em->getRepository('CarBundle:Car');
		$cars = $repo->findAll();
        return $this->render('CarBundle:Default:car_list.html.twig', array('cars' => $cars));
    }
      public function orderAction()
    {
		// entity menager sĹuĹźy do zarzadzania polaczeniami z baza
		$em = $this->container->get('doctrine')->getManager();
		// repozytorium sluzo do laczenia z konkretna encja
		$repo = $em->getRepository('CarBundle:CarOrder');
		$carorder = $repo->findAll();
        return $this->render('CarBundle:Default:carorders_list.html.twig', array('carorder' => $carorder));
    }

}