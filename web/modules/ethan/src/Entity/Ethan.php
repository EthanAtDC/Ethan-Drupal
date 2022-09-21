<?php

namespace Drupal\ethan\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\ethan\EthanInterface;
use Drupal\migrate_drupal\Plugin\migrate\source\ContentEntity;
use Drupal\user\EntityOwnerTrait;

/**
 * Defines the my-content entity class.
 *
 * @ContentEntityType(
 *   id = "ethan",
 *   label = @Translation("my-content"),
 *   label_collection = @Translation("my-contents"),
 *   label_singular = @Translation("my-content"),
 *   label_plural = @Translation("my-contents"),
 *   label_count = @PluralTranslation(
 *     singular = "@count my-contents",
 *     plural = "@count my-contents",
 *   ),
 *   handlers = {
 *     "list_builder" = "Drupal\ethan\EthanListBuilder",
 *     "views_data" = "Drupal\views\EntityViewsData",
 *     "form" = {
 *       "add" = "Drupal\ethan\Form\EthanForm",
 *       "edit" = "Drupal\ethan\Form\EthanForm",
 *       "delete" = "Drupal\Core\Entity\ContentEntityDeleteForm",
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\Core\Entity\Routing\AdminHtmlRouteProvider",
 *     }
 *   },
 *   base_table = "ethan",
 *   admin_permission = "administer ethan",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid",
 *     "owner" = "uid",
 *   },
 *   links = {
 *     "collection" = "/admin/content/ethan",
 *     "add-form" = "/entity-content/add",
 *     "canonical" = "/entity-content/{ethan}",
 *     "edit-form" = "/entity-content/{ethan}/edit",
 *     "delete-form" = "/entity-content/{ethan}/delete",
 *   },
 *   field_ui_base_route = "entity.ethan.settings",
 * )
 */

class Ethan extends ContentEntityBase implements EthanInterface {

    use EntityChangedTrait;
    use EntityOwnerTrait;

    public function preSave(EntityStorageInterface $storage)
    {
        parent::preSave($storage);

        // If no owner then anoymous user
        if(!$this->getOwner()) {
            $this->setOwnerId(0);
        }
    }

    public static function baseFieldDefinitions(EntityTypeInterface $entity_type)
    {
        
        $fields = parent::baseFieldDefinitions($entity_type);


        $fields['label'] = BaseFieldDefinition::create('string')
            ->setLabel(t('Label'))
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

    $fields['description'] = BaseFieldDefinition::create('text_long')
      ->setLabel(t('Description'))
      ->setDisplayOptions('form', [
        'type' => 'text_textarea',
        'weight' => 10,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('view', [
        'type' => 'text_default',
        'label' => 'above',
        'weight' => 10,
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
      ->setDescription(t('The time that the my-content was created.'))
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
      ->setDescription(t('The time that the my-content was last edited.'));

    return $fields;    

    }


}