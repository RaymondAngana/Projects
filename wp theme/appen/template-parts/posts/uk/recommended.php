<?php
    $args = [
        'post_type' => 'uk_blog',
        'post_status' => 'publish',
        'posts_per_page' => 3,
        'exclude' => get_the_ID()
    ];

	$categories = get_the_terms(get_the_ID(), 'uk_blog_category');
    // $tags = get_the_terms(get_the_ID(), 'uk_blog_tags');

    if ( !empty( $categories ) ) {
        $content_type_term = array_shift($categories);
        $category_name = $content_type_term->name;

        $args['tax_query'] = [
            [
                'taxonomy' => 'uk_blog_category',
                'field' => 'term_id',
                'terms' => $content_type_term->term_id
            ]
        ];
    } else {
        $category_name = __( 'Blogs', 'appen' );
    }

    $posts = get_posts($args);

    if ( !empty( $posts ) ) :
?>

<section class="recommended recommended__cards">
    <div class="appen-wrap" brightfunnel trigger="scroll">
        <h2><?php printf( __( 'Other %1$s you might like', 'appen' ), strtolower( $category_name ) ); ?></h2>
        <div class="swiper-container js-resourse-slider js-recommended">
            <div class="swiper-wrapper recommended__featured-list recommended__slider">
            	<?php foreach( $posts as $post ) : ?>
	                <div class="swiper-slide recommended__featured-item">
	                    <div class="recommended__featured-img">
		                    <?php
		                    if ( has_post_thumbnail( $post->ID ) ) {
			                    echo wp_get_attachment_image( get_post_thumbnail_id( $post->ID ), appen_is_amp() ? 'medium_large': 'recommended' );
		                    }
		                    ?>
	                    </div>
	                    <h3><?php echo $category_name; ?></h3>
	                    <p><?php echo $post->post_title; ?></p>
	                    <a class="recommended__read-more" href="<?php echo get_the_permalink( $post->ID ); ?>"><?php _e( 'Read More', 'appen' ); ?></a>
	                </div>
	            <?php endforeach; ?>
            </div>
            <div class="recommended__bottom">
                <a href="<?php echo isset($content_type_term) ? get_term_link( $content_type_term ) : get_post_type_archive_link('uk_blog'); ?>" class="btn btn-o"><span><?php _e( 'All', 'appen' ); ?> <?php echo $category_name; ?></span></a>
                <div class="recommended__navigation">
                    <div class="recommended__navigation-prev-btn recommended-arrow js-recommended-prev"></div>
                    <div class="recommended__navigation-next-btn recommended-arrow js-recommended-next"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php endif; ?>