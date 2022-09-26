<?php

namespace Drupal\ethan\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Language\Language;

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

    $form['langcode'] = [
      '#title' => $this->t('Language'),
      '#type' => 'language_select',
      '#default_value' => $entity->getUntranslated()->language()->getId(),
      '#languages' => Language::STATE_ALL,
    ];
    return $form;

  }

  public function save(array $form, FormStateInterface $form_state)
  {
    $this->messenger()->addStatus($this->t('The form has been sent.'));
    $entity = $this->getEntity();
    $entity->save();
  }

}
