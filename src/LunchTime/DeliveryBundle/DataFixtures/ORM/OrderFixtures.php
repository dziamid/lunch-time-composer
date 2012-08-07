<?php
namespace LunchTime\DeliveryBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;

use LunchTime\DeliveryBundle\Entity\Client\Order;

class OrderFixtures extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $order = new Order();

        $order->setDueDate($this->getReference('menu-1')->getDueDate());
        $order->setClient($this->getReference('client-1'));
        $manager->persist($order);

        $manager->flush();

        $this->addReference('order-1', $order);
    }

    public function getOrder()
    {
        return 4;
    }

}