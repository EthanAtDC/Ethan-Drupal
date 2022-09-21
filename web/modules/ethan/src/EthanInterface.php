<?php

namespace Drupal\ethan;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

// An interface for my-content entity
interface EthanInterface extends ContentEntityInterface, EntityOwnerInterface, EntityChangedInterface {

    

}