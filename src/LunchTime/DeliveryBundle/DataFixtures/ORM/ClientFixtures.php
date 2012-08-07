<?php
namespace LunchTime\DeliveryBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;

use LunchTime\DeliveryBundle\Entity\Client;

class ClientFixtures extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $client = new Client();

        $client->setName('Иван Демидович');
        $client->setCompany($this->getReference('company-taucraft'));
        $this->setReference('client-1', $client);
        $manager->persist($client);

        $client->setName('Демид Владимирович');
        $client->setCompany($this->getReference('company-taucraft'));
        $manager->persist($client);

        $client->setName('Кирилл Липский');
        $client->setCompany($this->getReference('company-taucraft'));
        $manager->persist($client);

        $manager->flush();

    }

    public function getOrder()
    {
        return 2;
    }

}