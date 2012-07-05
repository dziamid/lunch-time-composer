<?php

namespace LunchTime\DeliveryBundle\Entity\Menu;

use Doctrine\ORM\Mapping as ORM;
use JMS\SerializerBundle\Annotation as Serializer;

/**
 * LunchTime\DeliveryBundle\Entity\Menu\Item
 *
 * @ORM\Table(name="MenuItem")
 * @ORM\Entity(repositoryClass="LunchTime\DeliveryBundle\Entity\Menu\ItemRepository")
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
     * @var string $title
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @Serializer\Exclude
     * @ORM\ManyToOne(targetEntity="\LunchTime\DeliveryBundle\Entity\Menu", inversedBy="items")
     */
    private $menu;

    /**
     * @var float $price
     *
     * @ORM\Column(name="price", type="float")
     */
    private $price;

    public function __toString()
    {
        return (string)$this->title;
    }

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
     * Set title
     *
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set menu
     *
     * @param LunchTime\DeliveryBundle\Entity\Menu $menu
     */
    public function setMenu(\LunchTime\DeliveryBundle\Entity\Menu $menu)
    {
        $this->menu = $menu;
    }

    /**
     * Get menu
     *
     * @return LunchTime\DeliveryBundle\Entity\Menu 
     */
    public function getMenu()
    {
        return $this->menu;
    }

    /**
     * Set price
     *
     * @param float $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * Get price
     *
     * @return float 
     */
    public function getPrice()
    {
        return $this->price;
    }
}