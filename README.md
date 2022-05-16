# HTA

Technical Assessment 05/22. OOP PHP.

## Brief

The checkout system allows users to pay upfront for products added to their property management agreement. The system should also allow users to take advantage of special offers. An initial offer will be “users who have agreed to a 12-month contract are entitled to a 10% discount off the basket total”

The products are below:

| Product Code | Name             | Price |
|--------------|------------------|-------|
| P001         | Photography      | 200   |
| P002         | Floorplan        | 100   |
| P003         | Gas Certificate  | 83.50 |
| P004         | EICR Certificate | 51.00 |

Your job is to implement the basket which should have the following interface:

1. Basket can be initialised with offer(s) user is eligible for
2. It has an add method to add a product
3. Each individual product can only be added to the basket one time
4. It has a total method that returns the total cost of the basket - remember to take into account any valid offers

## Running the Application

Run locally, or make commands described below.

![make](https://raw.githubusercontent.com/alistaircol/hta/main/.github/make.png)

## Tests

![make test](https://raw.githubusercontent.com/alistaircol/hta/main/.github/make_tests.png)

## Coverage

![make coverage](https://raw.githubusercontent.com/alistaircol/hta/main/.github/make_coverage.png)


![coverage](https://raw.githubusercontent.com/alistaircol/hta/main/.github/coverage.png)

## Summary

Using `spatie/data-transfer-objects` to create a basket containing products, and optionally discounts/offers. 
