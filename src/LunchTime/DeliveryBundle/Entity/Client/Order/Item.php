<?php

namespace LunchTime\DeliveryBundle\Entity\Client\Order;

use Doctrine\ORM\Mapping as ORM;
use JMS\SerializerBundle\Annotation as Serializer;

/**
 * LunchTime\DeliveryBundle\Entity\Client\Order\Item
 *
 * @ORM\Table(name="ClientOrderItem")
 * @ORM\Entity(repositoryClass="LunchTime\DeliveryBundle\Entity\Client\Order\ItemRepository")
 */
class Item
{
    /**
     * @var integer $id
     * @Serializer\Type("integer")
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer $amount
     * @Serializer\Type("integer")
     * @ORM\Column(name="amount", type="integer")
     */
    private $amount;

    /**
     * @ORM\ManyToOne(targetEntity="\LunchTime\DeliveryBundle\Entity\Client\Order", inversedBy="items")
     */
    private $order;

    /**
     * @Serializer\Type("\LunchTime\DeliveryBundle\Entity\Menu\Item")
     * @ORM\ManyToOne(targetEntity="\LunchTime\DeliveryBundle\Entity\Menu\Item")
     */
    private $menu_item;

    /**
     * @var integer $client_id Id of this entity that identifies itself on the client side
     * @Serializer\Type("integer")
     */
    private $client_id;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set amount
     *
     * @param integer $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    /**
     * Get amount
     *
     * @return integer 
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set order
     *
     * @param LunchTime\DeliveryBundle\Entity\Client\Order $order
     */
    public function setOrder(\LunchTime\DeliveryBundle\Entity\Client\Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get order
     *
     * @return LunchTime\DeliveryBundle\Entity\Client\Order 
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Set menu_item
     *
     * @param \LunchTime\DeliveryBundle\Entity\Menu\Item $menuItem
     */
    public function setMenuItem(\LunchTime\DeliveryBundle\Entity\Menu\Item $menuItem)
    {
        $this->menu_item = $menuItem;
    }

    /**
     * Get menu_item
     *
     * @return LunchTime\DeliveryBundle\Entity\Menu\Item 
     */
    public function getMenuItem()
    {
        return $this->menu_item;
    }

    /**
     * @param int $client_id
     */
    public function setClientId($client_id)
    {
        $this->client_id = $client_id;
    }

    /**
     * @return int
     */
    public function getClientId()
    {
        return $this->client_id;
    }
}