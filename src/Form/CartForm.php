<?php

namespace Drupal\products\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Drupal\node\Entity\Node;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\ReplaceCommand;
use Drupal\Core\Ajax\InvokeCommand;
use Drupal\Core\Ajax\addCommand;

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
      // Initialize products list.
      $productList = [];
      // Rearrange the products array.
      foreach ($products as $product) {
        $productId = str_replace('check-product-', '', $product);
        // Load node.
        $productEntity = Node::load($productId);
        $titleNode = $productEntity->getTitle();
        $priceNode = $productEntity->field_product_unit_price->value;
        $priceOfferNode = $productEntity->field_product_offer_price->value;
        $unitOfferNode = $productEntity->field_product_minumum_units->value;
        $productList[$productId] = [
          'name' => $titleNode,
          'price' => $priceNode,
          'price-offer' => $unitOfferNode,
          'unit-offer' => $unitOfferNode,
        ];
        // Container of product.
        $form['product-' . $productId] = [
          '#type' => 'container',
          '#attributes' => [
            'id' => 'product-' . $productId,
            'class' => 'product-unit',
          ],
        ];
        // Label of product.
        $form['product-' . $productId]['label-' . $productId] = [
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
        $form['product-' . $productId]['price-' . $productId] = [
          '#type' => 'label',
          '#title' => $priceLine,
        ];
        $form['product-' . $productId]['buttonerie-' . $productId] = [
          '#type' => 'container',
          '#prefix' => '<div class="products-buttons-container">',
          '#suffix' => '</div>',
        ];
        $form['product-' . $productId]['buttonerie-' . $productId]['number_items-' . $productId] = [
          '#type' => 'number',
          '#title' => $this->t('Number of Items'),
          '#default_value' => '1',
          '#min' => 1,
          '#max' => 50,
          '#step' => 1,
          '#attributes' => [
            'unit-price' => $priceNode,
            'offer-price' => $priceOfferNode,
            'min-units' => $unitOfferNode,
          ],
          '#size' => 5,
          '#attributes' => [
            'class' => [
              'use-ajax',
            ],
          ],
          '#ajax' => [
            'callback' => [$this, 'changeProductQuantity'],
            'event' => 'change',
            'progress' => [
              'type' => 'throbber',
              'message' => $this->t('...Calculating'),
            ],
            'wrapper' => 'product-change-' . $productId,
          ],
        ];
        $form['product-' . $productId]['buttonerie-' . $productId]['eliminate-' . $productId] = [
          '#type' => 'button',
          '#value' => $this->t('Eliminate Product'),
          '#attributes' => [
            'class' => [
              'use-ajax',
              'button--primary',
            ],
          ],
          '#name' => 'eliminate-' . $productId,
          '#ajax' => [
            'callback' => [$this, 'eliminateProduct'],
            'event' => 'click',
            'progress' => [
              'type' => 'throbber',
              'message' => $this->t('...Planning'),
            ],
            'wrapper' => 'product-' . $productId,
          ],
        ];
      }
      // Add a container for the results area.
      $form['product-' . $productId]['container-' . $productId] = [
        '#type' => 'container',
        '#prefix' => '<div class="container-results">',
        '#suffix' => '</div>',
        '#weight' => -20,
      ];
      // Generate header.
      $header = [
        'product' => t('Product'),
        'price' => t('Price'),
        'units' => t('Units'),
        'applied-offer' => t('Applied offer'),
      ];
      // Gererate rows.
      foreach ($productList as $key => $product) {
        $rows[$key] = [
          'product' => [
            'data' => $product['name'],
            'class' => 'product',
            'id' => 'product-' . $key,
            ],
          'price' => [
            'data' => $product['price'],
            'class' => 'price',
            'id' => 'price-' . $key,
            ],
          'units' => [
            'data' => 1,
            'class' => 'units',
            'id' => 'units-' . $key,
            ],
          'applied-offer' => [
            'data' => FALSE,
            'class' => 'applied-offer',
            'id' => 'applied-offer-' . $key,
            ],
        ];
      }
      // Set the table.
      $form['table'] = [
        '#type' => 'table',
        '#header' => $header,
        '#rows' => $rows,
        '#empty' => $this->t('There is no data yet.'),
      ];
    }
    else {
      // Set message of no products in the shopping cart.
      \Drupal::messenger()->addMessage($this->t('No products in the shopping cart. Please take a look to our products.'));
      // Otherwise, return to products page.
      return new RedirectResponse(Url::fromRoute('view.product_products.page_products')->toString());
    }
    // Submit button.
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Place Order'),
    ];
    // Attach library to add the style of the form elements.
    $form['#attached']['library'][] = 'products/products_cartform_styles';
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

  /**
   * Eliminate a product from cart.
   *
   * @return \Drupal\Core\Ajax\AjaxResponse
   *   Response with form's values emptied.
   */
  public function eliminateProduct(array &$form, FormStateInterface &$form_state) {
    $response = new AjaxResponse();
    $triggeredElement = $form_state->getTriggeringElement();
    $htmlTriggeredElement = $triggeredElement['#attributes']['data-drupal-selector'];
    $idTriggeredElement = str_replace("edit-eliminate-", "product-", $htmlTriggeredElement);
    // If there are any form errors, re-display the form.
    if ($form_state->hasAnyErrors()) {
      $response->addCommand(new ReplaceCommand('#' . $idTriggeredElement, $form));
    }
    else {
      // Call service to obtain the products from cookie
      $products = \Drupal::service('products.cookie')->getCookie('products');
      $productToEliminate = str_replace("edit-eliminate-", "check-product-", $htmlTriggeredElement);
      $products = array_unique($products);
      if (in_array($productToEliminate, $products)) {
        $productsClean = [];
        foreach($products as $producto) {
          if ($producto != $productToEliminate) {
            array_push($productsClean, $producto);
          }
        }
      }
      // Remove element.
      \Drupal::service('products.cookie')->setCookie('products', $productsClean);
      $response->addCommand(new ReplaceCommand('#' . $idTriggeredElement, ""));
    }
    return $response;
  }

  /**
   * Recalculate product quantities and prices.
   *
   * @return \Drupal\Core\Ajax\AjaxResponse
   *   Response with form's values emptied.
   */
  public function changeProductQuantity(array &$form, FormStateInterface &$form_state) {
    $response = new AjaxResponse();
    $triggeredElement = $form_state->getTriggeringElement();
    $htmlTriggeredElement = $triggeredElement['#attributes']['data-drupal-selector'];
    drupal_set_message(time() . " - " . $htmlTriggeredElement);
    drupal_set_message(time() . " - " . json_encode($form_state->getValues()));
    // $idTriggeredElement = str_replace("edit-eliminate-", "product-", $htmlTriggeredElement);
    // If there are any form errors, re-display the form.
    if ($form_state->hasAnyErrors()) {
      $response->addCommand(new ReplaceCommand('#' . $idTriggeredElement, $form));
    }
    else {
      // Get the encrypted|Decrypted message given the data of the form
      $id = '';
      $id = str_replace("edit-number-items-", "", $htmlTriggeredElement);
      drupal_set_message(time() . " - ID :  " . $id);
      $element = '#units-' . $id;
      drupal_set_message(time() . " - Element :  " . $element);
      $value = $form_state->getValue('number_items-' . $id);
      drupal_set_message(time() . " - Value :  " . $value);
      $response->addCommand(new InvokeCommand($element, 'text' , [ $value ]));
    }
    return $response;
  }

}
