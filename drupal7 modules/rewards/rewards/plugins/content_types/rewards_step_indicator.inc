<?php

/**
* This plugin array describes our prlugin panel
*/
$plugin = array(
  // the title in the admin
  'title' => t('Award Selection Step Indicator'),
  'single' => TRUE,
  'category' => array(t('Propco Rewards'), -9),
  'render callback' => 'propco_rewards_step_type_render',
  'required context' => new ctools_context_required(t('Node'), 'node'),
  'edit form' => 'propco_rewards_step_type_edit_form',
  // Pn Panels this is the preview pane shown on the panels building page.
  'admin info' => 'propco_rewards_step_type_info',
  'defaults' => array(
    'active-step' => 'complete',
  ),
);



/**
 * Callback to provide administrative info (the preview in panels when building
 * a panel).
 */
function propco_rewards_step_type_admin_info($subtype, $conf, $contexts){
  if (!empty($conf)) {
    $block = new stdClass;
    $block->content = $conf['active-step'];
    return $block;
  }

}

/**
 * 'Edit' callback for the content type.
 * 
 *
 */
function propco_rewards_step_type_edit_form($form, &$form_state) {
  $conf = $form_state['conf'];
  
  $form['active-step'] = array(
    '#type' => 'select',
    '#title' => t('Select Active Step.'),
    '#options' => array(
      'survey' => t('Survey'),
      'complete' => t('Complete'),
    ),
    '#description' => t('Select form step to show as "active" on this page.'),
    '#default_value' => $conf['active-step'],
  );
  
  return $form;
}

function propco_rewards_step_type_edit_form_submit($form, &$form_state) {
  foreach (element_children($form) as $key) {
    if (!empty($form_state['values'][$key])) {
      $form_state['conf'][$key] = $form_state['values'][$key];
    }
  }
}


/**
* Run-time rendering of the form
* See ctools_plugin_examples for more advanced info
*/

function propco_rewards_step_type_render($subtype, $conf, $panel_args, $context){

  
  if (empty($context) || empty($context->data)) {
    return;
  }
  
  $output = new stdClass();
  $output->module = 'propco_rewards';
  $output->delta = $context->data->nid;
  $output->title = t('Program Selection Indicator');

  $program = $context->data;

  $program_wrapper = entity_metadata_wrapper('node', $program);

  //get our award groups for selection
  $program_groups = array();
  $step_indicator = array();

  foreach ($program_wrapper->field_award_groups->value() as $award_group) {
    $step_indicator[] = array('title' => $award_group->title,
        'active'=>FALSE,);
  }
  $step_indicator[] = array('title' => t('Customer Information'), 'active'=>'',);

  $step_indicator[] = array('title' => t('Reviews'), 'active'=>'',);

  if($program_wrapper->field_survey->value()){
  
    $step_indicator[] = array('title' => t('Survey (Optional)'),
        'active'=>$conf['active-step'] == 'survey' ? 'active' : '',);
  }

  $step_indicator[] = array('title' => t('Complete'),
    'active'=>$conf['active-step'] == 'complete' ? 'active' : '',);
  
  $indicator_render = propco_award_redemption_step_indicator($step_indicator);
  

  
  $output->content = '<div id="step_indicator_wrapper">'.$indicator_render.'</div>';
  
  return $output;

}
