<?php if ( false ) : ?>
<div class="grid-container datasets-section" style="margin-bottom: 40px;">
  <div class="grid-x grid margin-x grid-padding-x">
    <div class="cell small-12 medium-4">
      <a class="button hollow-purple" href="<?php the_field('see_all_datasets_url'); ?>"><i class="icon-arrow-left"></i> <?php the_field('see_all_datasets_text'); ?></a>
    </div>

    <div class="cell small-12 medium-8 align-right text-align-right hide-for-mobile">

      <?php if ( get_field('duplicate_job_design_cta_text') ): ?>
        <a class="button hollow-blue" target="_blank" href="<?php the_field('duplicate_job_design_cta_url'); ?>" style="margin-right: 15px;"><?php the_field('duplicate_job_design_cta_text'); ?></a>
      <?php endif; ?>

      <a class="button blue link-to-data"><?php _e( 'Download Options', 'appen' ); ?></a>
    </div>
  </div>
</div>
<?php endif; ?>

<?php
$schemaHasPart = [];
$schemaDistrib = [];
?>

<div class="grid-container datasets-section">
  <div class="grid-x grid-margin-x grid-padding-x">

    <div class="cell small-12 medium-3">

      <div style="background-image:url('<?php the_field('thumbnail_image'); ?>');" class="dataset-thumb"></div>

      <?php // the_field('short_description'); ?>

      <?php the_field('sidebar'); ?>
    </div>

    <div class="cell small-12 medium-9">

      <div class="dataset-content">

          <div class="tabs-content" data-tabs-content="dataset-tabs">
            <div class="tabs-panel is-active" id="overview">
              <div class="show-for-mobile">
                <?php the_field('mobile_message'); ?>
              </div>

              <?php the_field('overview'); ?>
            </div>

            <div class="tabs-panel" id="job-design">
              <?php if ( get_field('job_description_and_design') ): ?>
                <h2><?php the_field('job_description_and_design_title'); ?></h2>
                <?php the_field('job_description_and_design_text'); ?>

                <div class="dataset-popup" id="job-preview" style="display: none;">
                  <h2>Job Design and Instructions</h2>

                  <div>
                    <?php the_field('job_description_and_design'); ?>
                  </div>
                </div>
              <?php endif; ?>

              <h2><?php the_field('raw_data_title'); ?></h2>
              <?php the_field('raw_data_table'); ?>

            </div>

            <div class="tabs-panel" id="data" style="display: none;">
              <h2><?php the_field('download_options_title'); ?></h2>

              <?php if( have_rows('download_options') ): ?>

                <?php $preview_count = 1; ?>

                <div class="download-options">

                  <?php while ( have_rows('download_options') ) : the_row(); ?>

                    <?php $file_type = get_sub_field('file_type'); ?>

                    <?php
                     if ( $file_type == 'csv' ) {
                       $file_icon = 'icon-file-csv.png';
                     }
                     else if ( $file_type == 'mp4' ) {
                       $file_icon = 'icon-file-media.png';
                     }
                     else if ( $file_type == 'zip' ) {
                       $file_icon = 'icon-file-zip.png';
                     }
                     else if ( $file_type == 'txt' ) {
                       $file_icon = 'icon-file-txt.png';
                     }
                     else {
                       $file_icon = 'icon-file-default.png';
                     }
                     ?>


                    <div class="download-option">

                      <div class="download-main">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/icons/<?php echo $file_icon; ?>" class="dataset-icon">
                        <?php the_sub_field('file_name'); ?> |
                        <?php the_sub_field('file_size'); ?>
                      </div>

                      <div class="download-links" style="display:none">
                        <?php if ( $file_type == 'csv' ): ?>
                          <a class="open-dataset-info" href="javascript:void(0);" data-href="#download-preview-1"><?php _e( 'Preview', 'appen' ); ?></a>
                        <?php endif; ?>

                        <a target="_blank" href="<?php the_sub_field('file'); ?>"><?php _e( 'Download', 'appen' ); ?></a>
                      </div>

                    </div>

                    <?php if ( $file_type == 'csv' ): ?>
                      <div class="dataset-popup" id="download-preview-<?php echo $preview_count; ?>" style="display: none;">

                        <h2><?php the_sub_field('file_name'); ?></h2>
                        <?php the_sub_field('file_description'); ?>

                        <ul class="tabs" id="table-detail-tabs-<?php echo $preview_count; ?>">
                          <li class="tabs-title popup-tab-title is-active" data-popup-tab="popup-tab-<?php echo $preview_count; ?>"><a data-tabs-target="table-preview" aria-selected="true"><?php _e( 'Rows Preview', 'appen' ); ?></a></li>
                          <li class="tabs-title popup-tab-title" data-popup-tab="popup-tab-<?php echo $preview_count; ?>"><a data-tabs-target="dataset-columns" ><?php _e( 'Columns Preview', 'appen' ); ?></a></li>
                        </ul>

                        <div class="tabs-content">
                          <div class="tab-content popup-tab-<?php echo $preview_count; ?> is-active" id="table-preview">
                            <div class="tablepress-wrapper">
                              <?php the_sub_field('table_data'); ?>
                            </div>

                            <p style="text-align:center;"><?php _e( 'You are previewing the first 25 rows of this dataset. Download this file for the full dataset.', 'appen' ); ?></p>
                          </div>

                          <div class="tab-content popup-tab-<?php echo $preview_count; ?>" id="dataset-columns">
                            <div class="tablepress-wrapper">
                              <?php the_sub_field('table_columns'); ?>
                            </div>
                          </div>
                        </div>

                      </div>
                    <?php endif; ?>



                    <?php if( have_rows('children') ): ?>
                      <?php while ( have_rows('children') ) : the_row(); ?>

                        <?php $file_type = get_sub_field('file_type'); ?>

                        <?php
                         if ( $file_type == 'csv' ) {
                           $file_icon = 'icon-file-csv.png';
                         }
                         else if ( $file_type == 'mp4' ) {
                           $file_icon = 'icon-file-media.png';
                         }
                         else if ( $file_type == 'zip' ) {
                           $file_icon = 'icon-file-zip.png';
                         }
                         else if ( $file_type == 'txt' ) {
                           $file_icon = 'icon-file-txt.png';
                         }
                         else {
                           $file_icon = 'icon-file-default.png';
                         }
                         ?>


                        <div class="download-option child-download-option">

                          <div class="download-main">
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/icons/<?php echo $file_icon; ?>" class="dataset-icon">
                            <?php the_sub_field('file_name'); ?> |
                            <?php the_sub_field('file_size'); ?>
                          </div>

                          <div class="download-links" style="display:none">
                            <?php if ( $file_type == 'csv' ): ?>
                              <a class="open-dataset-info" href="javascript:void(0);" data-href="#download-preview-<?php echo $preview_count; ?>"><?php _e( 'Preview', 'appen' ); ?></a>
                            <?php endif; ?>

                            <a target="_blank" href="<?php the_sub_field('file'); ?>"><?php _e( 'Download', 'appen' ); ?></a>
                          </div>

                        </div>

                        <?php if ( $file_type == 'csv' ): ?>
                          <div class="dataset-popup" id="download-preview-<?php echo $preview_count; ?>" style="display: none;">

                            <h2><?php the_sub_field('file_name'); ?></h2>
                            <?php the_sub_field('file_description'); ?>

                            <ul class="tabs" id="table-detail-tabs-<?php echo $preview_count; ?>">
                              <li class="tabs-title popup-tab-title is-active" data-popup-tab="popup-tab-<?php echo $preview_count; ?>"><a data-tabs-target="table-preview" aria-selected="true"><?php _e( 'Rows Preview', 'appen' ); ?></a></li>
                              <li class="tabs-title popup-tab-title" data-popup-tab="popup-tab-<?php echo $preview_count; ?>"><a data-tabs-target="dataset-columns" ><?php _e( 'Columns Preview', 'appen' ); ?></a></li>
                            </ul>

                            <div class="tabs-content">
                              <div class="tab-content popup-tab-<?php echo $preview_count; ?> is-active" id="table-preview">
                                <div class="tablepress-wrapper">
                                  <?php the_sub_field('table_data'); ?>
                                </div>

                                <p style="text-align:center;"><?php _e( 'You are previewing the first 25 rows of this dataset. Download this file for the full dataset.', 'appen' ); ?></p>
                              </div>

                              <div class="tab-content popup-tab-<?php echo $preview_count; ?>" id="dataset-columns">
                                <div class="tablepress-wrapper">
                                  <?php the_sub_field('table_columns'); ?>
                                </div>
                              </div>
                            </div>

                          </div>
                        <?php endif; ?>

			                  <?php
			                  array_push( $schemaDistrib, [
				                  'file_type' => get_sub_field( 'file_type' ),
				                  'file'      => get_sub_field( 'file' ),
			                  ] );
			                  ?>
                      <?php $preview_count++; endwhile; ?>
                    <?php endif; ?>

	                  <?php
	                  array_push( $schemaHasPart, [
		                  'file_type'        => get_sub_field( 'file_type' ),
		                  'file_name'        => get_sub_field( 'file_name' ),
		                  'file_description' => get_sub_field( 'file_description' ),
		                  'file'             => get_sub_field( 'file' ),
	                  ] );
	                  ?>

                  <?php endwhile; ?>

                </div>

              <?php endif; ?>

              <?php if ( get_field('additional_data_information') ): ?>
                <div style="height:40px;"></div>
                <?php the_field('additional_data_information'); ?>
              <?php endif; ?>

            </div>
          </div>
      </div>
    </div>
  </div>
