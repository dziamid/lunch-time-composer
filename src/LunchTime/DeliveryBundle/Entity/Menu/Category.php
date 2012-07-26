<?php

namespace LunchTime\DeliveryBundle\Entity\Menu;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\SerializerBundle\Annotation as Serializer;


/**
 * LunchTime\DeliveryBundle\Entity\Menu\Category
 *
 * @ORM\Table(name="MenuCategory")
 * @ORM\Entity(repositoryClass="LunchTime\DeliveryBundle\Entity\Menu\CategoryRepository")
 * @Gedmo\Tree(type="nested")
 */
class Category
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
     * @var string $title
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @Serializer\Exclude
     * @ORM\OneToMany(targetEntity="\LunchTime\DeliveryBundle\Entity\Menu\Item", mappedBy="category")
     */
    private $items;

    /**
     * @Serializer\Exclude
     * @Gedmo\TreeLeft
     * @ORM\Column(name="lft", type="integer")
     */
    private $lft;

    /**
     * @Serializer\Exclude
     * @Gedmo\TreeLevel
     * @ORM\Column(name="lvl", type="integer")
     */
    private $lvl;

    /**
     * @Serializer\Exclude
     * @Gedmo\TreeRight
     * @ORM\Column(name="rgt", type="integer")
     */
    private $rgt;

    /**
     * @Serializer\Exclude
     * @Gedmo\TreeRoot
     * @ORM\Column(name="root", type="integer", nullable=true)
     */
    private $root;

    /**
     * @Serializer\Exclude
     * @Gedmo\TreeParent
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $parent;

    /**
     * @Serializer\Exclude
     * @ORM\OneToMany(targetEntity="Category", mappedBy="parent")
     * @ORM\OrderBy({"lft" = "ASC"})
     */
    private $children;

    public function __construct()
    {
        $this->items = new ArrayCollection();
        $this->children = new ArrayCollection();
    }

    function __toString()
    {
        return $this->title;
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

    public function setChildren(ArrayCollection $children)
    {
        $this->children = $children;
    }

    public function getChildren()
    {
        return $this->children;
    }

    public function addChild(Category $category)
    {
        $this->children[] = $category;
    }

    public function setParent(Category $parent)
    {
        $this->parent = $parent;
    }

    public function getParent()
    {
        return $this->parent;
    }

    public function setLft($lft)
    {
        $this->lft = $lft;
    }

    public function getLft()
    {
        return $this->lft;
    }

    public function setLvl($lvl)
    {
        $this->lvl = $lvl;
    }

    public function getLvl()
    {
        return $this->lvl;
    }

    public function setRgt($rgt)
    {
        $this->rgt = $rgt;
    }

    public function getRgt()
    {
        return $this->rgt;
    }

    public function setRoot($root)
    {
        $this->root = $root;
    }

    public function getRoot()
    {
        return $this->root;
    }

    public function addItem(Item $item)
    {
        $this->items[] = $item;
    }

    public function getItems()
    {
        return $this->items;
    }
}