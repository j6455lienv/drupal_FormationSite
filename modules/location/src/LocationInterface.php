<?php

/**
 * @file
 * Contains \Drupal\location\LocationInterface
 */

namespace  Drupal\location;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface defining a location entity
 *
 * @ingroup location
 */

interface LocationInterface extends ContentEntityInterface, EntityOwnerInterface, EntityChangedInterface{
}