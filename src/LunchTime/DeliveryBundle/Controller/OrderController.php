<?php

namespace LunchTime\DeliveryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Collections\ArrayCollection;

use LunchTime\DeliveryBundle\Entity\Client\Order;


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

        $data = json_decode($this->getRequest()->getContent(), true);
        $data = array_merge($data, array('client' => $client));

        $order = $this->mapOrder($data, $em);

        $em->persist($order);
        $em->flush();

        $result = json_encode(array(
            'success' => true,
            'order' => json_decode($this->get('serializer')->serialize($order, 'json'), true),
        ));

        return new Response($result);

    }

}
