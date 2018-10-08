<?php

/**
 * @file
 * Contains Drupal\location\Form\LocationSettingsForm.
 */

namespace Drupal\location\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class LocationSettingsForm
 *
 * @package Drupal\location\Form
 * @ingroup location
 */
class LocationSettingsForm extends FormBase {
  /**
   * Returns a unique string identifying the form.
   *
   * @return string
   *  The unique string identifying the form.
   */
  public function getFormId() {
    return 'location_settings';
  }

  /**
   * Form submission handler.
   *
   * @param array $form
   *  An associative array containing the structure of the form.
   * @param FormStateInterface $form_state
   *  An associative array containing the current state ot the form.
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    //Empty implementation of the abstract submit class.
  }

  /**
   * Define the form used for location settings.
   * @return array
   *  Form definition array.
   *
   * @param array $form
   *  An associative array containing the structure of the form.
   * @param FormStateInterface $form_state
   *  An associative array containing the current state of the form.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    // TODO: Implement buildForm() method.
    $form['location_settings']['#markup'] = 'Settings form for location. Manage field settings here.';
    return $form;
  }

}