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
        $item->setMenuItem($this->getReference('menu-item-soup'));
        $item->setAmount(1);
        $manager->persist($item);

        $item = new Item();
        $item->setOrder($order);
        $item->setMenuItem($this->getReference('menu-item-salad'));
        $item->setAmount(2);
        $manager->persist($item);

        //ORDER 2


        $order = $this->getReference('order-2');

        $item = new Item();
        $item->setOrder($order);
        $item->setMenuItem($this->getReference('menu-item-salad'));
        $item->setAmount(1);
        $manager->persist($item);

        $item = new Item();
        $item->setOrder($order);
        $item->setMenuItem($this->getReference('salad-chiken'));
        $item->setAmount(1);
        $manager->persist($item);

        $item = new Item();
        $item->setOrder($order);
        $item->setMenuItem($this->getReference('main-beef'));
        $item->setAmount(1);
        $manager->persist($item);

        $manager->flush();
    }

    public function getOrder()
    {
        return 5;
    }

}