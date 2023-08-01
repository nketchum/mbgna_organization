<?php

namespace Drupal\mbgna_organization;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface defining an organization entity type.
 */
interface OrganizationInterface extends ContentEntityInterface, EntityOwnerInterface, EntityChangedInterface {

}
