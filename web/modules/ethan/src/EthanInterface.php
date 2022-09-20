<?php

namespace Drupal\ethan;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface defining a my-content entity type.
 */
interface EthanInterface extends ContentEntityInterface, EntityOwnerInterface, EntityChangedInterface {

}
