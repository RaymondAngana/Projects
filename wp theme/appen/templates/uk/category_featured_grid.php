<?php
$uk_blog_page     = get_field('uk_blog_page', 'option');
$term             = get_queried_object();
$featured_section = $uk_blog_page ? $uk_blog_page['featured_section']: get_field( 'featured_section', $term );
?>
<?php if ( $featured_section['post'][0] && $featured_section['posts'] ) : ?>
    <section class="resourses__featured">
        <div class="appen-wrap">
			<?php if ( $featured_section['title'] ) : ?>
                <h2><?php echo $featured_section['title']; ?></h2>
			<?php endif; ?>
            <div class="swiper-container js-resourse-slider">
                <div class="swiper-wrapper resourses__featured-list">
					<?php
					$post_categories  = get_post_primary_category( $featured_section['post'][0], 'uk_blog_category' );
					$primary_category = $post_categories['primary_category'];
					?>
                    <a href="<?php echo get_permalink( $featured_section['post'][0] ); ?>" class="swiper-slide resourses__featured-item resourses__featured-item--important">
                        <div class="resourses__featured-bg-img">
							<?php echo get_the_post_thumbnail( $featured_section['post'][0], 'large' ); ?>
                        </div>
                        <div class="resourses__featured-content">
                            <h3><?php echo $primary_category->name; ?></h3>
                            <p><?php echo get_the_title( $featured_section['post'][0] ); ?></p>
                            <span class="resourses__read-more"><?php _e( 'Read More', 'appen' ); ?></span>
                        </div>
                    </a>
					<?php foreach ( $featured_section['posts'] as $post_id ) : ?>
						<?php
						$post_categories  = get_post_primary_category( $post_id, 'uk_blog_category' );
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
                    <div class="resourses__navigation-prev-btn js-resourses-prev"></div>
                    <div class="resourses__navigation-next-btn js-resourses-next"></div>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>