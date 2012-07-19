<?php

namespace LunchTime\DeliveryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;

use LunchTime\DeliveryBundle\Entity\Client\Order;
use LunchTime\DeliveryBundle\Entity\Client;

class BaseController extends Controller
{

    protected function mapClient($data)
    {
        $client = new Client();

        $client->setCompany($data['company']);
        $client->setName($data['name']);
        $client->setEmail($data['email']);

        return $client;
    }

    protected function getCompany($token)
    {
        $em = $this->getEntityManager();

        $company = $em->getRepository('LTDeliveryBundle:Company')->findOneBy(array(
            'token' => $token,
        ));

        return $company;
    }

    /**
     * @param $token string
     *
     * @return Client
     */
    protected function getClient($token)
    {
        $em = $this->getEntityManager();

        $client = $em->getRepository('LTDeliveryBundle:Client')->findOneBy(array(
            'token' => $token,
        ));

        return $client;
    }

    protected function getMenus()
    {
        $menus = $this->getEntityManager()->getRepository('LTDeliveryBundle:Menu')->getListWithItemsQuery()
            ->getResult();

        return $menus;
    }

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    protected function getEntityManager()
    {
        return $this->getDoctrine()->getEntityManager();
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
        /** @var $order Order */
        $order = $orderData['id'] !== null ? $em->find('LTDeliveryBundle:Client\Order', $orderData['id']) : new Order();
        $order->setDueDate(new \DateTime($orderData['date']));
        $order->setClientId($orderData['client_id']);
        $order->setClient($orderData['client']);

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
