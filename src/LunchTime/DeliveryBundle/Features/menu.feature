# features/menu.feature
Feature: menu
  In order to make an order for today
  As a logged-in customer
  I need to be able to view the menu for today

  Background:
    Given the database is clean
    Given there are menu items:
      | title               | price | category |
      | Борщ                | 10500 | Супы     |
      | Куриный суп с рисом | 12000 | Супы     |
      | Рассольник          | 8500  | Супы     |
      | Eggs                | 14000 | Main   |
      | Meat                | 24000 | Main   |
    Given there are menus:
      | date       | items               |
      | 2012-07-16 | Борщ, Рассольник    |
      | 2012-07-17 | Куриный суп с рисом |
      | 2012-07-18 | Борщ, Eggs, Meat    |
    Given there are companies:
      | title    | token    |
      | Taucraft | taucraft |
    Given there are clients:
      | name   | email            | phone          | token  | company  |
      | Кирилл | kirill@gmail.com | +3754412312312 | kirill | Taucraft |


  @javascript
  Scenario: On homepage a customer can see a menu for today
    Given I am on homepage
    And I wait for menu to load
    When I follow "Июль 18"
    Then I should see "Меню на Июль 18"
    And I should not see "Меню на Июль 17"
  #test cookies
    When I reload the page
    Then I should see "Меню на Июль 18"

  @javascript
  Scenario: On his private page a customer can add items to order,
    adding two items from the same category results in only one category in the order
    Given I am on "/client/kirill"
    And I wait for menu to load
    When I click on "Eggs"
    And I click on "Meat"
    Then I should see "Eggs" in the order
    And I should see only one section in the order

