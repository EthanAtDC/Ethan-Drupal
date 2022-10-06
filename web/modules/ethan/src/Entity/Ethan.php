<?php

namespace Drupal\ethan\Entity;

use Drupal\ethan\EthanInterface;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\user\UserInterface;
use Drupal\Core\Entity\EntityChangedTrait;

/**
 * Defines the ethan_new entity class.
 *
 * @ContentEntityType(
 *   id = "ethan",
 *   handlers = {
 *     "list_builder" = "Drupal\ethan\EthanNewListBuilder",
 *     "views_data" = "Drupal\views\EntityViewsData",
 *     "form" = {
 *       "default" = "Drupal\ethan\Form\EthanBasicForm",
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\Core\Entity\Routing\AdminHtmlRouteProvider",
 *     }
 *   },
 *   base_table = "ethan",
 *   admin_permission = "administer ethan",
 *   entity_keys = {
 *     "id" = "id",
 *     "uuid" = "uuid",
 *   }
 * )
 *
 */
class Ethan extends ContentEntityBase implements EthanInterface {

    use EntityChangedTrait;

    public static function preCreate(EntityStorageInterface $storage, array &$values)
    {
        parent::preCreate($storage, $values);

    }

    public function preSave(EntityStorageInterface $storage)
    {
        parent::preSave($storage);

        if (!$this->getOwnerId())
        {
            $this->setOwnerId(0);
        }

    }

    /**
     * {@inheritdoc}
     */
    public function getContent()
    {
        return $this->get('content')->first()->value;
    }
    /**
     * {@inheritdoc}
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    public function getOwner()
    {
        // return $this->get('user_id')->entity;
    }

    public function getOwnerId()
    {
        // return $this->get('user_id')->target_id;
    }

    public function setOwner(UserInterface $account)
    {
        // $this->set('user_id', $account->id());
        // return $this;
    }

    public function setOwnerId($uid)
    {
        // $this->set('user_id', $uid);
        // return $this;
    }



    public static function baseFieldDefinitions(EntityTypeInterface $entity_type)
    {

        // Standard field, used as unique if primary index.
        $fields['id'] = BaseFieldDefinition::create('integer')
        ->setLabel(t('ID'))
        ->setDescription(t('nothing'))
        ->setReadOnly(TRUE)
        ->setRequired(FALSE);

        // Standard field, unique outside of the scope of the current project.
        $fields['uuid'] = BaseFieldDefinition::create('uuid')
        ->setLabel(t('UUID'))
        ->setDescription(t('Nothing'))
        ->setReadOnly(TRUE)
        ->setRequired(FALSE);


        $fields['content'] = BaseFieldDefinition::create('text_long')
            ->setLabel(t('Content'))
            ->setDescription(t('The content entered by our user'))
            ->setSettings([
                'max_length' => 135,
                'text_processing' => 0,
            ])
            ->setDefaultValue(NULL)
            ->setDisplayOptions('view', [
                'label' => 'above',
                'type' => 'string',
                'weight' => -6,
            ])
            ->setDisplayOptions('form', [
                'type' => 'string_textfield',
                'weight' => -6,
            ])
            ->setDisplayConfigurable('form', TRUE)
            ->setDisplayConfigurable('view', TRUE);
            // ->setRequired(FALSE);

        return $fields;
    }

}
