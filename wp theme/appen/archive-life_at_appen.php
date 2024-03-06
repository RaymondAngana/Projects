<?php
$life_at_appen		   = get_field('life_at_appen', 'option');
$type_featured_section = $life_at_appen['type_featured_section'];

get_header(); ?>

    <div class="x-main full" role="main">
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <section class="appen-hero resourses-hero">
                <div class="appen-wrap">
					<?php get_life_at_appen_breadcrumbs(); ?>
                    <h1><?php echo is_post_type_archive() ? 'Life at Appen' : single_cat_title(); ?></h1>
					<?php
					if ( $life_at_appen['sub_heading'] ) {
						echo '<p>' . $life_at_appen['sub_heading'] . '</p>';
					}
					?>
                </div>
            </section>
			<?php
				if ( $type_featured_section && ( $type_featured_section != 'none' ) ) {
					get_template_part( 'templates/uk/category_featured_' . $type_featured_section );
				}
			?>
            <section class="resourses__cards">
                <div class="appen-wrap">
	                <?php if ( have_posts() ) : ?>
                        <h2>
			                <?php
				                echo __( 'Explore All', 'appen' ) . ' <span>' . __( 'Posts', 'appen' ) . '</span>';
			                ?>
                        </h2>
						<div class="resourses__featured-list resourses__featured-list--not-slider">
							<?php
							while ( have_posts() ) {
								the_post();

								$categories = get_the_terms(get_the_ID(), 'life_at_appen_category');
								if ( !empty( $categories ) ) {
							        $term = array_shift($categories);
							        $term_name = $term->name;
							    } else {
							    	$term_name = 'Life at Appen';
							    }

								?>
									<a href="<?php echo get_permalink( get_the_ID() ); ?>" class="resourses__featured-item">
										<div class="resourses__featured-img">
											<?php echo get_the_post_thumbnail( get_the_ID(), 'large' ); ?>
										</div>
										<h3><?php echo $term_name; ?></h3>
										<p><?php the_title(); ?></p>
										<span class="resourses__read-more"><?php _e( 'Read More', 'appen' ); ?></span>
									</a>
								<?php
							}
							?>
						</div>

	                <?php else : ?>
		                <?php _e( 'Sorry, nothing found.', 'appen' ); ?>
	                <?php endif; ?>
                </div>
            </section>
        </article>
    </div>
<?php get_footer(); ?>