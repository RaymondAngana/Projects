<?php

// =============================================================================
// VIEWS/INTEGRITY/WP-SINGLE.PHP
// -----------------------------------------------------------------------------
// Single post output for Integrity.
// =============================================================================

$fullwidth = get_post_meta( get_the_ID(), '_x_post_layout', true );

if ( ! appen_is_amp() ) get_header();

the_post();

$side_menu = get_field('side_menu');
$quote = get_field('quote');

?>

	<main class="case-study-page">
        <section class="appen-hero">
		    <div class="appen-wrap">
		    	<?php get_single_post_breadcrumbs(); ?>
		        <h1><?php the_title(); ?></h1>
		        <?php if ( $subtitle = get_field('subtitle') ) : ?>
		        	<p style="max-width: 821px;"><?php echo $subtitle; ?></p>
		        <?php endif; ?>
		    </div>
		</section>
        <div class="blog-content-wrap case-study-content-wrap js-appen-content">
		    <div class="appen-wrap">
		        <div class="appen-row">
		            <div class="appen-col appen-col-4 case-study-col-menu">
		                <aside class="appen-aside case-study-aside js-appen-aside">
		                	<?php if ( !empty( $side_menu['logo'] ) ) : ?>
								<?php if($side_menu['logo_url'] != '') { ?>
		                    	<a href="<?php echo $side_menu['logo_url']; ?>" target="_blank" class="case-study-aside__logo"><img src="<?php echo $side_menu['logo']['sizes']['medium']; ?>" alt=""></a>
								<?php } else { ?>
									<div class="case-study-aside__logo">
										<img src="<?php echo $side_menu['logo']['sizes']['medium']; ?>" alt="">
									</div>
								<?php } ?>
		                    <?php endif; ?>
		                    <?php if ( !empty( $side_menu['menu'] ) ) : ?>
			                    <ul class="appen-menu">
			                    	<?php foreach( $side_menu['menu'] as $menu ) : ?>
			                        	<li class="appen-menu__item"><a href="<?php echo $menu['anchor']; ?>"><?php echo $menu['name']; ?></a></li>
			                    	<?php endforeach; ?>
			                    </ul>
		                    <?php endif; ?>
		                </aside>
		            </div>
		            <div class="appen-col appen-col-12 case-study-col-content">
		            	<?php if ( !empty( $quote ) && $quote['text'] ) : ?>
			                <div class="blog-quote">
			                    <div class="blog-quote__text"><?php echo $quote['text']; ?></div>
			                    <div class="blog-quote__author-name"><?php echo $quote['author_name']; ?></div>
			                    <div class="blog-quote__author-job"><?php echo $quote['author_job']; ?></div>
			                </div>
		            	<?php endif; ?>
		                <article class="blog-content case-study-content">
		                	<?php the_content(); ?>
		                </article>
		            </div>
		        </div>
		    </div>
		</div>

		<?php get_template_part('template-parts/posts/recommended'); ?>
    </main>

<?php if ( ! appen_is_amp() ) get_footer(); ?>
