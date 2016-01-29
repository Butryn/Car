<?php

namespace CarBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use CarBundle\Entity\CarOrder;
use CarBundle\Form\CarOrderCrudType;

/**
 * CarOrder controller.
 *
 */
class CarOrderController extends Controller
{
    /**
     * Lists all CarOrder entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $carOrders = $em->getRepository('CarBundle:CarOrder')->findAll();

        return $this->render('carorder/index.html.twig', array(
            'carOrders' => $carOrders,
        ));
    }

    /**
     * Creates a new CarOrder entity.
     *
     */
    public function newAction(Request $request)
    {
        $carOrder = new CarOrder();
        $form = $this->createForm(new CarOrderCrudType(), $carOrder);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($carOrder);
            $em->flush();

            return $this->redirectToRoute('carorder_show', array('id' => $carorder->getId()));
        }

        return $this->render('carorder/new.html.twig', array(
            'carOrder' => $carOrder,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a CarOrder entity.
     *
     */
    public function showAction(CarOrder $carOrder)
    {
        $deleteForm = $this->createDeleteForm($carOrder);

        return $this->render('carorder/show.html.twig', array(
            'carOrder' => $carOrder,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing CarOrder entity.
     *
     */
    public function editAction(Request $request, CarOrder $carOrder)
    {
        $deleteForm = $this->createDeleteForm($carOrder);
        $editForm = $this->createForm(new CarOrderType(), $carOrder);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($carOrder);
            $em->flush();

            return $this->redirectToRoute('carorder_edit', array('id' => $carOrder->getId()));
        }

        return $this->render('carorder/edit.html.twig', array(
            'carOrder' => $carOrder,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a CarOrder entity.
     *
     */
    public function deleteAction(Request $request, CarOrder $carOrder)
    {
        $form = $this->createDeleteForm($carOrder);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($carOrder);
            $em->flush();
        }

        return $this->redirectToRoute('carorder_index');
    }

    /**
     * Creates a form to delete a CarOrder entity.
     *
     * @param CarOrder $carOrder The CarOrder entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CarOrder $carOrder)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('carorder_delete', array('id' => $carOrder->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
