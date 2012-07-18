<?php

namespace LunchTime\DeliveryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use LunchTime\DeliveryBundle\Entity\Company;

/**
 * LunchTime\DeliveryBundle\Entity\Client
 *
 * @ORM\Table(name="Client")
 * @ORM\Entity(repositoryClass="LunchTime\DeliveryBundle\Entity\ClientRepository")
 */
class Client
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
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string $phone
     *
     * @ORM\Column(name="phone", type="string", length=255, nullable=true)
     */
    private $phone;

    /**
     * @var string $email;
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @var string $token;
     *
     * @ORM\Column(name="token", type="string", length=255)
     */
    private $token;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="\LunchTime\DeliveryBundle\Entity\Client\Order", mappedBy="client")
     */
    private $orders;

    /**
     * @var Company
     *
     * @ORM\ManyToOne(targetEntity="\LunchTime\DeliveryBundle\Entity\Company", inversedBy="clients")
     */
    private $company;

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
     * Set name
     *
     * @param string $name
     * @return Client
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set phone
     *
     * @param string $phone
     * @return Client
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * Get phone
     *
     * @return string 
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param \LunchTime\DeliveryBundle\Entity\Client\Order $order
     */
    public function addOrder($order)
    {
        $this->orders[] = $order;
    }

    /**
     * @return ArrayCollection
     */
    public function getOrders()
    {
        return $this->orders;
    }

    /**
     * @param Company $company
     */
    public function setCompany($company)
    {
        $this->company = $company;
    }

    /**
     * @return Company
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }
}