<?php

namespace Drupal\dhlapi\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class DhlApiForm.
 */
class DhlApiForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'dhl_api_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = \Drupal::config('dhlapi.dhlapiconfig');
    $request = \Drupal::request()->query->all();
    $form_state->setMethod('GET');
    $country = ['' => '-- none --',/*'GB' => 'United Kindon',*/ 'DE' => 'Germany'];
    $form['country'] = [
      '#type' => 'select',
      '#title' => $this->t('Country'),
      '#weight' => '0',
      '#options' => $country,
      '#default_value' => @$request['country'],
      '#required' => true,
      '#description' => t('select country')
    ];
    $city = [
      '' => '-- none --',
      /*'London' => 'London',
      'Manchester' => 'Manchester',
      'Birmingham' => 'Birmingham',*/
      'Bonn' => 'Bonn',
      'Leipzig' => 'Leipzig',
      'Ruhr' => 'Ruhr',
      'Düsseldorf' => 'Düsseldorf' ,
      'Stuttgart' => 'Stuttgart',
      'München' => 'Munich',
      'Dresden' => 'Dresden',
      'Hanover' => 'Hanover'
      ];
    $form['city'] = [
      '#type' => 'select',
      '#title' => $this->t('City'),
      '#weight' => '0',
      '#options' => $city,
      '#default_value' => @$request['city'],
      '#required' => true,
      '#description' => t('example: Munich')
    ];
    $form['postcode'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Postcode'),
      '#weight' => '0',
      '#default_value' => @$request['postcode']?$request['postcode']:'',
      '#required' => true,
      '#description' => t('example: 2323')
    ];
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];
    $form['options']['reset'] = array(
      '#type' => 'submit',
      '#value' => t('Reset'),
      '#submit' => array('dhlapi_form_reset'),
    );

    return $form;
  }

  function dhlapi_form_reset($form, &$form_state) {
    $form_state['rebuild'] = FALSE;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    foreach ($form_state->getValues() as $key => $value) {
      // @TODO: Validate fields.
    }
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Display result.
    foreach ($form_state->getValues() as $key => $value) {
      \Drupal::messenger()->addMessage($key . ': ' . ($key === 'text_format'?$value['value']:$value));
    }
  }

}
