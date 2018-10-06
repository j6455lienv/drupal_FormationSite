<?php

/**
 * @file
 * Contains Drupal\first_module\Form\FirstForm
 */

namespace Drupal\first_module\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class FirstForm extends FormBase {

  /**
   * Getter method Form ID
   * The Form ID used in implementations of hook_form_alter() to allow other
   * modules to alter the render array built by the form controller. It must
   * be unique site wide. It normally starts with the providing module's name.
   *
   * @return string The unique ID ot the form defined by the class
   */

  public function getFormId() {
    return 'first_module_simple_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['firstname'] = [
      '#type' => 'textfield',
      '#title' => $this->t('First name'),
      '#description' => $this->t('Type in the first name of the candidiate.'),
      '#required' => TRUE,
    ];

    $form['lastname'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Last name'),
      '#description' => $this->t('Type in the last name of the candidiate.'),
      '#required' => TRUE,
    ];

    $form['action'] = [
      '#type' => 'action',
    ];

    $form['action']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];

    return $form;
  }

  /**
   * Form submission handler.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $firstname = $form_state->getValue('firstname');
    $lastname = $form_state->getValue('lastname');

    drupal_set_message(t('Candidate %firstname %lastname was added.', [
        '%firstname' => $firstname,
        '%lastname' => $lastname,
      ]
    ));
  }

  public function validateForm(array &$form, FormStateInterface $form_state) {
//    dsm($form_state);
    $firstname = $form_state->getValue('firstname');

    if (strlen($firstname) < 3) {
      $form_state->setErrorByName('firstname', $this->t('The first name must be at least 3 characters long.'));
    }
  }
}