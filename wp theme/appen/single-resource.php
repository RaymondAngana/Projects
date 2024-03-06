<?php

if ( get_field('resource_type') == 'Corporate Governance' || 
	 get_field('resource_type') == 'Financial Reports' || 
	 get_field('resource_type') == 'Data Sheets') {
		$url = get_field('resource_file_link')['url'];
		wp_redirect( $url );
		die();
}

x_get_view( x_get_stack(), 'wp', 'single' );