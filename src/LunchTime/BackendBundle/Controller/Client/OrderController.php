<?php

namespace LunchTime\BackendBundle\Controller\Client;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\Security\Core\SecurityContext;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

use LunchTime\Utils;

class OrderController extends Controller
{

    /**
     * @Template("LTBackendBundle:Client\Order:dateList.html.twig")
     * @Route("/client/order/list-today", name="order_group_list_today")
     */
    public function todayListAction()
    {
        $today = new \DateTime();
        $params = $this->dateListAction($today);

        return $params;
    }

    /**
     * @Template
     * @ParamConverter("date", class="DateTime")
     * @Route("/client/order/list/{date}", name="order_group_list_bydate")
     */
    public function dateListAction(\DateTime $date)
    {
        $em = $this->getDoctrine()->getEntityManager();
        /** @var $menus \LunchTime\DeliveryBundle\Entity\MenuRepository */
        $menus = $em->getRepository('LTDeliveryBundle:Menu')->getActiveMenusList();
        $orders = $em->getRepository('LTDeliveryBundle:Client\Order')->getListForDate($date);

        $menuItems = array();
        $orderItems = array();
        foreach ($orders as $order) {
            foreach ($order->getItems() as $orderItem) {
                $menuItem = $orderItem->getMenuItem();
                $menuItems[] = $menuItem;
            }
        }

        $menuCategories = $em->getRepository('LTDeliveryBundle:Menu\Category')->getListByItems($menuItems);

        return array(
            'date' => $date,
            'menuCategories' => $menuCategories,
            'menuItems' => $menuItems,
            'orders'     => $orders,
            'admin_pool' => $this->get('sonata.admin.pool'),
            'menus' => $menus,
        );
    }


}
