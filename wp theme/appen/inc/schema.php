<?php
add_action( 'wp_footer', 'appenSchemaFooter' );
function appenSchemaFooter() {
	if ( is_page( 'off-the-shelf-datasets' ) ) : ?>
		<?php
	    global $wpdb;
	    $results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}ots_catalog_2 ORDER BY `dataset_name` ASC" );
	    if(!empty($results)) {
	    	$length = count($results);
	    	$i = 1;
    	?>
		<script type="application/ld+json">
			{
				"@context":"https://schema.org/",
				"@type":"DataCatalog",
				"name":"<?php the_title(); ?>",
				"description":"<?php echo sanitize_text_field( get_field( 'short_description' ) ); ?>",
				"url":"<?php echo appenGetCurrentUrl(); ?>",
				"identifier": ["<?php echo appenGetCurrentUrl(); ?>"],
				"keywords":[
					"machine learning datasets",
					"dataset repository",
					"speech datasets",
					"ml dataset repository",
					"Machine learning algorithms",
					"Task analysis",
					"Deep learning"
				],
				"license" : "https://creativecommons.org/licenses/by-nc-nd/4.0/",
				"hasPart" : [
					<?php foreach($results as $row) { ?>
					<?php
						$description = "";
						$description .= $row->product_type;
						if(!empty($row->common_use_cases)) { 
							$common_use_cases = explode('|', $row->common_use_cases); 
							$description .= ' - '.implode(', ', $common_use_cases); 
						}
						$description .= ' - '.$row->recording_device;
						$description .= ' - '.$row->unit;
						$description .= ' - '.$row->source;
						$description .= ' - '.$row->detailed_product_type;
						$description .= ' - '.$row->language;
						$description .= ' - '.$row->country;
						$description .= ' - '.$row->recording_condition;
						$description .= ' - '.$row->contributors;
						$description .= ' - '.$row->channels;
						$description .= ' - '.$row->utterances;
						$description .= ' - '.$row->unique_word;
						$description .= ' - '.$row->sample_rate;
						$description .= ' - '.$row->data_format;
						$description .= ' - '.str_replace('|', ' ', $row->additional_info); 
					?>
					{
						"@type": "Dataset",
						"name": "<?php echo $row->dataset_name; ?>",
						"description": "<?php echo $description; ?>",
						"license" : "https://creativecommons.org/licenses/by-nc-nd/4.0/",
                        "creator":{
                            "@type":"Organization",
                            "url": "https://www.appen.com/",
                            "name":"Appen",
                            "contactPoint":{
                                "@type":"ContactPoint",
                                "contactType": "customer service",
                                "telephone":"+1-646-224-1146",
                                "email":"hello@appen.com"
                            }
                        }
					}<?php $i++; if($i <= $length) { ?>,<?php } ?>
					<?php } ?>
				],
				"creator":{
					"@type":"Organization",
					"url": "https://www.appen.com/",
					"name":"Appen",
					"contactPoint":{
						"@type":"ContactPoint",
						"contactType": "customer service",
						"telephone":"+1-646-224-1146",
						"email":"hello@appen.com"
					}
				}
			}

		</script>
		<?php } ?>
	<?php endif;
}