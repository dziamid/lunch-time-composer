<?php

namespace LunchTime\DeliveryBundle\Entity\Client;

use Doctrine\ORM\Mapping as ORM;
use JMS\SerializerBundle\Annotation as Serializer;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * LunchTime\DeliveryBundle\Entity\Client\Order
 *
 * @ORM\Table(name="ClientOrder")
 * @ORM\Entity(repositoryClass="LunchTime\DeliveryBundle\Entity\Client\OrderRepository")
 */
class Order
{
    /**
     * @var integer $id
     *
     * @Serializer\Type("integer")
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer $client_id Id of this entity currently mapped on client side
     * @Serializer\Type("integer")
     */
    private $client_id;

    /**
     * @var ArrayCollection $items
     * @Serializer\Type("ArrayCollection<LunchTime\DeliveryBundle\Entity\Client\Order\Item>")
     * @ORM\OneToMany(targetEntity="\LunchTime\DeliveryBundle\Entity\Client\Order\Item", mappedBy="order", cascade={"persist", "remove"})
     */
    private $items;

    /**
     * @var \DateTime $due_date
     * @Serializer\SerializedName("date")
     * @Serializer\Type("DateTime")
     *
     * @ORM\Column(name="due_date", type="date")
     */
    private $due_date;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }


    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    public function __toString()
    {
        return (string)$this->id;
    }
    
    /**
     * Add items
     *
     * @param LunchTime\DeliveryBundle\Entity\Client\Order\Item $items
     */
    public function addItem(\LunchTime\DeliveryBundle\Entity\Client\Order\Item $items)
    {
        $this->items[] = $items;
    }

    /**
     * Get items
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * Set due_date
     *
     * @param date $dueDate
     */
    public function setDueDate($dueDate)
    {
        $this->due_date = $dueDate;
    }

    /**
     * Get due_date
     *
     * @return date 
     */
    public function getDueDate()
    {
        return $this->due_date;
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