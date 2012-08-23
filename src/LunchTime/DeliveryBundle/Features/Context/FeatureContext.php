<?php

namespace LunchTime\DeliveryBundle\Features\Context;

use Symfony\Component\HttpKernel\KernelInterface;
use Behat\Symfony2Extension\Context\KernelAwareInterface;
use Behat\MinkExtension\Context\MinkDictionary;

use Behat\Behat\Context\BehatContext,
Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
Behat\Gherkin\Node\TableNode;

use Behat\Symfony2Extension\Context\KernelDictionary;
use Doctrine\ORM\EntityManager;
use Behat\Mink\Exception\ElementNotFoundException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

//
// Require 3rd-party libraries here:
//
//   require_once 'PHPUnit/Autoload.php';
//   require_once 'PHPUnit/Framework/Assert/Functions.php';
//

/**
 * Feature context.
 */
class FeatureContext extends BehatContext
{
    use KernelDictionary, MinkDictionary, MenuDictionary, BackgroundDictionary, OrderDictionary;

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
     * @return EntityManager
     */
    protected function getEntityManager()
    {
        return $this->getContainer()->get('doctrine')->getEntityManager();
    }

    /**
     * Clicks on the first element that contains specified text.
     *
     * @When /^(?:|I )click on "(?P<link>(?:[^"]|\\")*)"$/
     */
    public function clickText($text, $parent = null)
    {
        if (null === $parent) {
            $parent = $this->getSession()->getPage();
        }

        $element = $parent->find('xpath', '//*[text()="'.$text.'"]');

        if (null === $element) {
            throw new ElementNotFoundException(
                $this->getSession(), 'any', 'text', $text
            );
        }

        $element->click();
    }


    protected static function commaSeparatedArray($value)
    {
        return array_map('trim', explode(",", $value));
    }

}
