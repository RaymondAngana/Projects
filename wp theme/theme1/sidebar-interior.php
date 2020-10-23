<?php
/**
 * Interior Pages sidebar template
 *
 * @package    PrometSource Inc.
 * @copyright  PrometSource Inc., Raymond Angana
 *
 * @since    1.0
 * @version  1.0.0
 */





/**
 * Requirements check
 */

	if ( ! is_active_sidebar( 'sidebar-interior' ) ) {
		return;
	}



/**
 * Output
 */

	do_action( 'tha_sidebars_before' );

	?>

	<aside id="secondary" class="widget-area sidebar" aria-labelledby="sidebar-label">

		<h2 class="screen-reader-text" id="sidebar-label"><?php echo esc_attr_x( 'Sidebar Interior', 'Sidebar aria label', 'polyclinic' ); ?></h2>

		<?php

		do_action( 'tha_sidebar_top' );

		dynamic_sidebar( 'sidebar-interior' );

		do_action( 'tha_sidebar_bottom' );

		?>

	</aside>

	<?php

	do_action( 'tha_sidebars_after' );
