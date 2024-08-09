<?php

namespace Drupal\dhlapi\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class DhlApiConfigForm.
 */
class DhlApiConfigForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'dhlapi.dhlapiconfig',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'dhl_api_config_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('dhlapi.dhlapiconfig');
    $form['base_url'] = [
      '#type' => 'textfield',
      '#title' => $this->t('API Base URL'),
      '#maxlength' => 128,
      '#size' => 64,
      '#default_value' => $config->get('base_url'),
      '#description' => t('example: https://api.dhl.com/'),
    ];
    $form['endpoint'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Endpoint'),
      '#maxlength' => 128,
      '#size' => 64,
      '#default_value' => $config->get('endpoint'),
      '#description' => t('example: location-finder/v1/find-by-address'),
    ];
    $form['api_key'] = [
      '#type' => 'textfield',
      '#title' => $this->t('API Key'),
      '#maxlength' => 128,
      '#size' => 64,
      '#default_value' => $config->get('api_key'),
      '#description' => t('example: 0GAteVkYArCOZB2dz9eg7S6ipQfvugqp7ng1p'),
    ];
    $form['api_secret'] = [
      '#type' => 'textfield',
      '#title' => $this->t('API Secret'),
      '#maxlength' => 128,
      '#size' => 64,
      '#default_value' => $config->get('api_secret'),
      '#description' => t('example: oxW95OLVZ23kj23jh4hivld'),
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $this->config('dhlapi.dhlapiconfig')
      ->set('base_url', $form_state->getValue('base_url'))
      ->set('endpoint', $form_state->getValue('endpoint'))
      ->set('api_key', $form_state->getValue('api_key'))
      ->set('api_secret', $form_state->getValue('api_secret'))
      ->save();
  }

}
