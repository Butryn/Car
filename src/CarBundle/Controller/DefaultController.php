<?php

namespace CarBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use CarBundle\Entity\CarOrder;
use CarBundle\Form\CarOrderType;


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
      public function orderAction($id, Request $request) // odnosimy sie do tego $id
    {
		// entity menager sĹuĹźy do zarzadzania polaczeniami z baza
		$em = $this->container->get('doctrine')->getManager();
		// repozytorium sluzo do laczenia z konkretna encja
		$repo = $em->getRepository('CarBundle:Car');
		$car = $repo->find($id); // wyszukujemy auto z konkretnym id 
		$carOrder = new CarOrder();
        $form = $this->createForm(new CarOrderType(), $carOrder); // tworzy formularz
        $form->handleRequest($request); // obsluga rzadania

        if ($form->isSubmitted() && $form->isValid()) { // spr czy jest wypelniony  i zatwoerdzony
            $em = $this->getDoctrine()->getManager();
            $em->persist($carOrder); // informacja o tym, ze jest obiekt do zapisania
            $em->flush(); // zapisuje do bazy danych

            return $this->redirectToRoute('carorder_show', array('id' => $carorder->getId()));
        }

        return $this->render('CarBundle:Default:carorder.html.twig', array(
            'carOrder' => $carOrder,
            'form' => $form->createView(),
			'car' => $car
        ));
    }

}