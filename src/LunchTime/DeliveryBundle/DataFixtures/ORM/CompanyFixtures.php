<?php
namespace LunchTime\DeliveryBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;

use LunchTime\DeliveryBundle\Entity\Company;

class CompanyFixtures extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $company = new Company();

        $company->setTitle('Taucraft');
        $company->setToken(Company::generateToken(10));
        $manager->persist($company);
        $this->setReference('company-taucraft', $company);

        $manager->flush();

    }

    public function getOrder()
    {
        return 6;
    }

}