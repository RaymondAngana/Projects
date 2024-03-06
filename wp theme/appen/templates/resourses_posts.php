<?php

if ( $parent = get_category_by_slug('content-types') ) {
	$categories = get_the_category( get_the_ID() );

	foreach ( $categories as $category ) {
		if ( $category->parent == $parent->term_id ) {
			$primary_category = $category;
			break;
		}
	}
} else {
	$post_categories = get_post_primary_category( get_the_ID(), 'category' );
	$primary_category = $post_categories[ 'primary_category' ];
}

$term = get_queried_object();
?>
<a href="<?php echo get_permalink( get_the_ID() ); ?>" class="resourses__featured-item">
	<div class="resourses__featured-img">
		<?php echo get_the_post_thumbnail( get_the_ID(), 'large' ); ?>
	</div>
	<h3><?php echo $primary_category ? $primary_category->name : $term->name; ?></h3>
	<p><?php the_title(); ?></p>
	<span class="resourses__read-more"><?php _e( 'Read More', 'appen' ); ?></span>
</a>