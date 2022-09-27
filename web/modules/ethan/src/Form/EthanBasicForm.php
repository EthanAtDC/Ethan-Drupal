<?php

namespace Drupal\ethan\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;
use Drupal\user\Entity\User;

/**
 * Provides a ethan form.
 */
class EthanBasicForm extends ContentEntityForm {

  protected $entity;

  /**
   * {@inheritdoc}
   */
  public function getEntity() 
  {
    return $this->entity;
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) 
  {

    $form = parent::buildForm($form, $form_state);
    $entity = $this->entity;
    $ethan = $this->entity;

    $form['message'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Message'),
      'default_value' => $this->entity->get('uid') == NULL ? NULL : User::load($this->entity->get('uid')),
      '#required' => TRUE,
    ];

    $form['actions'] = [
      '#type' => 'actions',
    ];
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Send'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state)
  {
    $this->messenger()->addStatus($this->t('The message has been sent.'));
    $entity = $this->getEntity();
    $entity->save();
  }


}