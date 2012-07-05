<?php

namespace LunchTime\DeliveryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;

class MenuController extends Controller
{
    /**
     * @Route("/menu")
     */
    public function indexAction()
    {
        /** @var $em \Doctrine\ORM\EntityManager */
        $em = $this->getDoctrine()->getEntityManager();

        $menus = $em->getRepository('LTDeliveryBundle:Menu')->getListWithItemsQuery()
            ->getResult();

        $_menus = array();

        foreach ($menus as $menu) {
            $items = $menu->getItems()->map(function ($item) {
                return $item->getId();
            });

            $_menus[] = array(
                'id' => $menu->getId(),
                'due_date' => $menu->getDueDate()->format('Y-m-d H:i:s'),
                'items' => $items->toArray(),
            );

        }


        return new Response(json_encode($_menus));
    }

    /**
     * @Route("/menu/item")
     */
    public function itemsAction()
    {
        /** @var $em \Doctrine\ORM\EntityManager */
        $em = $this->getDoctrine()->getEntityManager();

        $items = $em->getRepository('LTDeliveryBundle:Menu\Item')->getListQuery()
            ->getResult();

        $_items = array();

        foreach ($items as $item) {
            $_items[] = array(
                'id' => $item->getId(),
                'title' => $item->getTitle(),
                'menu_id' => $item->getMenu()->getId(),
            );
        }

        return new Response(json_encode($_items));
    }
}
