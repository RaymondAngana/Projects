<?php
/**
 * Page content
 *
 * @package    Polyclinic
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0
 * @version  1.7.0
 */





?>

<?php do_action( 'tha_entry_before' ); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php do_action( 'careersource_modified_entry_top' ); ?>

	<div class="entry-content">

		<?php do_action( 'tha_entry_content_before' ); ?>

		<?php the_content(); ?>

		<?php do_action( 'tha_entry_content_after' ); ?>

	</div>

	<?php do_action( 'tha_entry_bottom' ); ?>

</article>

<?php do_action( 'tha_entry_after' ); ?>
