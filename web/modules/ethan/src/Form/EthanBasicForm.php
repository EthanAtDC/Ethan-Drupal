<?php

namespace Drupal\ethan\Form;

use Drupal;
use Drupal\Core\Form\FormBase;
use Drupal\ethan\Entity\Ethan;
use \Drupal\node\Entity\Node;
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


    $result = parent::save($form, $form_state);
    $entity = $this->getEntity();

    # content = label
    $message_arguments = ['%content' => $entity->toLink()->toString()];
    $logger_arguments = [
      '%content' => $entity->label(),
      'link' => $entity->toLink($this->t('View'))->toString(),
    ];

    switch ($result) 
    {
      case SAVED_NEW:
        $this->messenger()->addStatus($this->t('The message has been sent.'));
        break;
    }

    return $result;

    // # Create Node entity -> Pass it the machine name of our form
    // $node = Node::create([
    //   'type' => 'my_new_content', 
    //   'title' => 'Title ' . time(),
    //   // 'field_content' => $form_state->getValue('task'),
    //   'uid' => 1,
    // ]);

    // # Retrieve the field data and form state for the node
    // $node->set('field_content', $form_state->getValue('message'));
    // // $node->set('field_content', "THIS IS BAD");

    // # Save the node
    // $node->save();

    // $entity = Ethan::create([
    //   'title' => 'Title ' . time(),
    //   // 'field_content' => $form_state->getValue('task'),
    //   'uid' => 1,
    // ]);
    // $entity->set('field_content', $form_state->getValue('message'));
    // $entity->save();


  }

}
