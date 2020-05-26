<?php

namespace Drupal\products\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Drupal\node\Entity\Node;

/**
 * Class CartForm.
 */
class CartForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'cart_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    // Call service to obtain the products from cookie
    $products = \Drupal::service('products.cookie')->getCookie('products');
    // When products are retrieved, process them.
    if ($products) {
      // Rearrange the products array.
      foreach ($products as $product) {
        $productId = str_replace('check-product-', '', $product);
        // Load node.
        $productEntity = Node::load($productId);
        $titleNode = $productEntity->getTitle();
        $priceNode = $productEntity->field_product_unit_price->value;
        $priceOfferNode = $productEntity->field_product_offer_price->value;
        $unitOfferNode = $productEntity->field_product_minumum_units->value;
        // Container of product.
        $form['product-' . $productId] = [
          '#type' => 'container',
          '#prefix' => '<div class="product-unit">',
          '#suffix' => '</div>',
        ];
        // Label of product.
        $form['product-' . $productId]['label' . $productId] = [
          '#type' => 'label',
          '#title' => $titleNode,
          '#prefix' => '<h2 class="product-title">',
          '#suffix' => '</h2>',
        ];
        // Label of price.
        $priceLine = "Unit price : " . $priceNode . "€";
        if ($unitOfferNode) {
          $priceLine = $priceLine . " | Offer price : " . $priceOfferNode
          . "€ from " . $unitOfferNode . " unit(s)";
        }
        $form['product-' . $productId]['price' . $productId] = [
          '#type' => 'label',
          '#title' => $priceLine,
        ];
        $form['product-' . $productId]['number_items' . $productId] = [
          '#type' => 'number',
          '#title' => $this->t('Number of Items'),
          '#default_value' => '1',
          '#min' => 0,
          '#max' => 50,
          '#step' => 1,
        ];
        $form['product-' . $productId]['product-data' . $productId] = array(
          '#type' => 'hidden',
          '#required' => TRUE,
          '#value' => $productArray,
        );
      }
    }
    else {
      // Set message of no products in the shopping cart.
      \Drupal::messenger()->addMessage($this->t('No products in the shopping cart. Please take a look to our products.'));
      // Otherwise, return to products page.
      return new RedirectResponse(Url::fromRoute('view.product_products.page_products')->toString());
    }

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Place Order'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    foreach ($form_state->getValues() as $key => $value) {
      // @TODO: Validate fields.
    }
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Display result.
    foreach ($form_state->getValues() as $key => $value) {
      \Drupal::messenger()->addMessage($key . ': ' . ($key === 'text_format'?$value['value']:$value));
    }
  }

}
