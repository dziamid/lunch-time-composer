<?php

namespace LunchTime\DeliveryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * LunchTime\DeliveryBundle\Entity\Company
 *
 * @ORM\Table(name="Company")
 * @ORM\Entity(repositoryClass="LunchTime\DeliveryBundle\Entity\CompanyRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Company
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
     * @var string $key Secure key for login-in
     *
     * @ORM\Column(name="token", type="string", length=255)
     */
    private $token;

    /**
     * @var ArrayCollection $clients
     *
     * @ORM\OneToMany(targetEntity="\LunchTime\DeliveryBundle\Entity\Client", mappedBy="company")
     */
    private $clients;

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
     * @return Company
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
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
     * @static
     *
     */
    public static function generateToken($len = 20)
    {
        $hash = '';
        $pool = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        for ($i = 1; $i <= $len; $i++) {
            $hash .= substr($pool, rand(0, 61), 1);
        }

        return $hash;
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

    /**
     * @param Client $client
     */
    public function addClient($client)
    {
        $this->clients[] = $client;
    }

    /**
     * @return ArrayCollection
     */
    public function getClients()
    {
        return $this->clients;
    }

    /**
     * @ORM\PrePersist
     */
    public function prePersist()
    {
        $this->setToken(Company::generateToken(10));
    }

}