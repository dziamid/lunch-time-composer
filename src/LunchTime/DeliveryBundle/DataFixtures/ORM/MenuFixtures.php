<?php
namespace LunchTime\DeliveryBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use LunchTime\DeliveryBundle\Entity\Menu;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Collections\ArrayCollection;

class MenuFixtures extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $menus = new ArrayCollection();

        $menu = new Menu();
        $menu->setDueDate(new \DateTime('this monday'));
        $menus->add($menu);

        $menu = new Menu();
        $menu->setDueDate(new \DateTime('this wednesday'));
        $menus->add($menu);

        $menu = new Menu();
        $menu->setDueDate(new \DateTime('this sunday'));
        $menus->add($menu);

        foreach ($menus as $key => $menu) {
            $this->setReference(sprintf('menu-%s', $key + 1), $menu);
            $manager->persist($menu);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }

}