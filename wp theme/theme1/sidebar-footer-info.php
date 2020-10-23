<?php
/**
 * Footer info widgets area template
 *
 * Do not set "id" HTML attribute as these widgets
 * can be displayed multiple times on the website.
 *
 * @package    Polyclinic
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0
 * @version  1.7.0
 */





/**
 * Requirements check
 */

	if ( ! is_active_sidebar( 'footer-info' ) ) {
		return;
	}



/**
 * Output
 */

	?>

	<div class="site-footer-area footer-area-footer-info-widgets">

		<div class="footer-info-widgets-inner site-footer-area-inner">

			<aside id="footer-info-widgets" class="widget-area footer-info-widgets" aria-labelledby="footer-info-widgets-label">

				<?php dynamic_sidebar( 'footer-info' ); ?>

			</aside>

		</div>

	</div>
