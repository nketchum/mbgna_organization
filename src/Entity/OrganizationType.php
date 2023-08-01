<?php

namespace Drupal\mbgna_organization\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Defines the Organization type configuration entity.
 *
 * @ConfigEntityType(
 *   id = "organization_type",
 *   label = @Translation("Organization type"),
 *   label_collection = @Translation("Organization types"),
 *   label_singular = @Translation("organization type"),
 *   label_plural = @Translation("organizations types"),
 *   label_count = @PluralTranslation(
 *     singular = "@count organizations type",
 *     plural = "@count organizations types",
 *   ),
 *   handlers = {
 *     "form" = {
 *       "add" = "Drupal\mbgna_organization\Form\OrganizationTypeForm",
 *       "edit" = "Drupal\mbgna_organization\Form\OrganizationTypeForm",
 *       "delete" = "Drupal\Core\Entity\EntityDeleteForm",
 *     },
 *     "list_builder" = "Drupal\mbgna_organization\OrganizationTypeListBuilder",
 *     "route_provider" = {
 *       "html" = "Drupal\Core\Entity\Routing\AdminHtmlRouteProvider",
 *     }
 *   },
 *   admin_permission = "administer organization types",
 *   bundle_of = "organization",
 *   config_prefix = "organization_type",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "add-form" = "/admin/structure/organization_types/add",
 *     "edit-form" = "/admin/structure/organization_types/manage/{organization_type}",
 *     "delete-form" = "/admin/structure/organization_types/manage/{organization_type}/delete",
 *     "collection" = "/admin/structure/organization_types"
 *   },
 *   config_export = {
 *     "id",
 *     "label",
 *     "uuid",
 *   }
 * )
 */
class OrganizationType extends ConfigEntityBundleBase {

  /**
   * The machine name of this organization type.
   *
   * @var string
   */
  protected $id;

  /**
   * The human-readable name of the organization type.
   *
   * @var string
   */
  protected $label;

}
