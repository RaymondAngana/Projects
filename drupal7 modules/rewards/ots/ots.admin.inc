<?php
/**
 * @file
 * Admin configuration pages for propco_ots integration.
 */

/**
 * Admin ots form.
 */
function propco_ots_admin_api_form($form, &$form_state) {
  $form = array();

  $form['message'] = array(
    '#markup' => '<p>' . t('This page contains variables that are used to interact with Cigna/Affinion OTS files. Please do not make any changes if its not necessary.') . '</p>',
  );

  $form['entry_access_code'] = array(
    '#type' => 'textfield',
    '#title' => 'Entry Access Code',
    '#default_value' => variable_get('ots_entry_access_code'),
  );

  $form['operator_id'] = array(
    '#type' => 'textfield',
    '#title' => 'Operator Id',
    '#default_value' => variable_get('ots_operator_id'),
  );

  $form = system_settings_form($form);
  $form['#submit'][] = 'propco_ots_admin_api_form_submit';

  return $form;
}


/**
 * Form submit handler.
 */
function propco_ots_admin_api_form_submit($form_id, &$form_state) {
  variable_set('ots_entry_access_code', $form_state['values']['entry_access_code']);
  variable_set('ots_operator_id', $form_state['values']['operator_id']);
}
