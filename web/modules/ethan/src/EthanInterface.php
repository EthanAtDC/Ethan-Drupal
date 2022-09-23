<?php

namespace Drupal\ethan;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\user\EntityOwnerInterface;
use Drupal\Core\Entity\EntityChangedInterface;

/**
 * Provides an interface defining a Ethan entity.
 *
 * We have this interface so we can join the other interfaces it extends.
 *
 * @ingroup ethan
 */
interface EthanInterface extends ContentEntityInterface, EntityOwnerInterface, EntityChangedInterface {

}