</div>


<?php if ( get_field('show_newsletter_signup') ): ?>
<section class="f8-section">
  <div class="grid-container">

    <div class="cta-box bg-purple">

      <div class="cta-box-form form-box">
        <h3><?php _e( 'Interested in Vessel updates?', 'appen' ); ?></h3>
        <p><?php _e( 'Sign up to receive Vessel communications', 'appen' ); ?></p>

        <script src="//app-ab14.marketo.com/js/forms2/js/forms2.min.js" data-cookieconsent="ignore"></script>
        <form id="mktoForm_1698"></form>

        <script data-cookieconsent="ignore">MktoForms2.loadForm("//app-ab14.marketo.com", "416-ZBE-142", 1698, function(form) {
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

            form.onSuccess(function(values, followUpUrl) {

              jQuery('.cta-box-form').fadeOut();
              jQuery('.thank-you-form-message').fadeIn();

              return false;
            });

          });</script>


      </div>

      <div class="thank-you-form-message" style="display: none;">
        <h3><?php _e( 'Thank You!', 'appen' ); ?></h3>
        <p><?php _e( 'You’ve been subscribed to our Vessel Communications. You’ll hear from us soon.', 'appen' ); ?></p>
      </div>

    </div>
  </div>
</section>
<?php endif; ?>

