<?php

namespace Drupal\ethan\Form;

use Drupal;
use Drupal\Core\Form\FormBase;
use Drupal\ethan\Entity\Ethan;
use Drupal\Core\Form\FormStateInterface;
use Drupal\ethan\EthanInterface;

/**
 * Provides a ethan form.
 */
class EthanBasicForm extends FormBase {

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

    // $entity = $this->Ethan;

    $form['message'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Message'),
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

    // $entity = $this->getEntity();

    $form = [
      'type' => 'field_content', 
      'title' => 'Title', 
      'uid' => 1
    ];
    $node = Drupal::entityTypeManager()
      ->getStorage('node')
      ->create($form);
    $node->save();

  }

}
