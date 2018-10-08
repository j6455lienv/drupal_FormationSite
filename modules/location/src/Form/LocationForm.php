<?php

/**
 * @file
 * Contains Drupal\location\Form\LocationForm
 */

namespace Drupal\location\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Language\Language;

/**
 * Form controller for the locations entity edit forms
 *
 * @ingroup location
 */
class LocationForm extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */

  public function buildForm(array $form, FormStateInterface $form_state) {
    /* @var $entity \Drupal\location\Entity\Location */
    $form = parent::buildForm($form, $form_state);
    $entity = $this->entity;

    $form['langcode'] = array(
      '#title' => $this->t('Language'),
      '#type' => 'language_select',
      '#default_value' => $entity->getUntranslated()->language()->getId(),
      '#languages' => Language::STATE_ALL,
    );
    return $form;
  }

  /**
   * {@inherit}
   */
  public function save(array $form, FormStateInterface $form_state){
    $form_state->setRedirect('entity.location.list');
    $entity = $this->getEntity();
    $entity->save();
  }
}