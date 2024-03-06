<?php

// =============================================================================
// VIEWS/INTEGRITY/WP-SINGLE.PHP
// -----------------------------------------------------------------------------
// Single post output for Integrity.
// =============================================================================

$fullwidth = get_post_meta( get_the_ID(), '_x_post_layout', true );

if ( ! appen_is_amp() ) {
	get_header();
}

the_post();

?>
<?php if(get_field('template') == 'template2') { ?>
<style>
.ebooks-content {
    max-width: 800px;
    margin: 0 auto;
}
strong {
	/*font-weight: 700 !important;*/
    color: #000;
}
.resourses__cards--big .resourses__featured-item {
	width: auto !important;
    max-width: 800px;
    margin: 0 auto;
    height: auto !important;
    min-height: 0;
    padding-bottom: 0;
    border: 1px solid #eff1f2;
    margin-bottom: 30px;
}
.resourses__featured-img {
	background: transparent;
}
.resourses__featured-img img {
	width: auto;
}
.resourses__featured-item h3 {
	padding-top: 0;
}
.resourses__featured-alternative-container {
	margin-bottom: 60px;
}
.resourses__featured-alternative-wrap {
	display: flex;
    flex-direction: column;
    height: 100%;
}
.resourses__featured-alternative-wrap .resourses__read-more {
	margin-top: auto;
    padding-bottom: 20px;
}
.resourses__featured-about {
    margin-bottom: 10px;
}
.resourses__cards--big .resourses__featured-item p.desc {
    font-size: 14px;
    font-weight: 400;
    padding-right: 0;
    margin-bottom: 15px;
}
@media screen and (min-width: 768px) {
    .appen-hero {
        background: transparent url(/wp-content/uploads/2020/05/Group-3203-Copy-2.png) top right no-repeat;
        background-size: 35%;
    }
    .appen-col-5 {
        -ms-flex-preferred-size: 41.666667%;
        flex-basis: 41.666667%;
    }
    .appen-col-7 {
        -ms-flex-preferred-size: 58.333333%;
        flex-basis: 58.333333%;
    }
    .resourses__cards--big .resourses__featured-img {
        height: 340px;
    }
    .resourses__read-more:not(.ac) {
        position: absolute;
        bottom: 20px;
    }
}
@media screen and (max-width: 767px) {
	.resourses__cards--big .resourses__featured-item {
    	padding: 0;
    }
    .resourses__cards--big .resourses__featured-item .appen-row {
    	margin: 0;
    }
	.resourses__cards--big .resourses__featured-item .appen-col-6 {
    	padding-top: 25px;
    	padding-bottom: 25px;
    }
}
@media screen and (max-width: 768px) {
    .blog-content-wrap_form {
	     padding-top: 48px !important; 
	}	
}
</style>
<?php } ?>

	<main>
        <section class="appen-hero">
		    <div class="appen-wrap">
		        <?php get_single_post_breadcrumbs(); ?>
		        <?php if(get_field('template') == 'template2') { ?>
		        	<h1><?php the_title(); ?></h1>
                    <p><?php the_field('subtitle'); ?></p>
	        	<?php } else { ?>
		        	<h1 style="max-width: 808px;"><?php the_title(); ?></h1>
		    	<?php } ?>
		    </div>
		</section>
        
        <div class="blog-content-wrap blog-content-wrap_form ebooks-content-wrap js-appen-content">
		    <div class="appen-wrap">
		        <div class="appen-row row-md">
                	<?php if(get_field('template') != 'template2') { ?>
		            <div class="appen-col appen-col-md-12">
		                <aside class="appen-aside js-appen-aside">
		                    <?php
		                    if ( $redirect_url = get_field('redirect_url') ) :

                                if ( appen_is_amp() ) :
                                    $page = get_page_by_path( 'watch-webinar' );
                                if ( $page ) : ?>
                                    <a class="x-anchor x-anchor-button bb_amp center_amp" tabindex="0" href="<?php echo esc_url( get_the_permalink( $page->ID ) . '?redirect_url="' . $redirect_url . '"' ); ?>">
                                        <div class="x-anchor-content">
                                            <div class="x-anchor-text">
                                                <span class="x-anchor-text-primary"><?php echo get_the_title( $page->ID ); ?></span>
                                            </div>
                                        </div>
                                    </a>
                                <?php endif; ?>
                                <?php else: ?>
			                    <script src="//app-ab14.marketo.com/js/forms2/js/forms2.min.js"></script>
								<form id="mktoForm_2072"></form>
								<script>
									MktoForms2.loadForm("//app-ab14.marketo.com", "416-ZBE-142", 2072, function(form) {
                                        const queryString = window.location.search;
                                        const urlParams = new URLSearchParams(queryString);
                                        const utm = {
                                            'source': urlParams.get('utm_source'),
                                            'medium': urlParams.get('utm_medium'),
                                            'content': urlParams.get('utm_content'),
                                            'term': urlParams.get('utm_term'),
                                            'campaign': urlParams.get('utm_campaign'),
                                        };

                                        form.setValues({
                                            'utm_source__c': utm.source ? utm.source : '',
                                            'utm_medium__c': utm.medium ? utm.medium : '',
                                            'utm_content__c': utm.content ? utm.content : '',
                                            'utm_term__c': utm.term ? utm.term : '',
                                            'utm_campaign__c': utm.campaign ? utm.campaign : '',
                                        });
									    //Add an onSuccess handler
									    form.onSuccess(function(values, followUpUrl) {
									        // Take the lead to a different page on successful submit, ignoring the form's configured followUpUrl
									        location.href = "<?php echo  $redirect_url; ?>";
									        // Return false to prevent the submission handler continuing with its own processing
									        return false;
									    });
									});
								</script>

								<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
								<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
								<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

								<script>
									MktoForms2.whenReady(function(form) {
										var formElem = form.getFormElem()[0];
										var countrySelect = formElem.querySelector('[name="Country"]');
										if (countrySelect) {
											$(countrySelect).select2({
												placeholder: "<?php _e( 'Select', 'appen' ); ?>"
											});
										}
									});
								</script>
							<?php endif; ?>
		                    <?php endif; ?>
		                </aside>
		            </div>
                    <?php } ?>
                    <?php if(get_field('template') != 'template2') { ?>
		            <div class="appen-col appen-col-md-12 appen-col-lg-6 appen-col-8">
                    <?php } else { ?>
                    <div class="appen-col appen-col-12">
                    <?php } ?>
		                <article class="blog-content ebooks-content">
		                	<?php the_content(); ?>
		                </article>
		            </div>
		        </div>
		    </div>
		</div>
		<?php if(get_field('template') != 'template2') { ?>
        <?php get_template_part('template-parts/posts/recommended-webinars'); ?>
        <?php } else { ?>
        	<section class="resourses__cards--big">
        		<div class="appen-wrap">
        			<div class="resourses__featured-alternative-container">
            			<div class="">
							<?php
							if( have_rows('webinars') ) {
							    while ( have_rows('webinars') ) {
						     	the_row();
						     	?>
	            				<div class="resourses__featured-item">
	            					<div class="appen-row row-md">
	            						<div class="appen-col-5">
			            					<div class="resourses__featured-img">
			            						<?php echo wp_get_attachment_image(get_sub_field('image'), 'full'); ?>
			            					</div>
	            						</div>
	            						<div class="appen-col appen-col-6">
											<div class="resourses__featured-alternative-wrap">
												<h3>Webinars</h3>
												<p><?php echo get_sub_field('name'); ?></p>
												<div class="resourses__featured-about">
													<?php if(get_sub_field('date') != '') { ?>
													<div class="resourses__featured-about-row"><?php _e( 'Date:', 'appen' ); ?> <strong><?php echo get_sub_field('date'); ?></strong></div>
													<?php } ?>
													<?php if(get_sub_field('duration') != '') { ?>
													<div class="resourses__featured-about-row"><?php _e( 'Duration:', 'appen' ); ?> <strong><?php echo get_sub_field('duration'); ?></strong></div>
													<?php } ?>
													<?php if(get_sub_field('featured_presenter') != '') { ?>
													<div class="resourses__featured-about-row"><?php _e( 'Featured Presenter:', 'appen' ); ?> <strong><?php echo get_sub_field('featured_presenter'); ?></strong></div>
													<?php } ?>
												</div>
												<?php if(get_sub_field('description') != '') { ?>
													<p class="desc"><?php echo get_sub_field('description'); ?></p>
												<?php } ?>
												<?php if(get_sub_field('link') != '') { ?>
													<?php
														if(get_sub_field('cta_text') != '') {
															$cta_text = get_sub_field('cta_text');
														} else {
															$cta_text = __( 'Register Now', 'appen' );
															;
														}
													?>
													<a class="resourses__read-more<?php if(get_sub_field('description') != '') { ?> ac<?php } ?>" href="<?php echo get_sub_field('link'); ?>"><?php echo $cta_text; ?></a>
												<?php } ?>
											</div>
	            						</div>
	            					</div>
	            				</div>
						     	<?php
						     	}
					     	}
					     	?>
            			</div>
            		</div>
        		</div>
	     	</section>
    	<?php } ?>
    </main>

<?php
if ( ! appen_is_amp() ) {
	get_footer();
	}
?>