<script type="application/ld+json">
<?php
    $schemaCreator = '"creator":{
            "@type":"Organization",
            "url": "https://www.appen.com/",
            "name":"Appen",
            "contactPoint":{
                "@type":"ContactPoint",
                "contactType": "customer service",
                "telephone":"+1-646-224-1146",
                "email":"hello@appen.com"
            }
        }';
?>
    {
        "@context":"https://schema.org/",
        "@type":"Dataset",
        "name":"<?php the_title(); ?>",
        "description":"<?php echo sanitize_text_field( get_field('short_description') ); ?>",
        "url":"<?php echo appenGetCurrentUrl(); ?>",
        "sameAs":"https://drive.google.com/file/d/1NKkSQ5T0ZNQ8aUhh0a8Dt2YKYCQXIViw/view?usp=sharing",
        "identifier": ["<?php echo appenGetCurrentUrl(); ?>"],
        "keywords":[
            "Image segmentation",
            "Pathology",
            "Image color analysis",
            "Semantics",
            "Machine learning algorithms",
            "Task analysis",
            "Deep learning"
        ],
        "license" : "https://creativecommons.org/publicdomain/zero/1.0/",
        <?php
            if ( $schemaHasPart && is_array( $schemaHasPart ) ) {
                echo '"hasPart" : [';
	                $firstHasPart = true;
                    foreach ( $schemaHasPart as $item ) {
            printf( '%s
            {
                "@type": "Dataset",
                "name": "%s",
                "description": "%s",
                "license" : "https://creativecommons.org/publicdomain/zero/1.0/",
                %s
                }',
	            $firstHasPart ? '' : ',',
                $item['file_name'],
                sanitize_text_field($item['file_description']),
	            $schemaCreator
            );
	                    if ( $firstHasPart ) {
		                    $firstHasPart = false;
	                    }
                    }
                echo '
        ],';
            }
        ?>

        <?php echo $schemaCreator; ?>,
        "includedInDataCatalog":{
            "@type":"DataCatalog",
            "name":"Open Source Datasets from Appen"
        }
        <?php
	if ( $schemaHasPart && is_array( $schemaHasPart ) ) {
		echo ',
		"distribution":[';
		$firstDistrib = true;
		foreach ( $schemaHasPart as $itemPart ) {

			printf( '%s
            {
                "@type":"DataDownload",
                "encodingFormat":"%s",
                "contentUrl":"%s"
                }',
				$firstDistrib ? '' : ',',
				$itemPart['file_type'],
				$itemPart['file']
			);
			if ( $firstDistrib ) {
				$firstDistrib = false;
			}
		}
		if ( $schemaDistrib && is_array( $schemaDistrib ) ) {
			foreach ( $schemaDistrib as $itemDistrib ) {

				printf( '%s
            {
                "@type":"DataDownload",
                "encodingFormat":"%s",
                "contentUrl":"%s"
                }',
					$firstDistrib ? '' : ',',
					$itemDistrib['file_type'],
					$itemDistrib['file']
				);
				if ( $firstDistrib ) {
					$firstDistrib = false;
				}
			}
        }
		echo '
        ]';
	}
	?>
    }
</script>
