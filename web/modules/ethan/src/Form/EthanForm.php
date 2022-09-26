<?php

namespace Drupal\ethan\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a ethan form.
 */
class EthanForm extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form = parent::buildForm($form, $form_state);
    $entity = $this->entity;

    $form['message'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Message'),
      'default_value' => $entity,
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
