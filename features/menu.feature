# features/menu.feature
Feature: menu
  In order to make an order for today
  As a logged-in customer
  I need to be able to view the menu for today

  @javascript
  Scenario: Display menu for today
    Given I am on homepage
    And I wait for menu to load
    When I follow "July 18"
    Then I should see "Menu for July 18"
    Then I should not see "Menu for July 17"
