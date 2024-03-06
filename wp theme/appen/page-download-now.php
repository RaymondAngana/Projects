<?php

$fullwidth = get_post_meta( get_the_ID(), '_x_post_layout', true );

get_header();
the_post(); ?>

    <main>

        <section class="appen-hero appen-hero--height-auto">
            <div class="appen-wrap">
                <h1 style="max-width: 808px;"><?php the_title(); ?></h1>
            </div>
        </section>

        <div class="blog-content-wrap blog-content-wrap_form ebooks-content-wrap js-appen-content blog-content-wrap--remove-m">
            <div class="appen-wrap">
                <div class="appen-row row-md">
                    <div class="appen-col appen-col-md-12">
                        <aside class="appen-aside js-appen-aside">

                            <?php $redirect_url = $_GET['redirect_url']; ?>

                            <script src="//app-ab14.marketo.com/js/forms2/js/forms2.min.js"></script>
                            <form id="mktoForm_2071"></form>
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
                        </aside>
                    </div>
                </div>
            </div>
        </div>
    </main>
<?php get_footer(); ?>