<?php

namespace Drupal\ethan;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface defining a cat entity type.
 */
interface CatInterface extends ContentEntityInterface, EntityOwnerInterface, EntityChangedInterface {

}
