<?php

namespace Drupal\ethan\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a ethan form.
 */
class EthanForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'ethan_ethan';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['contacts'] = array(
      '#type' => 'table',
      '#header' => array( 
        $this->t('Name'),
        $this->t('Phone'),
      ),
    );
    for ($i = 1; $i <= 2; $i++) {
      $form['contacts'][$i]['#attributes'] = array(
        'class' => array(
          'someone',
          'something',
        ),
      );
      $form['contacts'][$i]['name'] = array(
        '#type' => 'textfield',
        '#title' => $this->t('Name'),
        '#title_display' => 'invisible',
      );
    }

    $form['contacts'][]['colspan_example'] = array(
      '#wrapper_attributes' => array(
        'colspan' => 1,
        'class' => array(
          'someone',
          'something',
        ),
      ),

    );

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
    // if (mb_strlen($form_state->getValue('contacts')) < 5) {
    //   $form_state->setErrorByName('contacts', $this->t('Message should be at least 5 characters.'));
    // }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->messenger()->addStatus($this->t('The form has been sent.'));
    // $form_state->setRedirect('<front>');
  }

}
