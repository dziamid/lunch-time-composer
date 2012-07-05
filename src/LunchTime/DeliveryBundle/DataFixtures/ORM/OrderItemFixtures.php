<?php
namespace LunchTime\DeliveryBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;

use LunchTime\DeliveryBundle\Entity\Client\Order\Item;

class OrderItemFixtures extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        //ORDER 1
        $order = $this->getReference('order-1');

        $item = new Item();
        $item->setOrder($order);
        $item->setMenuItem($this->getReference('menu-item-3'));
        $item->setAmount(1);
        $manager->persist($item);

        $item = new Item();
        $item->setOrder($order);
        $item->setMenuItem($this->getReference('menu-item-2'));
        $item->setAmount(2);
        $manager->persist($item);

        $item = new Item();
        $item->setOrder($order);
        $item->setMenuItem($this->getReference('menu-item-1'));
        $item->setAmount(3);
        $manager->persist($item);

        $manager->flush();
    }

    public function getOrder()
    {
        return 4;
    }

}