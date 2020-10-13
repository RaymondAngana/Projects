<?php
/**
*	Form builder. Configure Propco Rewards
*
*	@ingroup forms
*	@see system_settings_form().
*
*/

function propco_rewards_admin_settings(){
	//Get an array of node types to select from 
	$types = node_type_get_types();
	foreach($types as $node_type){
		$options[$node_type->type] = $node_type->name;
	}
	$form['rewards_program_type'] = array(
		'#type' => 'select',
		'#title' => t('Program Node Type'),
		'#options' => $options, 
		'#default_value' => variable_get('propco_rewards_program_type', array('program')),
		'#description' => t('A pin import form will be available on this content type'),
	);
	$form['rewards_program_nogroup_message'] = array(
		'#type' => 'select',
		'#title' => t('Program Node Type'),
		'#options' => $options, 
		'#default_value' => variable_get('rewards_program_nogroup_message', t()),
		'#description' => t('Message to display if no groups have been configured for a program'),
	);
	
	return system_settings_form($form);
 }

