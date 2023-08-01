<?php

namespace Drupal\mbgna_organization;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;

/**
 * Defines the access control handler for the organization entity type.
 */
class OrganizationAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {

    switch ($operation) {
      case 'view':
        return AccessResult::allowedIfHasPermission($account, 'view organization');

      case 'update':
        return AccessResult::allowedIfHasPermissions(
          $account,
          ['edit organization', 'administer organization'],
          'OR',
        );

      case 'delete':
        return AccessResult::allowedIfHasPermissions(
          $account,
          ['delete organization', 'administer organization'],
          'OR',
        );

      default:
        // No opinion.
        return AccessResult::neutral();
    }

  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermissions(
      $account,
      ['create organization', 'administer organization'],
      'OR',
    );
  }

}
