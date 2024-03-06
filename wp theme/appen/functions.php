<?php

// =============================================================================
// FUNCTIONS.PHP
// -----------------------------------------------------------------------------
// Overwrite or add your own custom functions to Pro in this file.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Enqueue Parent Stylesheet
//   02. Additional Functions
// =============================================================================

// Enqueue Parent Stylesheet
// =============================================================================

add_filter('x_enqueue_parent_stylesheet', '__return_true');

// Additional Functions
// =============================================================================

require_once get_stylesheet_directory() . '/inc/functions.php';

/* Research Papers : Change permalink to custom url using post meta */
add_filter('post_link', 'research_papers_external_permalink', 10, 2);
function research_papers_external_permalink($link, $post) {
	$meta = get_post_meta($post->ID, 'research_paper_link', true);
	$url = esc_url(filter_var($meta, FILTER_VALIDATE_URL));
	return $url ? $url : $link;
}

function appen_wp_tag_meta_appen_for_custom() {
	$all_data = get_post_meta(get_the_ID());
	$keywords = get_post_meta(get_the_ID(), '_yoast_wpseo_focuskw');
	$keywords_fk = get_post_meta(get_the_ID(), '_yoast_wpseo_focuskeywords')[0];
	$keywords_fk_array = json_decode($keywords_fk, true);
	$arr = array();
	foreach ($keywords as $key => $value) {
		array_push($arr, $value);
	}
	foreach ($keywords_fk_array as $key => $value) {
		array_push($arr, $value['keyword']);
	}
	$List = implode(', ', $arr);
	?>
	<meta name="keywords" content="testme, <?php echo $List; ?>">
	<?php

}

$wpseo = WPSEO_Frontend::get_instance();
//remove_action( 'wpseo_head', array( $wpseo, 'canonical' ), 20 );
add_action('wpseo_head', 'appen_wp_tag_meta_appen_for_custom', -1);