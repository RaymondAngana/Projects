<?php
/**
 * Custom page template
 *
 * Template Name: Interior Pages
 *
 * @package    PrometSource Inc.
 * @copyright  PrometSource Inc.
 *
 * @since    1.0
 * @version  1.1
 */

/* translators: Custom page template name. */
__( 'Interior Pages', 'polyclinic' );

get_header();

	while ( have_posts() ) : the_post();
		get_template_part( 'template-parts/content', 'page' );
	endwhile;

	get_sidebar('interior');

get_footer();
