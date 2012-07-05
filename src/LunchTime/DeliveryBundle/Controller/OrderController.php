<?php

namespace LunchTime\DeliveryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Collections\ArrayCollection;

use LunchTime\DeliveryBundle\Entity\Client\Order;
use Doctrine\ORM\EntityManager;

class OrderController extends Controller
{

    /**
     * @Route(name="orderBaseUrl", pattern="/order")
     * @Method("POST")
     */
    public function persistAction()
    {
        /** @var $em EntityManager */
        $em = $this->getDoctrine()->getEntityManager();

        $data = json_decode($this->getRequest()->getContent(), true);

        $order = $this->mapOrder($data, $em);

        $em->persist($order);
        $em->flush();

        $result = json_encode(array(
            'success' => true,
            'order' => json_decode($this->get('serializer')->serialize($order, 'json'), true),
        ));

        return new Response($result);

    }

    /**
     * Deserializes an array to Order entity
     *
     * @param $orderData array serialized entity data
     * @param $em EntityManager instance
     * @return Order
     */
    protected function mapOrder($orderData, $em)
    {
        $order = $orderData['id'] !== null ? $em->find('LTDeliveryBundle:Client\Order', $orderData['id']) : new Order();
        $order->setDueDate(new \DateTime($orderData['date']));
        $order->setClientId($orderData['client_id']);

        foreach ($orderData['items'] as $itemData) {
            if ($item = $this->mapOrderItem($itemData, $em)) {
                $order->addItem($item);
                $item->setOrder($order);
            }
        }

        return $order;
    }

    /**
     * Deserializes an array to Order\Item entity
     *
     * @param $itemData array serialized entity data
     * @param $em EntityManager
     *
     * @return Order/Item
     */
    protected function mapOrderItem($itemData, $em)
    {
        //TODO: check existance and handle errors
        $item = $itemData['id'] !== null ? $em->find('LTDeliveryBundle:Client\Order\Item', $itemData['id']) : new Order\Item();
        $item->setAmount($itemData['amount']);

        $menuItemData = $itemData['menu_item'];

        //TODO: check existance and handle errors
        $menuItem = $em->find('LTDeliveryBundle:Menu\Item', $menuItemData['id']);
        $item->setMenuItem($menuItem);

        if (isset($itemData['_destroy']) && $itemData['_destroy']) {
            $em->remove($item);
            return false;
        }
        return $item;
    }


}
