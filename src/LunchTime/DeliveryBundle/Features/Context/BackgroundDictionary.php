<?php

namespace LunchTime\DeliveryBundle\Features\Context;

use Behat\Gherkin\Node\TableNode;
use Behat\Behat\Exception\PendingException;

use LunchTime\DeliveryBundle\Entity\Menu;
use LunchTime\DeliveryBundle\Entity\Client;
use LunchTime\DeliveryBundle\Entity\Company;

trait BackgroundDictionary
{

    /**
     * @Given /^there are menu items:$/
     */
    public function thereAreMenuItems(TableNode $table)
    {
        $em = $this->getEntityManager();

        $rows = $table->getHash();
        foreach ($rows as $row) {
            $category = $em->getRepository('LTDeliveryBundle:Menu\Category')->findOneBy(array(
                'title' => trim($row['category']),
            ));
            if (false == $category) {
                $category = new Menu\Category();
                $category->setTitle($row['category']);
                $em->persist($category);
            }

            $item = new Menu\Item();
            $item->setTitle($row['title']);
            $item->setPrice($row['price']);
            $item->setCategory($category);
            $em->persist($item);
        }

        $em->flush();
    }

    /**
     * @Given /^there are menus:$/
     */
    public function thereAreMenus(TableNode $table)
    {
        $em = $this->getEntityManager();

        $rows = $table->getHash();
        foreach ($rows as $row) {
            $menu = new Menu();
            $menu->setDueDate(new \DateTime($row['date']));
            $items = explode(',', $row['items']);
            foreach ($items as $title) {
                $item = $em->getRepository('LTDeliveryBundle:Menu\Item')->findOneBy(array(
                    'title' => trim($title),
                ));
                $menu->addItem($item);
            }
            $em->persist($menu);
        }

        $em->flush();
    }

    /**
     * @Given /^the database is clean$/
     */
    public function theDatabaseIsClean()
    {
        $em = $this->getEntityManager();
        $repositories = array('Client\Order\Item', 'Client\Order', 'Menu', 'Menu\Item', 'Client', 'Company');
        foreach ($repositories as $repoName) {
            $objects = $em->getRepository('LTDeliveryBundle:'. $repoName)->findAll();
            foreach ($objects as $object) {
                $em->remove($object);
            }
        }

        $em->flush();

    }

    /**
     * @Given /^there are companies:$/
     */
    public function thereAreCompanies(TableNode $table)
    {
        $em = $this->getEntityManager();

        $rows = $table->getHash();
        foreach ($rows as $row) {
            $company = new Company();
            $company->setTitle($row['title']);

            $em->persist($company);
        }

        $em->flush();
    }

    /**
     * @Given /^there are clients:$/
     */
    public function thereAreClients(TableNode $table)
    {
        $em = $this->getEntityManager();

        $rows = $table->getHash();
        foreach ($rows as $row) {
            $client = new Client();
            $client->setName($row['name']);
            $client->setPhone($row['phone']);
            $client->setEmail($row['email']);
            $client->setToken($row['token']);
            $company = $em->getRepository('LTDeliveryBundle:Company')->findOneBy(array(
                'title' => trim($row['company']),
            ));
            $client->setCompany($company);

            $em->persist($client);
        }

        $em->flush();
    }

}