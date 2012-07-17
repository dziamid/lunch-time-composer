# features/menu.feature
Feature: menu
  In order to make an order for today
  As a logged-in customer
  I need to be able to view the menu for today

  @javascript
  Scenario: Display menu for today
    Given the database is clean
    Given there are menu items:
      | title               | price | category |
      | Борщ                | 10500 | Супы     |
      | Куриный суп с рисом | 12000 | Супы     |
      | Рассольник          | 8500  | Супы     |
    Given there are menus:
      | date       | items               |
      | 2012-07-16 | Борщ, Рассольник    |
      | 2012-07-17 | Куриный суп с рисом |
      | 2012-07-18 | Борщ                |
    Given I am on homepage
    And I wait for menu to load
    When I follow "July 16"
    Then I should see "Menu for July 16"
    And I should not see "Menu for July 18"
