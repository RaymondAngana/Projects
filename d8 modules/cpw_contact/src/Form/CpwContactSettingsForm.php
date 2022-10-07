<?php

namespace Drupal\cpw_contact\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class implementation for CpwContactSettingsForm.
 */
class CpwContactSettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {

    return 'cpw_contact_form';

  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form = parent::buildForm($form, $form_state);

    $config = $this->config('cpw_contact.settings');

    $form['iframe_source'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Iframe source'),
      '#default_value' => $config->get('cpw_contact.iframe_source'),
      '#required' => FALSE,
    ];

    return $form;

  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    $config = $this->config('cpw_contact.settings');

    $config->set('cpw_contact.iframe_source', $form_state->getValue('iframe_source'));

    $config->save();

    return parent::submitForm($form, $form_state);

  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {

    return [
      'cpw_contact.settings',
    ];

  }

}
