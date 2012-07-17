# features/menu.feature
Feature: menu
  In order to make an order for today
  As a logged-in customer
  I need to be able to view the menu for today

  @javascript
  Scenario: Display menu for today
    Given there are menu items:
      | title               | price |
      | Борщ                | 10500 |
      | Куриный суп с рисом | 12000 |
      | Рассольник          | 8500  |
#    Given there are menus:
#      | due_date   |
#      | 2012-07-16 |
#      | 2012-07-17 |
#      | 2012-07-18 |
    Given I am on homepage
    And I wait for menu to load
    When I follow "July 16"
    Then I should see "Menu for July 16"
    And I should not see "Menu for July 18"
