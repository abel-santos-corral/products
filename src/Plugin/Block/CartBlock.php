<?php

namespace Drupal\products\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Config\ConfigFactoryInterface;

/**
 * Provides a 'CartBlock' block.
 *
 * @Block(
 *  id = "cart_block",
 *  admin_label = @Translation("Cart block"),
 * )
 */
class CartBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * Drupal\Core\Config\ConfigFactoryInterface definition.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    $instance = new static($configuration, $plugin_id, $plugin_definition);
    $instance->configFactory = $container->get('config.factory');
    return $instance;
  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
    ] + parent::defaultConfiguration();
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    // Initialize build array.
    $build = [];
    // Get configuration.
    $config = \Drupal::config('muprespa_headquarter.settings');
    // Construct the array for twig.
    $build['#theme'] = 'cart_block';
    // $build['#content'][] = $this->configuration['proceed_checkout'];
    // Construct image array.
    // Image class data.
    $imgClass = $config->get('cart-block.img.class');
    if ($imgClass) {
      $build['#img']['class'] = replace(","," ",$imgClass);
    }
    // Image source data.
    $imgSrc = $config->get('cart-block.img.src');
    if ($imgSrc) {
      $build['#img']['src'] = $imgSrc;
    }
    // Image alternative text data.
    $imgAlt = $config->get('cart-block.img.alt');
    if ($imgAlt) {
      $build['#img']['alt'] = $imgAlt;
    }
    // Image height data.
    $imgHeight = $config->get('cart-block.img.height');
    if ($imgHeight) {
      $build['#img']['height'] = $imgHeight;
    }
    // Image width data.
    $imgWidth = $config->get('cart-block.img.width');
    if ($imgWidth) {
      $build['#img']['width'] = $imgWidth;
    }
    // Construct button array.
    // Button class data.
    $buttonClass = $config->get('cart-block.button.class');
    if ($buttonClass) {
      $build['#button']['class'] = replace(","," ",$buttonClass);
    }
    // Button text data.
    $buttonText = $config->get('cart-block.button.width');
    if ($buttonText) {
      $build['#button']['text'] = $buttonText;
    }
    // Button href data.
    $buttonHref = $config->get('cart-block.button.href');
    if ($buttonHref) {
      $build['#button']['href'] = $buttonHref;
    }
    return $build;
  }

}
