<?php

namespace Drupal\products\Tests;

use Drupal\simpletest\WebTestBase;

/**
 * Provides automated tests for the products module.
 */
class CartControllerTest extends WebTestBase {


  /**
   * {@inheritdoc}
   */
  public static function getInfo() {
    return [
      'name' => "products CartController's controller functionality",
      'description' => 'Test Unit for module products and controller CartController.',
      'group' => 'Other',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    parent::setUp();
  }

  /**
   * Tests products functionality.
   */
  public function testCartController() {
    // Check that the basic functions of module products.
    $this->assertEquals(TRUE, TRUE, 'Test Unit Generated via Drupal Console.');
  }

}
