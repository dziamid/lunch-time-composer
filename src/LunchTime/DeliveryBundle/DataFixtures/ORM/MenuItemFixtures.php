<?php
namespace LunchTime\DeliveryBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use LunchTime\DeliveryBundle\Entity\Menu\Item;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Collections\ArrayCollection;

class MenuItemFixtures extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        //menus
        $menus = new ArrayCollection();
        $menus->add($this->getReference('menu-1'));
        $menus->add($this->getReference('menu-2'));
        $menus->add($this->getReference('menu-3'));

        //menu/categories
        $salad = $this->getReference('salad');
        $soup = $this->getReference('soup');
        $main = $this->getReference('main');
        $pizza = $this->getReference('pizza');

        //items
        $items = new ArrayCollection();

        //soups
        $item = new Item();
        $item->fromArray(array(
            'title'    => 'Борщ',
            'price'    => 10500,
            'category' => $soup,
        ));
        $items->add($item);
        $this->addReference('menu-item-soup', $item);

        $item = new Item();
        $item->fromArray(array(
            'title'    => 'Куриный суп с рисом',
            'price'    => 12500,
            'category' => $soup,
        ));
        $items->add($item);

        $item = new Item();
        $item->fromArray(array(
            'title'    => 'Щавель',
            'price'    => 11300,
            'category' => $soup,
        ));
        $items->add($item);

        //salads
        $item = new Item();
        $item->fromArray(array(
            'title'    => 'Из риса с крабавыми палочками',
            'price'    => 8300,
            'category' => $salad,
        ));
        $items->add($item);
        $this->addReference('menu-item-salad', $item);

        $item = new Item();
        $item->fromArray(array(
            'title'    => 'Из курицы с огурцом',
            'price'    => 9300,
            'category' => $salad,
        ));
        $items->add($item);

        //main
        $item = new Item();
        $item->fromArray(array(
            'title'    => 'Говядина "Пикантная"',
            'price'    => 29350,
            'category' => $main,
        ));
        $items->add($item);

        $item = new Item();
        $item->fromArray(array(
            'title'    => 'Бефстроганов из телятины',
            'price'    => 31500,
            'category' => $main,
        ));
        $items->add($item);

        foreach ($items as $item) {
            $menu = $menus[rand(0, count($menus)-1)];
            $menu->addItem($item);
            $manager->persist($item);
        }

        foreach ($menus as $menu) {
            $manager->persist($menu);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 3;
    }

}