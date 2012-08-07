<?php

namespace LunchTime\BackendBundle\Controller\Client;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\Security\Core\SecurityContext;

class OrderController extends Controller
{

    /**
     * @Template
     * @Route("/client/order/group-list", name="order_group_list")
     */
    public function groupListAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $orders = $em->getRepository('LTDeliveryBundle:Client\Order')->findAll();

        $menuItems = array();
        $orderItems = array();
        foreach ($orders as $order) {
            foreach ($order->getItems() as $orderItem) {
                $menuItem = $orderItem->getMenuItem();
                $menuItems[] = $menuItem;
            }
        }

        $menuItems = array_filter($menuItems, function ($item) {
            static $found = array();
            $id = $item->getId();
            if (!in_array($id, $found)) {
                $found[] = $id;
                return $item;
            } else {
                return false;
            }
        });

        return array(
            'menuItems' => $menuItems,
            'orders'     => $orders,
            'admin_pool' => $this->get('sonata.admin.pool'),
        );
    }

}
