<?php

namespace Drupal\ethan\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Returns responses for ethan routes.
 */
class EthanController extends ControllerBase {

  /**
   * Builds the response.
   */
  public function build() {

    $build['content'] = [
      '#type' => 'item',
      '#markup' => $this->t('It works!'),
    ];

    return $build;
  }

}
