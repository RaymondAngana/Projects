<?php

/**
* This plugin array describes our plugin panel
*/
$plugin = array(
  // the title in the admin
  'title' => t('Pin Login Form'),
  'single' => TRUE,
  'category' => array(t('Propco Rewards'), -9),
  'render callback' => 'propco_login_pin_login_render', 
);
  
/**
* Run-time rendering of the form
* See ctools_plugin_examples for more advanced info
*/

function propco_login_pin_login_render($subtype, $conf, $context = NULL){
  
  $output = new stdClass();


  $form = drupal_get_form('propco_login_pin_login_form');
  
  $output->content = drupal_render($form);

  
  return $output;

}
