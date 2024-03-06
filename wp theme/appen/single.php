<?php

// =============================================================================
// SINGLE.PHP
// -----------------------------------------------------------------------------
// Handles output of individual posts.
//
// Content is output based on which Stack has been selected in the Customizer.
// To view and/or edit the markup of your Stack's posts, first go to "views"
// inside the "framework" subdirectory. Once inside, find your Stack's folder
// and look for a file called "wp-single.php," where you'll be able to find the
// appropriate output.
// =============================================================================

$category_name = get_query_var('category_name');
$categories = get_content_type_categories();

if ( $category_name && $category_name === 'research-papers' ) {
	$url = site_url( '/resources/research-papers/' );
	if($meta = get_post_meta($post->ID, 'research_paper_link', true)){
		$url = esc_url(filter_var($meta, FILTER_VALIDATE_URL));
	}
	wp_redirect( $url );
	exit();
}

if ( $category_name && !empty($categories) && in_array($category_name, $categories) ) {
	if ( file_exists( get_stylesheet_directory() . '/template-parts/posts/content-type--' . $category_name . '.php' ) ) {
		get_template_part( 'template-parts/posts/content-type--' . $category_name );
		return;
	} else {
		get_template_part( 'template-parts/posts/default' );
		return;
	}
}

x_get_view( x_get_stack(), 'wp', 'single' );