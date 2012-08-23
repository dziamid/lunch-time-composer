<?php

namespace LunchTime\DeliveryBundle\Features\Context;
use Behat\MinkExtension\Context\MinkDictionary;

trait OrderDictionary
{
    protected $orderContainer = '#active-order';

    protected $orderCategorySelector = '#active-order .lt-category';

    //use MinkDictionary;
    /**
     * Checks, that element with specified CSS contains specified text.
     *
     * @Then /^(?:|I )should see "(?P<text>(?:[^"]|\\")*)" in the order$/
     */
    public function assertOrderContainsText($text)
    {
        $this->assertElementContainsText($this->getOrderContainer(), $text);
    }

    /**
     * @Given /^(?:|I )should see only one section in the order$/
     */
    public function iShouldSeeOnlyOneSection()
    {
        $this->assertNumElements(1, $this->getOrderCategorySelector());
    }

    protected function getOrderContainer()
    {
        return $this->orderContainer;
    }

    protected function getOrderCategorySelector()
    {
        return $this->orderCategorySelector;
    }

    /**
     * @Given /^I wait for orders to save$/
     */
    public function waitForAjax()
    {
        //todo: add condition when button label is not "Loading..."
        $this->getSession()->wait(5000, "window.__ajaxStatus !== 'in-flight'");
    }

}