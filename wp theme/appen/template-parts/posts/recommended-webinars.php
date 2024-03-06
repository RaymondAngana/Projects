<?php
    $category_name = get_query_var('category_name');
    $content_type_term = get_term_by( 'slug', $category_name, 'category' );

    $posts = get_posts([
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' => 3,
        'category_name' => $category_name,
        'exclude' => get_the_ID()
    ]);

    if ( !empty( $posts ) ) :
?>

<section class="recommended recommended__cards resourses__cards--big">
    <div class="appen-wrap" brightfunnel trigger="scroll">
        <h2><?php printf( __( 'Other %1$s you might like', 'appen' ), strtolower( $content_type_term->name ) ); ?></h2>
        <div class="swiper-container resourses__featured-alternative-container js-webinar-slider js-resourse-slider">
            <div class="swiper-wrapper resourses__featured-alternative recommended__slider">
                <?php foreach( $posts as $post ) : ?>
                    <a href="<?php echo appen_is_amp() ? ampforwp_url_controller( get_permalink( $post->ID ) ) : get_the_permalink( $post->ID ); ?>" class="swiper-slide resourses__featured-item">
                        <div class="resourses__featured-img">
                            <?php if ( $thumbnail = get_the_post_thumbnail_url( $post->ID, 'large' ) ) : ?>
                                <img src="<?php echo $thumbnail; ?>" alt="">
                            <?php endif; ?>
                        </div>
                        <h3><?php echo $content_type_term->name; ?></h3>
                        <p><?php echo $post->post_title; ?></p>
                        <?php
                            $type             = get_field( 'type', $post->ID );
                            $date             = get_field( 'date', $post->ID );
                            $duration         = get_field( 'duration', $post->ID );
                            $name             = get_field( 'name', $post->ID );
                            $role             = get_field( 'role', $post->ID );
                            $company          = get_field( 'company', $post->ID );

                            $featured_presenter = $name;
                            if ( $role || $company ) {
                                $featured_presenter .= ', ';
                                $featured_presenter .= ( $role && $company ) ? $role . ' | ' : $role;
                                if ( $company ) $featured_presenter .= $company;
                            }
                        ?>
                        <div class="resourses__featured-about">
                            <?php if ( $date ) : ?>
                                <div class="resourses__featured-about-row"><strong><?php echo $date; ?></strong></div>
                            <?php endif; ?>
                            <?php if ( $type ) : ?>
                                <div class="resourses__featured-about-row"><?php _e( 'Type:', 'appen' ); ?> <strong><?php echo $type; ?></strong></div>
                            <?php endif; ?>
                            <?php if ( $duration ) : ?>
                                <div class="resourses__featured-about-row"><?php _e( 'Duration:', 'appen' ); ?> <strong><?php echo $duration; ?></strong></div>
                            <?php endif; ?>
                            <?php if ( $featured_presenter ) : ?>
                                <div class="resourses__featured-about-row"><?php _e( 'Featured Presenter:', 'appen' ); ?> <strong><?php echo $featured_presenter; ?></strong></div>
                            <?php endif; ?>
                        </div>
                        <span class="resourses__read-more"><?php _e( 'Read More', 'appen' ); ?></span>
                    </a>
                <?php endforeach; ?>
            </div>
            <div class="recommended__bottom">
                <a href="<?php echo get_term_link( $content_type_term ); ?>" class="btn btn-o"><span><?php _e( 'All', 'appen' ); ?> <?php echo $content_type_term->name; ?></span></a>
                <div class="recommended__navigation">
                    <div class="recommended__navigation-prev-btn recommended-arrow js-recommended-prev"></div>
                    <div class="recommended__navigation-next-btn recommended-arrow js-recommended-next"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php endif; ?>