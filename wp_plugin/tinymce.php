<?php

// Register the script
wp_register_script( 'widendam', plugin_dir_url( __FILE__ ) . 'js/tinymce-widen-button.js' );
 
// Localize the script with new data
$pass_token = array(
    'token' => get_option('widen_access_token'),
);
wp_localize_script( 'widendam', 'Token', $pass_token );
 
function widendam_scripts() {
	// Enqueued script with localized data.
	wp_enqueue_script( 'widendam' );

}
wp_enqueue_script( 'widendam' );


/**
* Adds a TinyMCE plugin compatible JS file to the TinyMCE / Visual Editor instance
*
* @param array $plugin_array Array of registered TinyMCE Plugins
* @return array Modified array of registered TinyMCE Plugins
*/
function widen_add_tinymce_plugin( $plugin_array ) {
 
	$plugin_array['widendam_iframe'] = plugin_dir_url( __FILE__ ) . 'js/tinymce-widen-button.js';
	return $plugin_array;
 
}

/**
* Adds a button to the TinyMCE / Visual Editor which the user can click
* to insert a link with a custom CSS class.
*
* @param array $buttons Array of registered TinyMCE Buttons
* @return array Modified array of registered TinyMCE Buttons
*/
function widen_add_tinymce_toolbar_button( $buttons ) {
 
	array_push( $buttons, '|', 'widendam_iframe' );
	return $buttons;
}

?>