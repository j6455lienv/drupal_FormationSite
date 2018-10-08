<?php

namespace Drupal\first_bloc\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 *
 */
class FirstBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    return [
      '#markup' => $this->t('Here will come my news !'),
    ];
  }

}
