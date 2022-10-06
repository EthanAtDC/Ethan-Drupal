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
      $this->t('ID'),
      $this->t('UUID'),
      $this->t('CONTENT'),
    ];

    $storage = $this->entityTypeManager->getStorage('ethan');
    /** @var \Drupal\ethan\Entity\Ethan[] $entities */
    $entities = $storage->loadMultiple();
    

    if (!empty($entities)) {
      foreach ($entities as $entity) {
        $rows[] = [
          'id' => $entity->id(),
          'uuid' => $entity->uuid(),
          'content' => $entity->getContent(),
        ];
      }
      $content['table'] = [
        '#type' => 'table',
        '#header' => $headers,
        '#rows' => $rows,
        '#empty' => $this->t('Entities here:')
      ];

      $form['entry_list'] = $content;
    }

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
 
    $entity = Ethan::create([
      'title' => 'Title ' . time(),
      'uuid' => 'UUID ' . time(),
    ]);
    $entity->set('content', [
      'value' => $form_state->getValue('message'),
    ]);
    $entity->save($form);

  }

  public function save(array $form, FormStateInterface $form_state) 
  {

    $entity = $this->getEntity();

  }


}
