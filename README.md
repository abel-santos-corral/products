# Module-name module

# CONTENTS OF THIS FILE

* [Introduction](#introduction)
* [Requirements](#requirements)
* [Recommended modules](#recommended-modules)
* [Installation](#installation)
* [Configuration](#configuration)
* [Use cases](#use-cases)
* [Menus](#menus)
* [CSS and Javascript](#css-and-js)
* [Views](#views)
* [Blocks](#blocks)
* [Testing](#testing)
* [Further reading](#further-reading)

## INTRODUCTION

This module manages all the life cycle of a product and a shopping cart.

## REQUIREMENTS

No special requirements.


## RECOMMENDED MODULES

If the module has sub-modules, add them here.

## INSTALLATION

* Install as you would normally install a coustom Drupal module.
 See: https://www.drupal.org/node/895232 for further information.

 * Go to products root folder and tape:

 > composer install

 * Check that composer installs dependency of _madmurphy/cookies_

### DEPENDENCIES

 * This module uses a third party library to manage cookies.js at:

 > [cookies.js](https://github.com/madmurphy/cookies.js)

### Dependencies

* See [products.info.yml](cnfig/products.info.yml). Part of the structure has been packaged via features module.

## CONFIGURATION

No configuration is needed.

## USE CASES

Explain in as many sections as needed the most relevant use cases for the module.
Add unique id's to every use case to use it anywhere else.

Explain it using something similar to Gherkin language (as if for Behat test case).
[Further details of Gherkin here!](https://cucumber.io/docs/gherkin/reference/)

## MENUS

Add a basic list of menu entries created in the module for a better understanding.
If linked to a given use case, add a marked related to the use case.

## CSS AND JAVASCRIPT

Add a basic list of css and javascript elements and its use for better understanding.
If linked to a given use case, add a marked related to the use case.

## VIEWS

### View Products

* System name: product_products

* Display name: page_products

* Purpose: Display to provide a page that will show agrid of products with a full pager.

* Functionality: This view shows a grid of 3 columns and 3 rows. Each element displays the product's name, small image and a short description. Is provides a button that links to the detail product page.

### View Product

* System name: product_products

* Display name: page_product_unitary

* Purpose: Display to provide a page with a single product.

* Functionality: This view shows a product with its details.

## BLOCKS

Add a basic list of views and its use for better understanding.
If linked to a given use case, add a marked related to the use case.

## TESTING

Add a basic list of tests that are performed on this module.

## FURTHER READING

Add a list of readings and links that could be helpful.

### Further reading

### Links
