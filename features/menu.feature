# features/menu.feature
Feature: menu
  In order to make an order for today
  As a logged-in customer
  I need to be able to view the menu for today

  Scenario: Display menu for today
    Given I am on a home page
    When I click "July 18"
    Then I should see "Menu for July 18"
