<?php

namespace LunchTime\DeliveryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\SerializerBundle\Annotation as Serializer;

/**
 * LunchTime\DeliveryBundle\Entity\Menu
 *
 * @ORM\Table(name="Menu")
 * @ORM\Entity(repositoryClass="LunchTime\DeliveryBundle\Entity\MenuRepository")
 */
class Menu
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var date $due_date
     * @Serializer\SerializedName("date")
     *
     * @ORM\Column(name="due_date", type="date")
     */
    private $due_date;

    /**
     * @ORM\OneToMany(targetEntity="\LunchTime\DeliveryBundle\Entity\Menu\Item", mappedBy="menu")
     */
    private $items;
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
    public function __construct()
    {
        $this->items = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString()
    {
        return (string)$this->id;
    }
    
    /**
     * Add items
     *
     * @param LunchTime\DeliveryBundle\Entity\Menu\Item $items
     */
    public function addItem(\LunchTime\DeliveryBundle\Entity\Menu\Item $items)
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
}