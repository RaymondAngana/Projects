<?php
$post_categories  = get_post_primary_category( get_the_ID(), 'category' );
$primary_category = $post_categories['primary_category'];
$type             = get_field( 'type' );
$date             = get_field( 'date' );
$duration         = get_field( 'duration' );
$name             = get_field( 'name' );
$role             = get_field( 'role' );
$company          = get_field( 'company' );
$term = get_queried_object();
?>
<a href="<?php echo get_permalink( get_the_ID() ); ?>" class="resourses__featured-item">
    <div class="resourses__featured-img">
		<?php echo get_the_post_thumbnail( get_the_ID(), 'large' ); ?>
    </div>
    <h3><?php echo $term->name ? $term->name : $primary_category->name; ?></h3>
    <p><?php the_title(); ?></p>
    <?php if ( $type || $date || $duration || $name ) : ?>
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
            <?php if ( $name ) : ?>
                <div class="resourses__featured-about-row"><?php _e( 'Featured Presenter:', 'appen' ); ?>
                    <strong>
                        <?php $featured_presenter = $name; ?>
                        <?php if ( $role || $company ) : ?>
                            <?php $featured_presenter .= ', '; ?>
                            <?php $featured_presenter .= ( $role && $company ) ? $role . ' | ' : $role; ?>
                            <?php if ( $company ) $featured_presenter .= $company; ?>
                        <?php endif ;?>
                        <?php echo $featured_presenter; ?>
                    </strong>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>
    <span class="resourses__read-more"><?php _e( 'Read More', 'appen' ); ?></span>
</a>