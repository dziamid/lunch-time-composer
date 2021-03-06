<?php

namespace LunchTime\DeliveryBundle\Entity\Menu;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\SerializerBundle\Annotation as Serializer;
use Symfony\Component\DependencyInjection\Container;
use LunchTime\DeliveryBundle\Entity\Menu;

/**
 * LunchTime\DeliveryBundle\Entity\Menu\Item
 *
 * @ORM\Table(name="MenuItem")
 * @ORM\Entity(repositoryClass="LunchTime\DeliveryBundle\Entity\Menu\ItemRepository")
 */
class Item
{
    const BOX_MAIN = 'main';
    const BOX_SALAD = 'salad';
    const BOX_SOUP = 'soup';
    const BOX_PIZZA = 'pizza';

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
     * @var ArrayCollection
     *
     * @Serializer\Exclude
     * @ORM\ManyToMany(targetEntity="\LunchTime\DeliveryBundle\Entity\Menu", inversedBy="items")
     */
    private $menus;

    /**
     * @var float $price
     *
     * @ORM\Column(name="price", type="float")
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity="\LunchTime\DeliveryBundle\Entity\Menu\Category", inversedBy="items")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $category;

    /**
     * @var bool $is_box
     *
     * @ORM\Column(name="is_box", type="boolean")
     */
    private $is_box = false;

    /**
     * @var string $box_type
     *
     * @ORM\Column(name="box_type", type="string", length=255)
     */
    private $box_type = self::BOX_MAIN;



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

    public function setCategory($category)
    {
        $this->category = $category;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function fromArray($data)
    {
        foreach ($data as $field => $value) {
            $setter = 'set'.Container::camelize($field);
            if (method_exists($this, 'get'.Container::camelize($field))) {
                $this->$setter($value);
            }
        }
    }

    public function addMenu(Menu $menu)
    {
        $this->menus[] = $menu;
    }

    public function removeMenu(Menu $menu)
    {
        $this->menus->removeElement($menu);
    }

    public function getMenus()
    {
        return $this->menus;
    }

    /**
     * Get all order items that are related to this menu item in given orders
     *
     * @param array $orders
     */
    public function getOrderItems(array $orders)
    {
        $selectedItems = array();
        foreach ($orders as $order) {
            /** @var \LunchTime\DeliveryBundle\Entity\Client\Order $order */
            foreach ($order->getItems() as $item) {
                /** @var \LunchTime\DeliveryBundle\Entity\Client\Order\Item $item */
                if ($item->getMenuItem() == $this) {
                    $selectedItems[] = $item;
                }

            }
        }

        return $selectedItems;
    }

    public function getOrderItemsAmount(array $orders)
    {
        $items = $this->getOrderItems($orders);

        return array_sum(array_map(function($item) { return $item->getAmount(); }, $items));
    }

    /**
     * @param string $box_type
     */
    public function setBoxType($box_type)
    {
        $this->box_type = $box_type;
    }

    /**
     * @return string
     */
    public function getBoxType()
    {
        return $this->box_type ?: $this->getCategory()->getBoxType();
    }

    /**
     * @param boolean $is_box
     */
    public function setIsBox($is_box)
    {
        $this->is_box = $is_box;
    }

    /**
     * @return boolean
     */
    public function getIsBox()
    {
        return $this->is_box;
    }

    public static function getBoxes()
    {
        return array(
            self::BOX_MAIN => "Box for any meal",
            self::BOX_PIZZA => "Box for pizza",
            self::BOX_SALAD => "Box for salad",
            self::BOX_SOUP => "Box for soup",
        );
    }

}