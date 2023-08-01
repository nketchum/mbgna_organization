<?php

namespace Drupal\mbgna_organization\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\mbgna_organization\OrganizationInterface;
use Drupal\user\EntityOwnerTrait;

/**
 * Defines the organization entity class.
 *
 * @ContentEntityType(
 *   id = "organization",
 *   label = @Translation("Organization"),
 *   label_collection = @Translation("Organizations"),
 *   label_singular = @Translation("organization"),
 *   label_plural = @Translation("organizations"),
 *   label_count = @PluralTranslation(
 *     singular = "@count organizations",
 *     plural = "@count organizations",
 *   ),
 *   bundle_label = @Translation("Organization type"),
 *   handlers = {
 *     "list_builder" = "Drupal\mbgna_organization\OrganizationListBuilder",
 *     "views_data" = "Drupal\views\EntityViewsData",
 *     "access" = "Drupal\mbgna_organization\OrganizationAccessControlHandler",
 *     "form" = {
 *       "add" = "Drupal\mbgna_organization\Form\OrganizationForm",
 *       "edit" = "Drupal\mbgna_organization\Form\OrganizationForm",
 *       "delete" = "Drupal\Core\Entity\ContentEntityDeleteForm",
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\Core\Entity\Routing\AdminHtmlRouteProvider",
 *     }
 *   },
 *   base_table = "organization",
 *   admin_permission = "administer organization types",
 *   entity_keys = {
 *     "id" = "id",
 *     "bundle" = "bundle",
 *     "label" = "label",
 *     "uuid" = "uuid",
 *     "owner" = "uid",
 *   },
 *   links = {
 *     "collection" = "/admin/content/organization",
 *     "add-form" = "/org/add/{organization_type}",
 *     "add-page" = "/org/add",
 *     "canonical" = "/org/{organization}",
 *     "edit-form" = "/org/{organization}/edit",
 *     "delete-form" = "/org/{organization}/delete",
 *   },
 *   bundle_entity_type = "organization_type",
 *   field_ui_base_route = "entity.organization_type.edit_form",
 * )
 */
class Organization extends ContentEntityBase implements OrganizationInterface {

  use EntityChangedTrait;
  use EntityOwnerTrait;

  /**
   * {@inheritdoc}
   */
  public function preSave(EntityStorageInterface $storage) {
    parent::preSave($storage);
    if (!$this->getOwnerId()) {
      // If no owner has been set explicitly, make the anonymous user the owner.
      $this->setOwnerId(0);
    }
  }

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {

    $fields = parent::baseFieldDefinitions($entity_type);

    $fields['label'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Name'))
      ->setRequired(TRUE)
      ->setSetting('max_length', 255)
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -5,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'string',
        'weight' => -5,
      ])
      ->setDisplayConfigurable('view', TRUE);

    $fields['status'] = BaseFieldDefinition::create('boolean')
      ->setLabel(t('Status'))
      ->setDefaultValue(TRUE)
      ->setSetting('on_label', 'Enabled')
      ->setDisplayOptions('form', [
        'type' => 'boolean_checkbox',
        'settings' => [
          'display_label' => FALSE,
        ],
        'weight' => 0,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('view', [
        'type' => 'boolean',
        'label' => 'above',
        'weight' => 0,
        'settings' => [
          'format' => 'enabled-disabled',
        ],
      ])
      ->setDisplayConfigurable('view', TRUE);

    $fields['uid'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Author'))
      ->setSetting('target_type', 'user')
      ->setDefaultValueCallback(static::class . '::getDefaultEntityOwner')
      ->setDisplayOptions('form', [
        'type' => 'entity_reference_autocomplete',
        'settings' => [
          'match_operator' => 'CONTAINS',
          'size' => 60,
          'placeholder' => '',
        ],
        'weight' => 15,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'author',
        'weight' => 15,
      ])
      ->setDisplayConfigurable('view', TRUE);

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Authored on'))
      ->setDescription(t('The time that the organization was created.'))
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'timestamp',
        'weight' => 20,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('form', [
        'type' => 'datetime_timestamp',
        'weight' => 20,
      ])
      ->setDisplayConfigurable('view', TRUE);

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the organization was last edited.'));

    return $fields;
  }

}
