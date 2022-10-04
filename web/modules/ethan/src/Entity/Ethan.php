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
 * Defines the ContentEntityExample entity.
 *
 * @ingroup content_entity_example
 *
 * This is the main definition of the entity type. From it, an EntityType object
 * is derived. The most important properties in this example are listed below.
 *
 * id: The unique identifier of this entity type. It follows the pattern
 * 'moduleName_xyz' to avoid naming conflicts.
 *
 * label: Human readable name of the entity type.
 *
 * handlers: Handler classes are used for different tasks. You can use
 * standard handlers provided by Drupal or build your own, most probably derived
 * from the ones provided by Drupal. In detail:
 *
 * - view_builder: we use the standard controller to view an instance. It is
 *   called when a route lists an '_entity_view' default for the entity type.
 *   You can see this in the entity.content_entity_example_contact.canonical
 *   route in the content_entity_example.routing.yml file. The view can be
 *   manipulated by using the standard Drupal tools in the settings.
 *
 * - list_builder: We derive our own list builder class from EntityListBuilder
 *   to control the presentation. If there is a view available for this entity
 *   from the views module, it overrides the list builder if the "collection"
 *   key in the links array in the Entity annotation below is changed to the
 *   path of the View. In this case the entity collection route will give the
 *   view path.
 *
 * - form: We derive our own forms to add functionality like additional fields,
 *   redirects etc. These forms are used when the route specifies an
 *   '_entity_form' or '_entity_create_access' for the entity type. Depending on
 *   the suffix (.add/.default/.delete) of the '_entity_form' default in the
 *   route, the form specified in the annotation is used. The suffix then also
 *   becomes the $operation parameter to the access handler. We use the
 *   '.default' suffix for all operations that are not 'delete'.
 *
 * - access: Our own access controller, where we determine access rights based
 *   on permissions.
 *
 * More properties:
 *
 *  - base_table: Define the name of the table used to store the data. Make sure
 *    it is unique. The schema is automatically determined from the
 *    BaseFieldDefinitions below. The table is automatically created during
 *    installation.
 *
 *  - entity_keys: How to access the fields. Specify fields from
 *    baseFieldDefinitions() which can be used as keys.
 *
 *  - links: Provide links to do standard tasks. The 'edit-form' and
 *    'delete-form' links are added to the list built by the
 *    entityListController. They will show up as action buttons in an additional
 *    column.
 *
 *  - field_ui_base_route: The route name used by Field UI to attach its
 *    management pages. Field UI module will attach its Manage Fields,
 *    Manage Display, and Manage Form Display tabs to this route.
 *
 * There are many more properties to be used in an entity type definition. For
 * a complete overview, please refer to the '\Drupal\Core\Entity\EntityType'
 * class definition.
 *
 * The following construct is the actual definition of the entity type which
 * is read and cached. Don't forget to clear cache after changes.
 *
 * @ContentEntityType(
 *   id = "content_entity_example_contact",
 *   label = @Translation("Contact entity"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\content_entity_example\Entity\Controller\ContactListBuilder",
 *     "form" = {
 *       "default" = "Drupal\content_entity_example\Form\ContactForm",
 *       "delete" = "Drupal\content_entity_example\Form\ContactDeleteForm",
 *     },
 *     "access" = "Drupal\content_entity_example\ContactAccessControlHandler",
 *   },
 *   list_cache_contexts = { "user" },
 *   base_table = "contact",
 *   admin_permission = "administer contact entity",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "name",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/content_entity_example_contact/{content_entity_example_contact}",
 *     "edit-form" = "/content_entity_example_contact/{content_entity_example_contact}/edit",
 *     "delete-form" = "/contact/{content_entity_example_contact}/delete",
 *     "collection" = "/content_entity_example_contact/list"
 *   },
 *   field_ui_base_route = "content_entity_example.contact_settings",
 * )
 *
 * The 'links' above are defined by their path. For core to find the
 * corresponding route, the route name must follow the correct pattern:
 *
 * entity.<entity_type>.<link_name>
 *
 * Example: 'entity.content_entity_example_contact.canonical'.
 *
 * See the routing file at content_entity_example.routing.yml for the
 * corresponding implementation.
 *
 * The Contact class defines methods and fields for the contact entity.
 *
 * Being derived from the ContentEntityBase class, we can override the methods
 * we want. In our case we want to provide access to the standard fields about
 * creation and changed time stamps.
 *
 * Our interface (see ContactInterface) also exposes the EntityOwnerInterface.
 * This allows us to provide methods for setting and providing ownership
 * information.
 *
 * The most important part is the definitions of the field properties for this
 * entity type. These are of the same type as fields added through the GUI, but
 * they can by changed in code. In the definition we can define if the user with
 * the rights privileges can influence the presentation (view, edit) of each
 * field.
 *
 * The class also uses the EntityChangedTrait trait which allows it to record
 * timestamps of save operations.
 */


class Ethan extends ContentEntityBase implements EthanInterface {

    use EntityChangedTrait;

    public static function preCreate(EntityStorageInterface $storage, array &$values)
    {
        // parent::preCreate($storage_controller, $values);

        // $values += [
        //     'content' => \Drupal::currentUser()->id(),
        // ];
    }

    // public function preSave(EntityStorageInterface $storage)
    // {
    //     parent::preSave($storage);

    //     if (!$this->getOwnerId()) 
    //     {
    //         $this->setOwnerId(0);
    //     }

    // }

    /**
     * {@inheritdoc}
     */
    public function getContent() 
    {
        // return $this->get('content')->entity;
    }
    /**
     * {@inheritdoc}
     */
    public function setContent(UserInterface $content) 
    {
        // $this->content = $content;
        // return $this;
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



        $fields['content'] = BaseFieldDefinition::create('string')
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
            ->setDisplayConfigurable('view', TRUE)
            ->setRequired(FALSE);

        return $fields;
    }

}