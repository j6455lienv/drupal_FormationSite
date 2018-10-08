<?php

/**
 * @file
 * Contains \Drupal\location\LocationAccessControlHandler.
 */

namespace Drupal\location;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;

/**
 * Access controller for the location entity.
 *
 * @see \Drupal\location\Entity\Location
 */
class LocationAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   *
   * Link the activities to the permissions. CheckAccess is called with the
   * $operation as defined in the routing.yml file.
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    switch ($operation) {
      case 'view':
        return AccessResult::allowedIfHasPermission($account, 'view location entity');
      case 'edit':
        return AccessResult::allowedIfHasPermissions($account, 'edit location entity');
      case 'delete':
        return AccessResult::allowedIfHasPermissions($account, 'delete location entity');
    }
    return AccessResult::allowed();
  }

  /**
   * {@inheritdoc}
   *
   * Separate from the checkAccess because the entity does not yet exist, it
   * will be created during the 'add' process.
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add location entity');
  }
}