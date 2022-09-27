<?php

namespace Drupal\ethan;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\user\EntityOwnerInterface;
use Drupal\Core\Entity\EntityChangedInterface;


interface EthanInterface extends ContentEntityInterface, EntityOwnerInterface, EntityChangedInterface {

}
