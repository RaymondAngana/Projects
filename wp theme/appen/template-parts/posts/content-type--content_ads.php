<?php

// =============================================================================
// VIEWS/INTEGRITY/WP-SINGLE.PHP
// -----------------------------------------------------------------------------
// Single post output for Integrity.
// =============================================================================

//$fullwidth = get_post_meta( get_the_ID(), '_x_post_layout', true );

if ( ! appen_is_amp() ) get_header();

//the_post();



?>

	<main>
        <section class="appen-hero blog-hero">
		    <div class="appen-wrap">
		        <div class="appen-row">
		            <div class="appen-col appen-col-6 blog-hero__col">
		                <?php get_single_post_breadcrumbs(); ?>
		                <h1 class="appen-hero__title">
		                    <?php the_title(); ?>
		                </h1>
		                <?php if ( $subtitle = get_field('subtitle') ) : ?>
		        			<p class="appen-hero__desc"><?php echo $subtitle; ?></p>
		        		<?php endif; ?>
		        		<p class="appen-hero__date">
							<time><?php _e( 'By the team of Appen.', 'appen' ); ?> <?php echo get_the_date('F d, Y'); ?></time>
		                </p>
		            </div>
		            <div class="appen-col appen-col-6 blog-hero__col_img">
		            	<?php if ( $thumbnail = get_the_post_thumbnail_url( $post->ID, 'full' ) ) : ?>
			                <div class="appen-hero-img">
			                    <img src="<?php echo $thumbnail; ?>" alt="" />
			                </div>
		                <?php endif; ?>
		            </div>
		        </div>
		    </div>
		</section>

        <div class="blog-content-wrap blog-single-content-wrap js-appen-content">
		    <div class="appen-wrap">
		        <div class="appen-row">
		            <div class="appen-col appen-col-8 appen-col--center blog-single-content blog-content">
		                <?php the_content(); ?>
		                <?php if(get_field('raw_html')){ echo get_field('raw_html'); } ?>
		            </div>
		        </div>
		    </div>
		</div>

		<?php if ( !empty( get_field('quotes') ) ) : 

			$quotes = get_field('quotes');
			?>
	        <div class="appen-wrap">
			    <div class="appen-row">
			        <div class="appen-col appen-col-8 appen-col--center">
			            <div class="quote-slider-container">
			                <div class="quote-slider js-quote-slider swiper-container">
			                    <div class="swiper-wrapper quote-slider__wrap">
			                    	<?php foreach( $quotes as $quote ) : ?>
				                        <div class="blog-quote quote-slider__slide swiper-slide" >
				                            <div class="blog-quote__text">
				                                <?php echo $quote['text']; ?>
				                            </div>
				                            <div class="blog-quote__author-name">
				                                <?php echo $quote['author_name']; ?>
				                            </div>
				                            <div class="blog-quote__author-job">
				                                <?php echo $quote['author_job']; ?>
				                            </div>
				                        </div>
				                    <?php endforeach; ?>
			                    </div>
			                    <div class="quote-slider__bottom">
			                        <div class="quote-slider__navigation">
			                            <div
			                                class="recommended__navigation-prev-btn recommended-arrow js-quote-slider-prev"
			                            ></div>
			                            <div class="quote-slider__pages">
			                                <span class="js-pages-current">1</span>
			                                /
			                                <span class="js-pages-total">1</span>
			                            </div>
			                            <div
			                                class="recommended__navigation-next-btn recommended-arrow js-quote-slider-next"
			                            ></div>
			                        </div>
			                    </div>
			                </div>
			            </div>
			        </div>
			    </div>
			</div>
		<?php endif; ?>
		
		<?php if(get_field('socials_text') && get_field( 'socials_shortcode', 'option' )){ ?>
		<div class="blog-single-social">
		    <div class="appen-wrap">
		        <div class="appen-row appen-row-center">
		            <div class="appen-col hidden-md appen-col-6"><?php echo get_field('socials_text'); ?></div>
		            <div class="appen-col appen-col-md-12 appen-col-6">
		                <?php echo do_shortcode( get_field( 'socials_shortcode', 'option' ) ); ?>
		            </div>
		        </div>
		    </div>
		</div>
		<?php } ?>
        <?php 
         get_template_part('template-parts/posts/recommended-content_ads'); 
        ?>
    </main>

<?php if ( ! appen_is_amp() ) get_footer(); ?>