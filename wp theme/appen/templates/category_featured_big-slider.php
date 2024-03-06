<?php
$term             = get_queried_object();
$featured_section = get_field( 'featured_section', $term );
$type             = get_field( 'type' );
$date             = get_field( 'date' );
$duration         = get_field( 'duration' );
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
						$post_categories  = get_post_primary_category( $post_id, 'category' );
						$primary_category = $post_categories['primary_category'];
						?>
                        <a href="<?php echo get_permalink( $post_id ); ?>" class="swiper-slide resourses__featured-item">
                            <div class="resourses__featured-img">
								<?php echo get_the_post_thumbnail( $post_id, 'large' ); ?>
                            </div>
                            <h3><?php echo $primary_category->name; ?></h3>
                            <p><?php echo get_the_title( $post_id ); ?></p>
	                        <?php if ( $type || $date || $duration ) : ?>
                                <div class="resourses__featured-about">
			                        <?php if ( $date ) : ?>
			                        <?php endif; ?>
                                    <div class="resourses__featured-about-row"><strong><?php echo $date; ?></strong></div>
			                        <?php if ( $type ) : ?>
			                        <?php endif; ?>
                                    <div class="resourses__featured-about-row"><?php _e( 'Type:', 'appen' ); ?> <strong><?php echo $type; ?></strong></div>
			                        <?php if ( $duration ) : ?>
			                        <?php endif; ?>
                                    <div class="resourses__featured-about-row"><?php _e( 'Duration:', 'appen' ); ?> <strong><?php echo $duration; ?></strong></div>
                                </div>
	                        <?php endif; ?>
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