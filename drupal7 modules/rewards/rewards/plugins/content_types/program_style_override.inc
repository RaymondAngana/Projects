<?php

/**
* This plugin array describes our prlugin panel
*/
$plugin = array(
  // the title in the admin
  'title' => t('Style Overrides'),
  'single' => TRUE,
  'content_types' => 'programoverride_content_type',
  'category' => array(t('Propco Rewards'), -9),
  'render callback' => 'program_style_override_render',
  'required context' => new ctools_context_required(t('Node'), 'node'),
  'edit form' => 'program_style_override_edit_form',
  // Pn Panels this is the preview pane shown on the panels building page.
  'admin info' => 'program_style_override_admin_info',
  'defaults' => array(
    'program-overrides' => '',
  ),
  'all contexts' => TRUE,
);


/**
 * Callback to provide administrative info (the preview in panels when building
 * a panel).
 */
function program_style_override_admin_info($subtype, $conf, $contexts){
  if (!empty($conf)) {
    $block = new stdClass;
    $block->content = $conf['program-overrides'];
    return $block;
  }

}

/**
* Run-time rendering of the form
*/

function program_style_override_render($subtype, $conf, $panel_args, $context){
  
  if (empty($context)) {
    return;
  }

  $node =  $context['argument_entity_id:node_1']->data;

  
  $parent_wrapper = entity_metadata_wrapper('node', $node);

  $design_node = $parent_wrapper->field_design->value();
  if(empty($design_node)){
    return;
  }

  //$design_wrapper = entity_metadata_wrapper('node', $design_node);

  $overrides = array();
  
 
  $output = new stdClass();
  $output->module = 'propco_rewards';
  
  /* field_page_background_color */
  $overrides['page-background-color'] = $design_node->field_page_background_color[LANGUAGE_NONE][0]['rgb'];
  
  /* field_content_background_color */ 
  $overrides['content-background-color'] = $design_node->field_content_background_color[LANGUAGE_NONE][0]['rgb'];

  /* field_hero_image */
  $overrides['hero-image'] = file_create_url($design_node->field_hero_image['und'][0]['uri']);
  
  /* field_header_font_color */
  $overrides['header-font-color'] = $design_node->field_header_font_color[LANGUAGE_NONE][0]['rgb'];

  /* field_font_color */
  $overrides['font-color'] = $design_node->field_font_color[LANGUAGE_NONE][0]['rgb'];

  /* field_header_background_color‎ */
  $overrides['header-background-color'] = $design_node->field_header_background_color[LANGUAGE_NONE][0]['rgb'];

  /* field_primary_color */
  $overrides['primary-color'] = $design_node->field_primary_color[LANGUAGE_NONE][0]['rgb'];

  /* field_secondary_color */
  $overrides['secondary-color'] = $design_node->field_secondary_color[LANGUAGE_NONE][0]['rgb'];

  /* field_highlight_color */
  $overrides['highlight-color'] = $design_node->field_highlight_color[LANGUAGE_NONE][0]['rgb'];

  /* field_highlight_light_color */
  $overrides['highlight-light-color'] = $design_node->field_highlight_light_color[LANGUAGE_NONE][0]['rgb'];

  $output->content = propco_award_redemption_program_style_overrides($overrides);
  
  return $output;

}


/**
 * 'Edit' callback for the content type.
 * This example just returns a form.
 *
 */
function program_style_override_edit_form($form, &$form_state) {
  $conf = $form_state['conf'];

  /*
  $form['program-overrides'] = array(
    '#type' => 'textarea',
    '#title' => t('Enter style overrides.')
    '#description' => t('Override default styles using program design specs.'),
    '#default_value' => $conf['program-overrides'],
  );
  */
  return $form;
}

function program_style_override_edit_form_submit($form, &$form_state) {
  foreach (element_children($form) as $key) {
    if (!empty($form_state['values'][$key])) {
      $form_state['conf'][$key] = $form_state['values'][$key];
    }
  }
}
