<?php

/**
 * @file
 * Contains products\products.views.inc..
 * Provide a custom views field data that isn't tied to any other module. */


/**
* Implements hook_views_data().
*/
function products_views_data() {

    $data['views']['table']['group'] = t('Custom Global');
    $data['views']['table']['join'] = [
      // #global is a special flag which allows a table to appear all the time.
      '#global' => [],
    ];

    $data['views']['add_remove_views_field'] = [
        'title' => t('Add remove views field'),
        'help' => t('Field to manage if product is added or removed.'),
        'field' => [
            'id' => 'add_remove_views_field',
        ],
    ];
    return $data;
}
