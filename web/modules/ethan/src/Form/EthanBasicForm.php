<?php

namespace Drupal\ethan\Form;

use Drupal;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Form\FormBase;
use Drupal\ethan\Entity\Ethan;
use \Drupal\node\Entity\Node;
use Drupal\Core\Form\FormStateInterface;
use Drupal\ethan\EthanInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a ethan form.
 */
class EthanBasicForm extends FormBase {

  /**
   * @var Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  public function __construct(EntityTypeManagerInterface $entity_type_manager) {
    $this->entityTypeManager = $entity_type_manager;
  }

  public static function create(ContainerInterface $container) {
    return new static($container->get('entity_type.manager'));
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() 
  {
    return 'ethan_ethan_basic';
  }


  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {


    $form['message'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Create Content here:'),
      '#required' => TRUE,
    ];

    $form['actions'] = [
      '#type' => 'actions',
    ];
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Send'),
    ];

    $content = [];
    $rows = [];
    $headers = [
      $this->t('CONTENT'),
    ];

    $storage = $this->entityTypeManager->getStorage('ethan');
    /** @var \Drupal\ethan\Entity\Ethan[] $entities */
    $entities = $storage->loadMultiple();

    // print 'ENTITIES => ' . print_r($entities, TRUE);

    if (!empty($entities)) {
      foreach ($entities as $entity) {
        $rows[] = [
          'id' => $entity->id(),
          'uuid' => $entity->uuid(),
          'content' => $entity->getContent(),
        ];
      }
    }

    print 'ROWS => ' .print_r($rows, true);

    // WORKING HERE

    // This is where we grab the data from the db and display it for the user
    // $entries = $this->repository->load();

    // Defining to remove warn
    // $entries = [];

    // foreach ($entries as $entry) {
    // // Sanitize each entry.
    // $rows[] = array_map('Drupal\Component\Utility\Html::escape', (array) $entry);
    // }
    // $content['table'] = [
    //   '#type' => 'table',
    //   '#header' => $headers,
    //   '#rows' => $rows,
    //   '#empty' => $this->t('No Ethan entities created'),
    // ];

    // $form['entry_list'] = $content;

    // END WORKING HERE

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    if (mb_strlen($form_state->getValue('message')) < 10) {
      $form_state->setErrorByName('message', $this->t('Message should be at least 10 characters.'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->messenger()->addStatus($this->t('The message has been sent.'));
 

    // WORKING HERE

    // Not sending content to entity?
    $entity = Ethan::create([
      'title' => 'Title ' . time(),
      'uuid' => 1,
    ]);
    $entity->set('content', [
      'value' => $form_state->getValue('message'),
    ]);
    $entity->save($form);
    // parent::submitForm($form, $form_state);



    // # Create Node entity -> Pass it the machine name of our form
    // $node = Node::create([
    //   'type' => 'my_new_content', 
    //   'title' => 'Title ' . time(),
    //   // 'field_content' => $form_state->getValue('task'),
    //   'uid' => 1,
    // ]);

    // // # Retrieve the field data and form state for the node
    // $node->set('field_content', $form_state->getValue('message'));
    // // $node->set('field_content', "THIS IS BAD");

    // # Save the node
    // $node->save();

    // END WORKING HERE

  }

  // Need function save to save entity?
  // Submit will call save where save grabs the entity
  public function save(array $form, FormStateInterface $form_state) 
  {

    $entity = $this->getEntity();

  }


}
