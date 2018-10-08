<?php

/**
 * @file
 * Contains \Drupal\location\Form\LocationDeleteForm.
 */

namespace Drupal\location\Form;

use Drupal\Core\Entity\ContentEntityConfirmFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

/**
 * Provides a form for deleting a location entity.
 *
 * @ingroup location
 */
class LocationDeleteForm extends ContentEntityConfirmFormBase{
  /**
   * {@inheritdoc}
   */
  public function getQuestion() {
    return $this->t('Are you sure you  want to delete entity %name?', array(
      '%name' => $this->entity->label()
    ));
  }

  /**
   * {@inheritdoc}
   *
   * If the delete command is canceled, return to the contact list.
   */
  public function getCancelUrl() {
    return new Url('entity.location.list');
  }

  /**
   * {@inheritdoc}
   */
  public function getConfirmText() {
    return $this->t('Delete');
  }

  /**
   * {@inherit}
   *
   * Delete the entity and log the event. \Drupal::logger() replaces the watchdog.
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $entity = $this->getEntity();
    $entity->delete();

    \Drupal::logger('location')->notice('@type: delete %title.',
      array(
        '@type' => $this->entity->bundle(),
        '@title' => $this->entity->label(),
      ));
    $form_state->setRedirect('entity.location.list');
  }
}
