<?php

namespace LunchTime\DeliveryBundle\Controller\Client\Order;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use LunchTime\DeliveryBundle\Entity\Client\Order\Item;
use LunchTime\DeliveryBundle\Form\Client\Order\ItemType;

/**
 * Client\Order\Item controller.
 *
 * @Route("/client/order/item")
 */
class ItemController extends Controller
{
    /**
     * Lists all Client\Order\Item entities.
     *
     * @Route("/", name="order_item")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('LTDeliveryBundle:Client\Order\Item')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a Client\Order\Item entity.
     *
     * @Route("/{id}/show", name="order_item_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('LTDeliveryBundle:Client\Order\Item')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Client\Order\Item entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Client\Order\Item entity.
     *
     * @Route("/new", name="order_item_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Item();
        $form   = $this->createForm(new ItemType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Client\Order\Item entity.
     *
     * @Route("/create", name="order_item_create")
     * @Method("post")
     * @Template("LTDeliveryBundle:Client\Order\Item:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Item();
        $request = $this->getRequest();
        $form    = $this->createForm(new ItemType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('order_item_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Client\Order\Item entity.
     *
     * @Route("/{id}/edit", name="order_item_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('LTDeliveryBundle:Client\Order\Item')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Client\Order\Item entity.');
        }

        $editForm = $this->createForm(new ItemType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Client\Order\Item entity.
     *
     * @Route("/{id}/update", name="order_item_update")
     * @Method("post")
     * @Template("LTDeliveryBundle:Client\Order\Item:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('LTDeliveryBundle:Client\Order\Item')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Client\Order\Item entity.');
        }

        $editForm   = $this->createForm(new ItemType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('order_item_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Client\Order\Item entity.
     *
     * @Route("/{id}/delete", name="order_item_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('LTDeliveryBundle:Client\Order\Item')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Client\Order\Item entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('order_item'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
