<?php

namespace LunchTime\DeliveryBundle\Features\Context;

use Symfony\Component\HttpKernel\KernelInterface;
use Behat\Symfony2Extension\Context\KernelAwareInterface;
use Behat\MinkExtension\Context\MinkContext;

use Behat\Behat\Context\BehatContext,
Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
Behat\Gherkin\Node\TableNode;

use Behat\Symfony2Extension\Context\KernelDictionary;

use LunchTime\DeliveryBundle\Entity\Menu;
use Doctrine\ORM\EntityManager;

//
// Require 3rd-party libraries here:
//
//   require_once 'PHPUnit/Autoload.php';
//   require_once 'PHPUnit/Framework/Assert/Functions.php';
//

/**
 * Feature context.
 */
class FeatureContext extends MinkContext //MinkContext if you want to test web
{
    use KernelDictionary;

    private $parameters;

    /**
     * Initializes context with parameters from behat.yml.
     *
     * @param array $parameters
     */
    public function __construct(array $parameters)
    {
        $this->parameters = $parameters;
    }

    /**
     * @Given /^I wait for menu to load$/
     */
    public function iWaitForMenuToLoad()
    {
        $this->getSession()->wait(2000, "$('#active-menu').children().length > 0");
    }

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
        $menus = $em->getRepository('LTDeliveryBundle:Menu')->findAll();
        foreach ($menus as $menu) {
            $em->remove($menu);
        }
        $items = $em->getRepository('LTDeliveryBundle:Menu\Item')->findAll();
        foreach ($items as $item) {
            $em->remove($item);
        }

        $em->flush();

    }

    /**
     * @return EntityManager
     */
    protected function getEntityManager()
    {
        return $this->getContainer()->get('doctrine')->getEntityManager();
    }

}
