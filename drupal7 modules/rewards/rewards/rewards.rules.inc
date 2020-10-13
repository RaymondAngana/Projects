<?php
/**
 * Implement hook_rules_action_info()
 * Declare any meta data about actions for Rules
 */

function propco_rewards_rules_action_info() {
$actions = array(
    'propco_rewards_actions_dbquery' => array(
        'label' => t('Update Pin status'),
        'group' => t('Propco Rules'),
        'parameter' => array(
            
        ),
    ),
    );

    return $actions;

}

          

/** 
 * Function for placing an personalized order
 */

function propco_rewards_actions_dbquery() {

    $num_updated = db_update('node') // Table name no longer needs {}
        ->fields(array(
        'field_pin_status' => 'open',
    ))
    ->condition('field_pin_start', REQUEST_TIME, '>=')
    ->condition('field_pin_status', 'redeemed', '!=')
    ->condition('field_pin_status', 'open', '!=')

    ->execute();

    watchdog('debug', '<pre>'. print_r($num_updated, TRUE) .'</pre>');  

    return;

}
