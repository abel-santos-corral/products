<?php

namespace Drupal\products\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Class CartController.
 */
class CartController extends ControllerBase {

  /**
   * Checkout.
   *
   * @return string
   *   Return Hello string.
   */
  public function checkout() {
    return [
      '#type' => 'markup',
      '#markup' => $this->t('Implement method: checkout')
    ];
  }

}
