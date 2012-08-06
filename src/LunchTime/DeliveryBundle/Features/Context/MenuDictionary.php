<?php

namespace LunchTime\DeliveryBundle\Features\Context;

trait MenuDictionary
{
    /**
     * @Given /^I wait for menu to load$/
     */
    public function iWaitForMenuToLoad()
    {
        $this->getSession()->wait(2000, "$('#active-menu').children().length > 0");
    }
}