<?php

namespace LunchTime\DeliveryBundle\Features\Context;

use Behat\Mink\Element\DocumentElement;

trait MenuDictionary
{
    protected $menuContainer = '#active-menu';

    /**
     * @Given /^I wait for menu to load$/
     */
    public function iWaitForMenuToLoad()
    {
        $this->getSession()->wait(2000, "$('{$this->menuContainer}').children().length > 0");
    }

    protected function getActiveMenuElement()
    {
        /** @var $page DocumentElement */
        $page = $this->getSession()->getPage();

        return $page->find('css', "{$this->menuContainer}");
    }

    /**
     * @When /^I select "([^"]*)" in active menu$/
     * @Given /^I have selected "([^"]*)" in active menu$/
     */
    public function selectItemsInActiveMenu($titles)
    {
        $titles = self::commaSeparatedArray($titles);
        $menu = $this->getActiveMenuElement();
        foreach ($titles as $title) {
          $this->clickText($title, $menu);
        }
    }

}