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

?>
	<main>
        <section class="appen-hero">
		    <div class="appen-wrap">
		        <?php get_single_post_breadcrumbs(); ?>
		        <h1 style="max-width: 808px;"><?php the_title(); ?></h1>
		        <?php the_field('short_description'); ?>
		    </div>
		</section>
        
        <div class="blog-content-wrap datasets-content-wrap js-appen-content">
		    <div class="appen-wrap">
		        <div class="appen-row">
		            <div class="appen-col appen-col-4">
						<aside class="appen-aside datasets-aside js-appen-aside">
								<div class="js-dataset-anchors" style="display:none">
									<?php if ( !empty( $side_menu ) ) : ?>
										<ul class="appen-menu">
											<?php foreach( $side_menu as $menu ) : ?>
												<li class="appen-menu__item"><a href="<?php echo $menu['anchor']; ?>"><?php echo $menu['name']; ?></a></li>
											<?php endforeach; ?>
										</ul>
									<?php endif; ?>
									<a href="#data" class="btn btn-black"><span><?php _e( 'Download Options', 'appen' ); ?></span></a>
								</div>
							
								<script src="//visit.appen.com/js/forms2/js/forms2.min.js"></script>
								<form id="mktoForm_2339" class="js-dataset-form" style="display:none"></form>

								<script>
									function checkCookie() {
										document.addEventListener('DOMContentLoaded', function() {
											const form = document.querySelector('.js-dataset-form');
											const aside = document.querySelector('.js-appen-aside');
											const anchorsBox = document.querySelector('.js-dataset-anchors');
											const downloadLinks = document.querySelectorAll('.download-links');
											const dataBox = document.querySelector('.tabs-panel#data');

											if (!localStorage.getItem('formIsValid')) {
												aside.className = 'appen-aside datasets__sticky';
												form.removeAttribute('style');
											} else {
												anchorsBox.removeAttribute('style');
												Array.from(downloadLinks).forEach(el => {
													el.removeAttribute('style');
												})
												dataBox.removeAttribute('style');
											}
										})
									}

									checkCookie();
									
									MktoForms2.loadForm("//visit.appen.com", "416-ZBE-142", 2339, function(form) {
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
											localStorage.setItem('formIsValid', true);

											// Take the lead to a different page on successful submit, ignoring the form's configured followUpUrl
											location.reload();
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
		                </aside>
		            </div>
		            <div class="appen-col appen-col-8">
		                <article class="blog-content datasets-content">
		                    <?php the_content(); ?>
		                    <section class="datasets">
								<?php get_template_part('template-parts/posts/datasets'); ?>
							</section>
		                </article>
		            </div>
		        </div>
		    </div>
		</div>

        <?php get_template_part('template-parts/posts/recommended'); ?>
    </main>

<?php if ( ! appen_is_amp() ) get_footer(); ?>
