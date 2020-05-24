<?php

namespace Drupal\products\Plugin\views\field;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Component\Utility\Random;
use Drupal\views\Plugin\views\field\FieldPluginBase;
use Drupal\views\ResultRow;
use Drupal\Core\Render\Markup;

/**
 * A handler to provide a field that is completely custom by the administrator.
 *
 * @ingroup views_field_handlers
 *
 * @ViewsField("add_remove_views_field")
 */
class AddRemoveViewsField extends FieldPluginBase {

  /**
   * {@inheritdoc}
   */
  public function usesGroupBy() {
    return FALSE;
  }

  /**
   * {@inheritdoc}
   */
  public function query() {
    // Do nothing -- to override the parent query.
  }

  /**
   * {@inheritdoc}
   */
  protected function defineOptions() {
    $options = parent::defineOptions();
    $options['select_field'] = ['default' => NULL];
    return $options;
  }

  /**
   * {@inheritdoc}
   */
  public function buildOptionsForm(&$form, FormStateInterface $form_state) {
    parent::buildOptionsForm($form, $form_state);
    // Allow user to select one field that exist in the list of fields shown.
    $field_options = $this->getPreviousFieldLabels();
    // Once all labels have been chosen, show them.
    $form['select_field'] = [
      '#type' => 'select',
      '#title' => $this->t('Fields'),
      '#description' => $this->t('Field to take the id of check.'),
      '#options' => ['' => ''] + $field_options,
      '#default_value' => $this->options['select_field'],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function render(ResultRow $values) {
    // Get the selected field from view set-up
    $field = $this->options['select_field'];
    $link = $this->t('Not found');
    // Get the field collection from the values.
    $idNode = $this->view->field[$field]->original_value;
    if ($idNode == "" || is_null($idNode) || empty($idNode)) {
      return $link;
    }
    // Add a checkbox vía html.
    $divContainer = '<input data-drupal-selector="check-product-' . $idNode
      . '" type="checkbox" id="check-product-' . $idNode
      . '" name="check-product-'. $idNode .'" value="1" class="form-checkbox product-checkbox">'
      . ' <label for="check-product-' . $idNode
      . '" class="option label-product button buton-action button--primary button--small">' . $this->t('Add to cart') . '</label>';
    $html = Markup::create($divContainer);
    $link = ['#markup' => $html];
    // Return the link.
    return $link;
  }

}
