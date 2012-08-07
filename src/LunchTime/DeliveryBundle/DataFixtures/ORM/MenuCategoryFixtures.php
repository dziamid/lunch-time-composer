<?php
namespace LunchTime\DeliveryBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use LunchTime\DeliveryBundle\Entity\Menu\Category;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;

class MenuCategoryFixtures extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {

        $cat = new Category();
        $cat->setTitle('Салаты');
        $manager->persist($cat);
        $this->addReference('salad', $cat);


        $cat = new Category();
        $cat->setTitle('Супы');
        $manager->persist($cat);
        $this->addReference('soup', $cat);

        $cat = new Category();
        $cat->setTitle('Второе');
        $manager->persist($cat);
        $this->addReference('main', $cat);

        $cat = new Category();
        $cat->setTitle('Пицца');
        $manager->persist($cat);
        $this->addReference('pizza', $cat);

        $cat = new Category();
        $cat->setTitle('Большие');
        $cat->setParent($this->getReference('pizza'));
        $manager->persist($cat);
        $this->addReference('pizza-big', $cat);

        $cat = new Category();
        $cat->setTitle('Маленькие');
        $cat->setParent($this->getReference('pizza'));
        $manager->persist($cat);
        $this->addReference('pizza-small', $cat);

        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }

}