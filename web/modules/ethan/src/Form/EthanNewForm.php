<?php

namespace Drupal\ethan\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for the ethan_new entity edit forms.
 */
class EthanNewForm extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $result = parent::save($form, $form_state);

    $entity = $this->getEntity();

    $message_arguments = ['%label' => $entity->toLink()->toString()];
    $logger_arguments = [
      '%label' => $entity->label(),
      'link' => $entity->toLink($this->t('View'))->toString(),
    ];

    switch ($result) {
      case SAVED_NEW:
        $this->messenger()->addStatus($this->t('New ethan_new %label has been created.', $message_arguments));
        $this->logger('ethan')->notice('Created new ethan_new %label', $logger_arguments);
        break;

      case SAVED_UPDATED:
        $this->messenger()->addStatus($this->t('The ethan_new %label has been updated.', $message_arguments));
        $this->logger('ethan')->notice('Updated ethan_new %label.', $logger_arguments);
        break;
    }

    $form_state->setRedirect('entity.ethan_new.canonical', ['ethan_new' => $entity->id()]);

    return $result;
  }

}
