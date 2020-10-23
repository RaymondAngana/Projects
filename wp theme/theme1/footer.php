<?php
/**
 * Website footer template
 *
 * @package    Polyclinic
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0
 * @version  1.0
 */





/**
 * Content
 */

	do_action( 'tha_content_bottom' );

	do_action( 'tha_content_after' );



/**
 * Footer
 */

	if ( ! apply_filters( 'wmhook_polyclinic_disable_footer', false ) ) {

		do_action( 'tha_footer_before' );

		do_action( 'tha_footer_top' );

		do_action( 'tha_footer_bottom' );

		do_action( 'tha_footer_after' );

	}



/**
 * Body and WordPress footer
 */

	do_action( 'tha_body_bottom' );

	wp_footer();

?>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-134252038-1"></script>
<script>
window.dataLayer = window.dataLayer || [];
function gtag(){dataLayer.push(arguments);}
gtag('js', new Date());
gtag('config', 'UA‌-134252038-1');
</script>

</body>

</html>
