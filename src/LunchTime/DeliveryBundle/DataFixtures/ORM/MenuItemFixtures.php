<?php
namespace LunchTime\DeliveryBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use LunchTime\DeliveryBundle\Entity\Menu\Item;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;

class MenuItemFixtures extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $menu1 = $this->getReference('menu-1');
        $salad = $this->getReference('salad');
        $soup = $this->getReference('soup');
        $main = $this->getReference('main');
        $pizza = $this->getReference('pizza');

        //soups
        $item = new Item();
        $item->fromArray(array(
            'title' => 'Борщ',
            'price' => 10500,
            'menu' => $menu1,
            'category' => $soup,
        ));
        $manager->persist($item);
        $this->addReference('menu-item-soup', $item);

        $item = new Item();
        $item->fromArray(array(
            'title' => 'Куриный суп с рисом',
            'price' => 12500,
            'menu' => $menu1,
            'category' => $soup,
        ));
        $manager->persist($item);

        $item = new Item();
        $item->fromArray(array(
            'title' => 'Щавель',
            'price' => 11300,
            'menu' => $menu1,
            'category' => $soup,
        ));
        $manager->persist($item);

        //salads
        $item = new Item();
        $item->fromArray(array(
            'title' => 'Из риса с крабавыми палочками',
            'price' => 8300,
            'menu' => $menu1,
            'category' => $salad,
        ));
        $manager->persist($item);
        $this->addReference('menu-item-salad', $item);

        $item = new Item();
        $item->fromArray(array(
            'title' => 'Из курицы с огурцом',
            'price' => 9300,
            'menu' => $menu1,
            'category' => $salad,
        ));
        $manager->persist($item);

        //main
        $item = new Item();
        $item->fromArray(array(
            'title' => 'Говядина "Пикантная"',
            'price' => 29350,
            'menu' => $menu1,
            'category' => $main,
        ));
        $manager->persist($item);

        $item = new Item();
        $item->fromArray(array(
            'title' => 'Бефстроганов из телятины',
            'price' => 31500,
            'menu' => $menu1,
            'category' => $main,
        ));
        $manager->persist($item);

        $manager->flush();
    }

    public function getOrder()
    {
        return 3;
    }

}