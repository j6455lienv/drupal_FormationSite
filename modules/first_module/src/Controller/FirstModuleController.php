<?php

/**
 * @file
 * Contains \Drupal\first_module\Controller\FirstModuleController
 */

namespace Drupal\first_module\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Url;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

/**
 * Controller routines for first module routes
 */
class FirstModuleController extends ControllerBase {

//  public static function create(ContainerInterface $container) {
//    return new static($container->get('module_handler'))
//  }

  public function FirstModulePage() {
    $build = [
      '#type' => 'markup',
      '#markup' => t('Hello world from Julien !!!'),
    ];

    return $build;
  }
}