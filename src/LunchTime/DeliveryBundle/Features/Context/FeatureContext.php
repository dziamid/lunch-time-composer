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

//
// Place your definition and hook methods here:
//
//    /**
//     * @Given /^I have done something with "([^"]*)"$/
//     */
//    public function iHaveDoneSomethingWith($argument)
//    {
//        $container = $this->kernel->getContainer();
//        $container->get('some_service')->doSomethingWith($argument);
//    }
//

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
        $em = $this->getContainer()->get('doctrine')->getEntityManager();

        $rows = $table->getHash();
        foreach ($rows as $row) {
            $item = new Menu\Item();
            $item->setTitle($row['title']);
            $item->setPrice($row['price']);
            $em->persist($item);
        }

        $em->flush();
    }
}
