<?php
/**
 * Standard post content.
 */


// Helper variables.

	$args = ( ! isset( $helper ) ) ? ( null ) : ( array( 'helper' => $helper ) );

?>

<?php do_action( 'tha_entry_before', $args ); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php do_action( 'tha_entry_top', $args ); ?>

	<div class="entry-content">

		<?php do_action( 'tha_entry_content_before', $args ); ?>

		<?php

		if ( is_single() ) {
			the_content();
		} else {
			print strip_tags(get_the_excerpt(), '<img>');
		}

		?>

		<?php do_action( 'tha_entry_content_after', $args ); ?>

	</div>

	<?php do_action( 'tha_entry_bottom', $args ); ?>

</article>

<?php do_action( 'tha_entry_after', $args ); ?>
