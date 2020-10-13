<?php

/**
* This plugin array describes our prlugin panel
*/
$plugin = array(
  // the title in the admin
  'title' => t('Award Selection Form'),
  'single' => TRUE,
  'category' => array(t('Propco Rewards'), -9),
  'render callback' => 'propco_rewards_program_selection_render',
  'required context' => new ctools_context_required(t('Node'), 'node'),
);

/**
* Run-time rendering of the form
* See ctools_plugin_examples for more advanced info
*/

function propco_rewards_program_selection_render($subtype, $conf, $panel_args, $context){

  
  if (empty($context) || empty($context->data)) {
    return;
  }
  
  $output = new stdClass();
  $output->module = 'propco_rewards';
  $output->delta = $context->data->nid;
  $output->title = t('Program Selection');

  $program = $context->data;

  $form = drupal_get_form('propco_rewards_program_selection_form', $program);
  
  $output->content = drupal_render($form);
  
  return $output;

}
