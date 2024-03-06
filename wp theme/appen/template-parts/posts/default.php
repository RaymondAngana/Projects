<?php

// =============================================================================
// VIEWS/INTEGRITY/WP-SINGLE.PHP
// -----------------------------------------------------------------------------
// Single post output for Integrity.
// =============================================================================

$fullwidth = get_post_meta( get_the_ID(), '_x_post_layout', true );

if ( ! appen_is_amp() ) get_header();

the_post();

?>

	<main>
        <section class="appen-hero blog-hero">
		    <div class="appen-wrap">
		        <div class="appen-row">

					<?php $thumbnail = get_the_post_thumbnail_url( $post->ID, 'full' ); ?>

		            <div class="appen-col <?php echo $thumbnail ? 'appen-col-6' : ''; ?> blog-hero__col">
		                <?php get_single_post_breadcrumbs(); ?>
		                <h1 class="appen-hero__title">
		                    <?php the_title(); ?>
		                </h1>
		        		<p class="appen-hero__date">
							<time><?php _e( 'By', 'appen' ); ?> <?php echo get_the_author() ?>. <?php echo get_the_date('F d, Y'); ?></time>
		                </p>
		            </div>
					<?php if ( $thumbnail ) : ?>
		            	<div class="appen-col appen-col-6 blog-hero__col_img">
			                <div class="appen-hero-img">
			                    <img src="<?php echo $thumbnail; ?>" alt="" />
			                </div>
						</div>
		            <?php endif; ?>
		        </div>
		    </div>
		</section>

        <div class="blog-content-wrap blog-single-content-wrap js-appen-content">
		    <div class="appen-wrap">
		        <div class="appen-row">
		            <div class="appen-col appen-col-8 appen-col--center blog-single-content blog-content">
		                <?php the_content(); ?>
		            </div>
		        </div>
		    </div>
		</div>

        <?php get_template_part('template-parts/posts/recommended'); ?>
    </main>

<?php if ( ! appen_is_amp() ) get_footer(); ?>
