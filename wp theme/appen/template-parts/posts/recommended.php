<?php
	$category_name = get_query_var('category_name');
    $content_type_term = get_term_by( 'slug', $category_name, 'category' );
    $content_type_name = ( $content_type_term->slug == 'blog' ) ? __( 'Blog Articles', 'appen' ) : $content_type_term->name;

    $posts = get_posts([
    	'post_type' => 'post',
    	'post_status' => 'publish',
    	'posts_per_page' => 3,
    	'category_name' => $category_name,
    	'exclude' => get_the_ID()
    ]);

    if ( !empty( $posts ) ) :
?>

<section class="recommended recommended__cards">
    <div class="appen-wrap" brightfunnel trigger="scroll">
        <h2><?php printf( __( 'Other %1$s you might like', 'appen' ), strtolower( $content_type_name ) ); ?></h2>
        <div class="swiper-container js-resourse-slider js-recommended">
            <div class="swiper-wrapper recommended__featured-list recommended__slider">
            	<?php foreach( $posts as $post ) : ?>
	                <a href="<?php echo appen_is_amp() ? ampforwp_url_controller( get_permalink( $post->ID ) ) : get_the_permalink( $post->ID ); ?>" class="swiper-slide recommended__featured-item">
	                    <div class="recommended__featured-img">
		                    <?php
		                    if ( has_post_thumbnail( $post->ID ) ) {
			                    echo wp_get_attachment_image( get_post_thumbnail_id( $post->ID ), appen_is_amp() ? 'medium_large' : 'recommended' );
		                    }
		                    ?>
	                    </div>
	                    <h3><?php echo $content_type_term->name; ?></h3>
	                    <p><?php echo $post->post_title; ?></p>
	                    <span class="recommended__read-more"><?php _e( 'Read More', 'appen' ); ?></span>
	                </a>
	            <?php endforeach; ?>
            </div>
            <div class="recommended__bottom">
                <a href="<?php echo get_term_link( $content_type_term ); ?>" class="btn btn-o"><span><?php _e( 'All', 'appen' ); ?> <?php echo $content_type_name; ?></span></a>
                <div class="recommended__navigation">
                    <div class="recommended__navigation-prev-btn recommended-arrow js-recommended-prev"></div>
                    <div class="recommended__navigation-next-btn recommended-arrow js-recommended-next"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php endif; ?>