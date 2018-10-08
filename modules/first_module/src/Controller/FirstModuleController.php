<?php

namespace Drupal\first_module\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Controller routines for first module routes.
 */
class FirstModuleController extends ControllerBase {

  // Public static function create(ContainerInterface $container) {
  //    return new static($container->get('module_handler'))

  /**
   * }.
   */
  public function FirstModulePage() {
    $build = [
      '#type' => 'markup',
      '#markup' => t('Hello world from Julien !!!'),
    ];

    return $build;
  }

}
