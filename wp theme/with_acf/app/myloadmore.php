<?php

// namespace App;

use Roots\Sage\Container;
use Roots\Sage\Assets\JsonManifest;
use Roots\Sage\Template\Blade;
use Roots\Sage\Template\BladeProvider;

// custom ajax load more
// source: https://rudrastyh.com/wordpress/load-more-posts-ajax.html
function misha_my_load_more_scripts($query, $get_vars) {
	
	// global $query;

	// In most cases it is already included on the page and this line can be removed
	wp_enqueue_script('jquery');

	// register our main script but do not enqueue it yet
	wp_register_script( 'my_loadmore', get_template_directory_uri() . '/assets/scripts/myloadmore.js', array('jquery') );

	// now the most interesting part
	// we have to pass parameters to myloadmore.js script but we can get the parameters values only in PHP
	// you can define variables directly in your HTML but I decided that the most proper way is wp_localize_script()
	wp_localize_script( 'my_loadmore', 'misha_loadmore_params', array(
		'ajaxurl' => site_url() . '/wp-admin/admin-ajax.php', // WordPress AJAX
		'posts' => json_encode( $query->query_vars ), // everything about your loop is here
		'current_page' => get_query_var( 'paged' ) ? get_query_var('paged') : 1,
		'max_page' => $query->max_num_pages,
		'get' => json_encode($get_vars),
		'total' => $query->found_posts,
		'view_more_text' => __('View More', 'ogletree'),
		'all_results_text' => __('All results displayed', 'ogletree'),
		'loading_text' => __('Loading...', 'ogletree')
	) );

 	wp_enqueue_script( 'my_loadmore' );
}
// add_action( 'wp_enqueue_scripts', 'misha_my_load_more_scripts' );

function misha_loadmore_ajax_handler(){

	// prepare our arguments for the query
	$args = json_decode( stripslashes( $_POST['query'] ), true );
	$args['paged'] = $_POST['page'] + 1; // we need next page to be loaded
	$args['post_status'] = 'publish';
	$get_vars = json_decode( stripslashes( $_POST['get']), true );

	// query_posts( $args );
	$query = OD\Search\od_query($args['post_type'], $args['posts_per_page'], $args['paged'], $get_vars);

	if( $query->have_posts() ) :

		// run the loop
		while( $query->have_posts() ): $query->the_post();

			// look into your theme code how the posts are inserted, but you can use your own HTML of course
			if($args['post_type'] === 'od_insight' || $args['post_type'] === 'od_aktuelle') {
				echo \App\template( 'partials.content' );
			} else {
				echo \App\template( 'partials.content-' . get_post_type() );
			}

			// for the test purposes comment the line above and uncomment the below one
			// print '<article>';
			// print '<h2>'.get_the_title().'</h2>';
			// print '<a href="'.get_the_permalink().'" class="button">Read more</a>';
			// print '</article>';


		endwhile;

	endif;
	die; // here we exit the script and even no wp_reset_query() required!
}
add_action('wp_ajax_loadmore', 'misha_loadmore_ajax_handler'); // wp_ajax_{action}
add_action('wp_ajax_nopriv_loadmore', 'misha_loadmore_ajax_handler'); // wp_ajax_nopriv_{action}
