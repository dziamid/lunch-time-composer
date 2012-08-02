<?php

namespace LunchTime\DeliveryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Collections\ArrayCollection;

use LunchTime\DeliveryBundle\Entity\Client\Order;
use LunchTime\DeliveryBundle\Controller\Base\BaseController;

class OrderController extends BaseController
{

    /**
     * @Route(name="orderPersist", pattern="/client/{token}/order")
     * @Method("POST")
     */
    public function persistAction($token)
    {
        $em = $this->getEntityManager();
        $client = $this->getClient($token);

        $_orders = json_decode($this->getRequest()->getContent(), true);
        $orders = array();
        foreach ($_orders as $_order) {
            $_order = array_merge($_order, array('client' => $client));
            $order = $this->mapOrder($_order, $em);
            $orders[] = $order;
            $em->persist($order);
        }

        $em->flush();

        $result = json_encode(array(
            'success' => true,
            'orders'   => json_decode($this->get('serializer')->serialize($orders, 'json'), true),
        ));

        return new Response($result);

    }

}
