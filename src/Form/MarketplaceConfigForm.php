<?php

namespace Drupal\products\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class MarketplaceConfigForm.
 */
class MarketplaceConfigForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'products.marketplaceconfig',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'marketplace_config_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('products.marketplaceconfig');
    // Generate part of products configuration.
    // Add container for products configuration.
    $form['products'] = [
      '#type' => 'container',
      '#prefix' => '<div class="products-block-container">',
      '#suffix' => '</div>',
    ];
    $form['products']['label'] = [
      '#type' => 'label',
      '#title' => $this->t('Products general settings'),
      '#attributes' => [
        'class' => 'main-label',
      ],
    ];
    $form['products']['button_proceed'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Text button Proceed'),
      '#description' => $this->t('Add the text of button <i>Proceed to checkout</i>'),
      '#maxlength' => 64,
      '#size' => 64,
      '#default_value' => $config->get('products.button_proceed'),
      '#prefix' => '<div class="marginado">',
      '#suffix' => '</div>',
    ];
    $form['products']['maximum_number_items'] = [
      '#type' => 'number',
      '#title' => $this->t('Maximum number of items'),
      '#description' => $this->t('Add the maximum number of items that are allowed per product type'),
      '#default_value' => $config->get('products.maximum_number_items'),
      '#prefix' => '<div class="marginado">',
      '#suffix' => '</div>',
    ];
    $form['products']['maximum_number_products'] = [
      '#type' => 'number',
      '#title' => $this->t('Maximum number of products'),
      '#description' => $this->t('Add the maximum number of products that are allowed per shopping cart'),
      '#default_value' => $config->get('products.maximum_number_products'),
      '#prefix' => '<div class="marginado">',
      '#suffix' => '</div>',
    ];
    // Generate part of block cart configuration.
    // Add container for products configuration.
    $form['cart'] = [
      '#type' => 'container',
      '#prefix' => '<div class="products-block-container">',
      '#suffix' => '</div>',
    ];
    // Generate sub-part of block cart img field.
    // Label of Checkbox area.
    $form['cart']['img']['label'] = [
      '#type' => 'label',
      '#title' => $this->t('Image settings'),
      '#attributes' => [
        'class' => 'main-label',
      ],
    ];
    // Field img class.
    $form['cart']['img']['img_class'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Class'),
      '#description' => $this->t('Add the comma separated class of the image of block cart'),
      '#maxlength' => 64,
      '#size' => 64,
      '#default_value' => $config->get('cart-block.img.class'),
      '#prefix' => '<div class="marginado">',
      '#suffix' => '</div>',
    ];
    // Field img src.
    $form['cart']['img']['img_src'] = [
      '#type' => 'textfield',
      '#title' => $this->t('SRC'),
      '#description' => $this->t('Add the source of the image of block cart'),
      '#maxlength' => 64,
      '#size' => 64,
      '#default_value' => $config->get('cart-block.img.src'),
      '#prefix' => '<div class="marginado">',
      '#suffix' => '</div>',
    ];
    // Field img alt.
    $form['cart']['img']['img_alt'] = [
      '#type' => 'textfield',
      '#title' => $this->t('ALT'),
      '#description' => $this->t('Add the alt value of the image of block cart'),
      '#maxlength' => 64,
      '#size' => 64,
      '#default_value' => $config->get('cart-block.img.alt'),
      '#prefix' => '<div class="marginado">',
      '#suffix' => '</div>',
    ];
    // Field img heigth.
    $form['cart']['img']['img_height'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Heigth'),
      '#description' => $this->t('Add the heigth of the image of block cart'),
      '#maxlength' => 64,
      '#size' => 64,
      '#default_value' => $config->get('cart-block.img.height'),
      '#prefix' => '<div class="marginado">',
      '#suffix' => '</div>',
    ];
    // Field img width.
    $form['cart']['img']['img_width'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Width'),
      '#description' => $this->t('Add the width of the image of block cart'),
      '#maxlength' => 64,
      '#size' => 64,
      '#default_value' => $config->get('cart-block.img.width'),
      '#prefix' => '<div class="marginado">',
      '#suffix' => '</div>',
    ];
    // Generate sub-part of block cart button field.
    // Label of Checkbox area.
    $form['cart']['button']['label'] = [
      '#type' => 'label',
      '#title' => $this->t('Button settings'),
      '#attributes' => [
        'class' => 'main-label',
      ],
    ];
    // Field button class.
    $form['cart']['button']['button_class'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Class'),
      '#description' => $this->t('Add the comma separated class of the button of block cart'),
      '#maxlength' => 64,
      '#size' => 64,
      '#default_value' => $config->get('cart-block.button.class'),
      '#prefix' => '<div class="marginado">',
      '#suffix' => '</div>',
    ];
    // Field button text.
    $form['cart']['button']['button_text'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Text'),
      '#description' => $this->t('Add the text of the button of block cart'),
      '#maxlength' => 64,
      '#size' => 64,
      '#default_value' => $config->get('cart-block.button.text'),
      '#prefix' => '<div class="marginado">',
      '#suffix' => '</div>',
    ];
    // Field button href.
    $form['cart']['button']['button_href'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Href'),
      '#description' => $this->t('Add the href of the button of block cart'),
      '#maxlength' => 64,
      '#size' => 64,
      '#default_value' => $config->get('cart-block.button.href'),
      '#prefix' => '<div class="marginado">',
      '#suffix' => '</div>',
    ];
    // Attach library to add the style of the form elements.
    $form['#attached']['library'][] = 'products/products_block_styles';
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $this->config('products.marketplaceconfig')
      ->set('products.button_proceed', $form_state->getValue('button_proceed'))
      ->set('products.maximum_number_items', $form_state->getValue('maximum_number_items'))
      ->set('products.maximum_number_products', $form_state->getValue('maximum_number_products'))
      ->set('cart-block.img.class', $form_state->getValue('img_class'))
      ->set('cart-block.img.src', $form_state->getValue('img_src'))
      ->set('cart-block.img.alt', $form_state->getValue('img_alt'))
      ->set('cart-block.img.height', $form_state->getValue('img_height'))
      ->set('cart-block.img.width', $form_state->getValue('img_width'))
      ->set('cart-block.button.class', $form_state->getValue('button_class'))
      ->set('cart-block.button.text', $form_state->getValue('button_text'))
      ->set('cart-block.button.href', $form_state->getValue('button_href'))
      ->save();
  }

}
