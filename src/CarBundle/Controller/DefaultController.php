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
		$user = $this->container->get('security.context')->getToken()->getUser(); // pobieramy uzytkownika
		$carOrder = new CarOrder();
		$carOrder->setUserId($user->getId()); // to przekazalo nam userId do zamowienia
		$carOrder->setCarId($id); // to przekzało nam id cara do zamowienia
        $form = $this->createForm(new CarOrderType(), $carOrder); // tworzy formularz
        $form->handleRequest($request); // obsluga rzadania

        if ($form->isSubmitted() && $form->isValid()) { // spr czy jest wypelniony  i zatwoerdzony
            $em = $this->getDoctrine()->getManager();
			$orderDate = $form['orderDate']->getData(); // pobieramy data wypoz z formularza
			$returnDate = $form['returnDate']->getData(); // pobieramyd date zwrotu 
			$carOrder->setOrderDate($orderDate);
			$carOrder->setReturnDate($returnDate);
            $em->persist($carOrder); // informacja o tym, ze jest obiekt do zapisania
            $em->flush(); // zapisuje do bazy danych

            return $this->redirectToRoute('car_out');
        }

        return $this->render('CarBundle:Default:carorder.html.twig', array(
            'carOrder' => $carOrder,
            'form' => $form->createView(),
			'car' => $car
        ));
    }

	 public function historyAction()
    {
		$user = $this->container->get('security.context')->getToken()->getUser();
		$em = $this->container->get('doctrine')->getManager();
		$repo = $em->getRepository('CarBundle:CarOrder');
		$orders = $repo->findBy( array('userId' => $user->getId()));
        return $this->render('CarBundle:Default:history.html.twig', array('orders' => $orders));
    }
	
}