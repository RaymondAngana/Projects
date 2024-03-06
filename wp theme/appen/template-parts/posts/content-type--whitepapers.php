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
        <section class="appen-hero">
		    <div class="appen-wrap">
		        <?php get_single_post_breadcrumbs(); ?>
		        <h1 style="max-width: 808px;"><?php the_title(); ?></h1>
		    </div>
		</section>
        
        <div class="blog-content-wrap blog-content-wrap_form ebooks-content-wrap js-appen-content">
		    <div class="appen-wrap">
		        <div class="appen-row row-md">
		            <div class="appen-col appen-col-md-12">
		                <aside class="appen-aside js-appen-aside">
		                    <?php
		                    if ( get_field('file_url') ) :
			                    $redirect_url = get_thankyou_page_url() . '?download_id=' . get_the_ID();

                                if ( appen_is_amp() ) :
                                    $page = get_page_by_path( 'download-now' );
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
								<script src="https://www.google.com/recaptcha/api.js?render=6Lfnh3QdAAAAACfN2HnLav2jMoCpO0_GDL-_1eTb" async defer></script>
								<style>
									.grecaptcha-badge {visibility: hidden;}
									.grecaptcha_text {
										font-size: 13px !important;
										text-align:center !important;
										padding-top: 15px !important;
										max-width: 320px !important;
										opacity: 0.7 !imporatnt;
									} 
									.grecaptcha_text a {font-size: 13px!important;}
								</style>
								<script src="//app-ab14.marketo.com/js/forms2/js/forms2.min.js"></script>
								<form id="mktoForm_2071"></form>
								<input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response">
								<script>
									MktoForms2.loadForm("//app-ab14.marketo.com", "416-ZBE-142", 2071, function(form) {
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

										form.getFormElem('form').append(`
										<p class="grecaptcha_text">This site is protected by reCAPTCHA and the Google
											<a href="https://policies.google.com/privacy">Privacy Policy</a> and
											<a href="https://policies.google.com/terms">Terms of Service</a> apply.
										</p>
										`);

										let submitButton = $('#mktoForm_2071 button[type="submit"]');

										form.submittable(false);
										form.locked = false;

										//Add recaptcha on validate
										form.onValidate(function(isValid) {
											if(!isValid) return;

											submitButton.attr('disabled', 'true');

											grecaptcha.ready(function() {
												grecaptcha.execute('6Lfnh3QdAAAAACfN2HnLav2jMoCpO0_GDL-_1eTb', {action: 'submit'}).then(function(token) {
													if (form.locked == false) {
														form.locked = true;
														document.getElementById('g-recaptcha-response').value = token;
														let ajaxurl = '/wp-admin/admin-ajax.php';
														$.ajax({
															url: ajaxurl,
															type: 'POST',
															data: {
																'action': 'get_recaptcha_response',
																'g-recaptcha-response': $('#g-recaptcha-response').val(),
															}
														})
														.done(function(data, status, xhr) {
															if(parseFloat(data) >= 0.5) {
																form.submittable(true);
																form.submit();
															} else {
																alert("Sorry, but reCAPTCHA detects you as a robot. Please try again later.");
																form.submittable(false);
																form.locked = false;
																submitButton.removeAttr('disabled');
																return false;
															}
														})
														.fail(function(data, status, xhr) {
															alert('Error form sending. Please try again later');
															form.submittable(false);
															form.locked = false;
															submitButton.removeAttr('disabled');
														})
													}
												});
											});
										});
									    //Add an onSuccess handler
									    form.onSuccess(function(values, followUpUrl) {

											const formData = form.getValues();

											woopra.identify({
												firstname : formData.FirstName,
												lastname : formData.LastName,
												email : formData.Email,
												company : formData.Company,
												title : formData.Title,
												phone : formData.Phone,
												country : formData.Country,
												name : formData.FirstName + ' ' + formData.LastName,
											});

											woopra.track('ebook_whitepaper_form', {
												firstname : formData.FirstName,
												lastname : formData.LastName,
												email : formData.Email,
												company : formData.Company,
												title : formData.Title,
												phone : formData.Phone,
												country : formData.Country,
												submit_url : window.location.href,
											});

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
		            <div class="appen-col appen-col-md-12 appen-col-lg-6 appen-col-8">
		                <article class="blog-content ebooks-content">
		                	<?php the_content(); ?>
		                </article>
		            </div>
		        </div>
		    </div>
		</div>

        <?php get_template_part('template-parts/posts/recommended'); ?>
    </main>

<?php if ( ! appen_is_amp() ) get_footer(); ?>
