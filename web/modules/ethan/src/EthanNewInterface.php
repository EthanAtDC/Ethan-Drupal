<?php

namespace Drupal\ethan;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface defining an ethan_new entity type.
 */
interface EthanNewInterface extends ContentEntityInterface, EntityOwnerInterface, EntityChangedInterface {

}
