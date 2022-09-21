<?php

namespace Drupal\ethan\src\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

class EthanEntityForm extends ContentEntityForm {

    public function save(array $form, FormStateInterface $form_state)
    {
        $result = parent::save($form, $form_state);

        $entity = $this->getEntity();

        $message_arguments = ['%label' => $entity->toLink()->toString()];
        $logger_arguments = [
            '%label' => $entity->label(),
            'link' => $entity->toLink($this->t('View'))->toString(),
        ];
        switch ($result) {
            case SAVED_NEW:
                $this->messenger()->addStatus($this->t('New my-content %label has been created.', $message_arguments));
                $this->logger('ethan')->notice('Created new my-content %label', $logger_arguments);
                break;
        case SAVED_UPDATED:
            $this->messenger()->addStatus($this->t('The my-content %label has been updated.', $message_arguments));
            $this->logger('ethan')->notice('Updated my-content %label.', $logger_arguments);
            break;
        }
        $form_state->setRedirect('entity.ethan.canonical', ['ethan' => $entity->id()]);

        return $result;

    }

}