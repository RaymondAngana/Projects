<?php
$life_at_appen     = get_field('life_at_appen', 'option');
$term             = get_queried_object();
$featured_section = $life_at_appen ? $life_at_appen['featured_section']: get_field( 'featured_section', $term );
?>
<?php if ( $featured_section['posts'] ) : ?>
    <section class="resourses__featured resourses__cards--big">
        <div class="appen-wrap">
			<?php if ( $featured_section['title'] ) : ?>
                <h2><?php echo $featured_section['title']; ?></h2>
			<?php endif; ?>
            <div class="swiper-container resourses__featured-alternative-container js-webinar-slider">
                <div class="swiper-wrapper resourses__featured-alternative">
					<?php foreach ( $featured_section['posts'] as $post_id ) : ?>
						<?php
						$post_categories  = get_post_primary_category( $post_id, 'life_at_appen_category' );
						$primary_category = $post_categories['primary_category'];
						?>
                        <a href="<?php echo get_permalink( $post_id ); ?>" class="swiper-slide resourses__featured-item">
                            <div class="resourses__featured-img">
								<?php echo get_the_post_thumbnail( $post_id, 'large' ); ?>
                            </div>
                            <h3><?php echo $primary_category->name; ?></h3>
                            <p><?php echo get_the_title( $post_id ); ?></p>
                            <span class="resourses__read-more"><?php _e( 'Read More', 'appen' ); ?></span>
                        </a>
					<?php endforeach; ?>
                </div>
                <div class="resourses__navigation">
                    <div class="resourses__navigation-prev-btn js-webinar-prev"></div>
                    <div class="resourses__navigation-next-btn js-webinar-next"></div>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>