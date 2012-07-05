<?php
namespace LunchTime\DeliveryBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use LunchTime\DeliveryBundle\Entity\Menu;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;

class MenuFixtures extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $menu = new Menu();
        $menu->setDueDate(new \DateTime('this monday'));
        $manager->persist($menu);

        $this->addReference('menu-1', $menu);

        $menu = new Menu();
        $menu->setDueDate(new \DateTime('this wednesday'));
        $manager->persist($menu);
        $this->addReference('menu-2', $menu);

        $menu = new Menu();
        $menu->setDueDate(new \DateTime('this sunday'));
        $manager->persist($menu);

        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }

}