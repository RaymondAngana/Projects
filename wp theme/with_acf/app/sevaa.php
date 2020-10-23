<?php

// Add menu page for site options
if( function_exists('acf_add_options_page') ) {
	acf_add_options_page(array(
		'page_title' 	=> 'Site Options',
		'menu_title'	=> 'Site Options',
		'menu_slug' 	=> 'site-options',
		'capability'	=> 'edit_posts',
		'redirect'		=> true
	));

	acf_add_options_sub_page(array(
		'page_title' 	=> 'Social Accounts',
		'menu_title'	=> 'Social Accounts',
		'parent_slug'	=> 'site-options'
	));

	acf_add_options_sub_page(array(
		'page_title' 	=> 'Podcast Links',
		'menu_title'	=> 'Podcast Links',
		'parent_slug'	=> 'site-options'
	));

	acf_add_options_sub_page(array(
		'page_title' 	=> 'Global Content',
		'menu_title'	=> 'Global Content',
		'parent_slug'	=> 'site-options'
	));

	acf_add_options_sub_page(array(
		'page_title' 	=> 'Specialty Modal',
		'menu_title'	=> 'Specialty Modal',
		'parent_slug'	=> 'site-options'
	));

	acf_add_options_sub_page(array(
		'page_title' 	=> 'Email Disclaimer',
		'menu_title'	=> 'Email Disclaimer',
		'parent_slug'	=> 'site-options'
	));

	acf_add_options_sub_page(array(
		'page_title' 	=> 'SOLR',
		'menu_title'	=> 'SOLR',
		'parent_slug'	=> 'site-options'
	));
}

// custom image sizes
add_image_size( 'person-bubble', 140, 140, true );
add_image_size( 'thumb-insight', 635, 305, true );
add_image_size( 'full-insight', 1024, 500, true );
add_image_size( 'thumb-person', 240, 275, true );
add_image_size( 'full-person', 515, 616, true );
add_image_size( 'half-width', 720, 9999, false ); // width of md container for collapsed columns
add_image_size( 'full-width', 1140, 9999, false ); // width of xl container
add_image_size( 'third-width', 720, 9999, false ); // width of md container for collapsed columns

// Adds additional file upload support 
function ogletree_upload_mimes($mimes = array()) {
	$mimes['vcf'] = "text/vcard";
	return $mimes;
}
add_action('upload_mimes', 'ogletree_upload_mimes');

function ogletree_file_and_ext( $types, $file, $filename, $mimes )
{
	if( false !== strpos( $filename, '.css' ) )
	{
		$types['ext'] = 'css';
		$types['type'] = 'text/css';
	} elseif(false !== strpos( $filename, '.js' )){
		$types['ext'] = 'js';
		$types['type'] = 'application/javascript';
	} elseif(false !== strpos( $filename, '.swf' )){
		$types['ext'] = 'swf';
		$types['type'] = 'application/x-shockwave-flash';
	}
	return $types;
}
add_filter( 'wp_check_filetype_and_ext', 'ogletree_file_and_ext', 10, 4 );

// extend wp_nav_menu
add_filter( 'wp_nav_menu_objects', 'my_wp_nav_menu_objects_sub_menu', 10, 2 );
// filter_hook function to react on sub_menu flag
function my_wp_nav_menu_objects_sub_menu( $sorted_menu_items, $args ) {
  if ( isset( $args->sub_menu ) ) {
    $root_id = 0;

		// find the current menu item
		$the_post = get_post();
    foreach ( $sorted_menu_items as $menu_item ) {
			if(function_exists('\OdLanguageSelect\od_languages')){
				$trans_id = apply_filters( 'wpml_object_id', $menu_item->object_id, $menu_item->object );
				$trans = $trans_id ? get_post($trans_id) : null;
				$is_trans = $trans == $the_post;
			} else {
				$is_trans = false;
			}
			if ( $menu_item->current || $is_trans ) {
        // set the root id based on whether the current menu item has a parent or not
        $root_id = ( $menu_item->menu_item_parent ) ? $menu_item->menu_item_parent : $menu_item->ID;
        break;
      }
    }

    // find the top level parent
    if ( ! isset( $args->direct_parent ) ) {
      $prev_root_id = $root_id;
      while ( $prev_root_id != 0 ) {
        foreach ( $sorted_menu_items as $menu_item ) {
          if ( $menu_item->ID == $prev_root_id ) {
            $prev_root_id = $menu_item->menu_item_parent;
            // don't set the root_id to 0 if we've reached the top of the menu
            if ( $prev_root_id != 0 ) $root_id = $menu_item->menu_item_parent;
            break;
          }
        }
      }
    }
    $menu_item_parents = array();
    foreach ( $sorted_menu_items as $key => $item ) {
      // init menu_item_parents
      if ( $item->ID == $root_id ) $menu_item_parents[] = $item->ID;
      if ( in_array( $item->menu_item_parent, $menu_item_parents ) ) {
        // part of sub-tree: keep!
        $menu_item_parents[] = $item->ID;
      } else if ( ! ( isset( $args->show_parent ) && in_array( $item->ID, $menu_item_parents ) ) ) {
        // not part of sub-tree: away with it!
        unset( $sorted_menu_items[$key] );
      }
    }

    return $sorted_menu_items;
  } else {
    return $sorted_menu_items;
  }
}

// add custom body classes
add_filter( 'body_class', function( $classes ) {
	if(is_page(2673)) {
		return array_merge( $classes, array( 'disaster-resource-center' ) ) ;
	} elseif(get_page_template_slug( get_the_id() ) == 'page-templates/page_locations.blade.php') {
		return array_merge( $classes, array( 'locations' ) ) ;
	} elseif(is_post_type_archive('od_person')) {
		return array_merge( $classes, array( 'people' ) ) ;
	} elseif(is_page()) {
		return array_merge( $classes, array( 'flexcontent' ) ) ;
	} elseif(is_tax('od_intl_art_edition')) {
		return array_merge( $classes, array( 'international-newsletter' ) ) ;
	} else {
		return $classes;
	}
});

// custom function to output and forcefully display array/object contents
function poke($var) {
	print '<pre style="padding:1rem;text-align:left;background-color:white;color:black;z-index:99999;position:fixed;overflow:scroll;top:0;right:0;bottom:0;left:0;">';
	print_r($var);
	print '</pre>';
}

// custom function to output comma separate list of terms
function term_list($cat = 'category', $linked = false) {
	$terms = get_the_terms(get_the_id(), $cat);
	$output = array();
	if($terms) {
		foreach($terms as $term){
			if($linked) {
				$output[] = '<a href="'.get_post_type_archive_link('od_insight').'?cat='.$term->term_taxonomy_id.'">'.$term->name.'</a>';
			} else {
				$output[] = $term->name;
			}
		}
	}
	echo implode(', ', $output);
}

// create addtoany service for download PDF functionality
function addtoany_add_share_services( $services ) {
	$services['download-pdf'] = array(
		'name'        => 'Download PDF',
		'icon_url'    => '/app/themes/ogletree/resources/assets/images/icons/addtoany/download.svg',
		'icon_width'  => 23,
		'icon_height' => 23,
		'href'        => get_admin_url() . 'admin-post.php?action=get_pdf&pid=' . get_the_id(),
	);
	$services['download-podcast'] = array(
		'name'        => 'Download Podcast',
		'icon_url'    => '/app/themes/ogletree/resources/assets/images/icons/addtoany/download.svg',
		'icon_width'  => 23,
		'icon_height' => 23,
		'href'        => get_field('media_url', get_the_id()),
	);
	$services['download-publication'] = array(
		'name'        => 'Download Publication',
		'icon_url'    => '/app/themes/ogletree/resources/assets/images/icons/addtoany/download.svg',
		'icon_width'  => 23,
		'icon_height' => 23,
		'href'        => get_field('pdf', get_the_id())['url'],
	);
	$services['subscribe-podcast'] = array(
		'name'        => 'Subscribe',
		'icon_url'    => '/app/themes/ogletree/resources/assets/images/icons/addtoany/subscribe.svg',
		'icon_width'  => 20,
		'icon_height' => 20,
		'href'        => 'javascript:void(0)',
	);
	return $services;
}
add_filter( 'A2A_SHARE_SAVE_services', 'addtoany_add_share_services', 10, 1 );

// alter gravity form ajax spinner image to use css background image method
add_filter("gform_ajax_spinner_url", "spinner_url", 10, 2);
function spinner_url($image_src, $form){
	return '/app/themes/ogletree/resources/assets/images/blank.png';
}

// disable anchor for newsletter signup form
add_filter('gform_confirmation_anchor_1', '__return_false');

function od_office_phone_link( $office_id = 0 ) {
	$phone = get_field('phone', $office_id);
	$phone_stripped = preg_replace('/[^0-9]/', '', $phone);
	$country_array = get_field('country', $office_id);
	$country_code = $country_array['value'];
	if($country_code == 'US' || $country_code == 'VI' || $country_code == 'CA') {
		$output = '+1' . $phone_stripped;
	} elseif($country_code == 'MX' ) {
		$output = '+52' . $phone_stripped;
	} else {
		$output = '+' . $phone_stripped;
	}
	return $output;
}

function od_person_phone_link( $person_id = 0 ) {

	$phone = get_field('phone', $person_id);
	$phone_stripped = preg_replace('/[^0-9]/', '', $phone);
	$thing = get_field('title_and_location', $person_id);
	if(get_field('non_attorney', $person_id)){
		return '+1' . $phone_stripped;
	}
	$location_id = get_field('title_and_location', $person_id)[0]['location']->ID;
	$country_array = get_field( 'country', $location_id );

	$country_code = $country_array['value'];
	if(
		($country_code == 'US' || $country_code == 'VI' || $country_code == 'CA')
		&& strlen($phone_stripped) <= 10
	) {
		$output = '+1' . $phone_stripped;
	} else {
		$output = '+' . $phone_stripped;
	}
	return $output;
}

// save acf-json in /wp-content
add_filter('acf/settings/save_json', function($path) {
    return WP_CONTENT_DIR . '/acf-json';
});

// load acf-json from /wp-content
add_filter('acf/settings/load_json', function($paths) {
  unset($paths[0]);
  $paths[] = WP_CONTENT_DIR . '/acf-json';
  return $paths;
});

// suppress certain post type's single view
add_action( 'template_redirect', 'od_redirect_news' );
function od_redirect_news() {
	$queried_post_type = get_query_var('post_type');
	global $post;
  // if ( is_single() && 'od_news' ==  $queried_post_type ) {
	// 	wp_redirect( get_field('link', $post->ID), 301 );
  //   exit;
	// }
	if ( is_single() && 'od_location' == $queried_post_type && get_field('satellite_location', $post->ID) == 1 ) {
		wp_redirect( get_permalink(8) );
		exit;
	}
}

/**
 * Loads address data by post ID, then formats the address
 *
 * @param int $id
 * @param string $format
 * @return string
 */
function od_address($id, $format = 'letter') {

  // Set up some spacers
  $sep = '<span class="sep">,&nbsp;</span>';
  $space = '<span class="space">&nbsp;</span>';

  // Retrieve address data
	// $addr = get_field('address', $id);
	$subfields = array('country', 'organization_name', 'thoroughfare', 'premise', 'sub_premise', 'locality', 'administrative_area', 'postal_code', 'dependent_locality', 'sub_administrative_area');
	foreach($subfields as $subfield) {
		$addr[$subfield] = get_field($subfield, $id);
	}

  // Tweak some fields and hold on to some raw data
  $country_code = $addr['country']['value'];
  $addr['country'] = $addr['country']['label'];
  $addr['raw_administrative_area'] = $addr['administrative_area'];

  // Wrap data in spans for display
  foreach ($addr as $key => &$value) {
    if (strpos($key, 'raw_') !== 0 && $value) {
      $value = '<span class="' . $key . '">' . $value . '</span>';
    }
  }

  // Begin building output
	$output = '';

	if ($addr['organization_name']) $output .= '<div>' . $addr['organization_name'] . '</div>';

	if ($country_code == 'MX' && $addr['thoroughfare'] && $addr['premise']) {
    $output .= '<div>' . $addr['thoroughfare'] . $sep . $addr['premise'] . '</div>';
  } else {
    if ($addr['thoroughfare']) $output .= '<div>' . $addr['thoroughfare'] . '</div>';
    if ($addr['premise']) $output .= '<div>' . $addr['premise'] . '</div>';
  }

	if ($addr['sub_premise'])       $output .= '<div>' . $addr['sub_premise'] . '</div>';

	// Style the last few lines based on country code
	switch ($country_code) {
    case 'MX': // Mexico
      if ($addr['dependent_locality']) $output .= '<div>' . $addr['dependent_locality'] . '</div>';
      if (in_array($addr['raw_administrative_area'], ['CDMX', 'CMX', 'DF']) ) {
        $output .= '<div>' . $addr['postal_code'] . $space . '<span class="locality">Ciudad de México</span></div>';
      } else {
        $output .= '<div>' . $addr['postal_code'] . $space . $addr['locality'] . $sep . $addr['administrative_area'] . '</div>';
      }
      $output .= '<div>' . $addr['country'] . '</div>';
      break;
    case 'UK': // United Kingdom
      $output .= '<div>' . $addr['locality'] . $sep . $addr['postal_code'] . '</div>';
      break;
    case 'FR':
      $output .= '<div>' . $addr['postal_code'] . $space . $addr['locality'] . '</div>';
      $output .= '<div>' . $addr['country'] . '</div>';
      break;
    case 'DE':
      $output .= '<div>' . $addr['postal_code'] . $space . $addr['locality'] . '</div>';
      $output .= '<div>' . $addr['country'] . '</div>';
      break;
    default:
      if (in_array($addr['raw_administrative_area'], ['DC']) ) {
        $output .= '<div><span class="locality">Washington D.C.</span>' . $space . $addr['postal_code'] . '</div>';
      } else {
        $output .= '<div>' . $addr['locality'] . $sep . $addr['administrative_area'] . $space . $addr['postal_code'] . '</div>';
      }
  }

	if($format == 'inline') {
		$output = str_replace( ['<div>', '</div>'], ['', $sep], $output);
		// Remove that last separator
		$output = substr($output, 0, strlen($sep) * -1);
	}

	return $output;
}

/**
 * Outputs fancy date for multi-value events
 *
 * @param int $id
 * @return string
 */
function od_event_fancy_date($id = 0) {
	$output = '';
	if($id == 0) $id = get_the_id();
	$dates = get_field('dates', $id);
		if(count($dates) < 2): // single date
				$output .= '<div class="day">'. date('j', strtotime($dates[0]['start'])) . '</div>';
				$output .= '<div class="month">' . __(date('M', strtotime($dates[0]['start']))) . '</div>';
				$output .= '<div class="year">' . date('Y', strtotime($dates[0]['start'])) . '</div>';
		else: // multiple
			$months = array();
			foreach($dates as $date):
				$months[date('m', strtotime($date['start']))] = date('m', strtotime($date['end']));
			endforeach;
			if(count($months) < 2): // if all dates are within a single month
				$day_span = date('j', strtotime($dates[0]['start'])) . '-' . date('j', strtotime($dates[count($dates) - 1]['start']));
				$output .= '<div class="day span length-' . strlen($day_span) . '">' . $day_span . '</div>';
				$output .= '<div class="month">' . __(date('M', strtotime($dates[0]['start']))) . '</div>';
				$output .= '<div class="year">' . date('Y', strtotime($dates[0]['start'])) . '</div>';
			else: // if dates span multiple months
				// foreach($dates as $date):
				// 	$output .= '<div class="month day-month">' . date('j M', strtotime($date['start'])) . '</div>';
				// endforeach;
				$output .= '<div class="month day-month">' . __(date('j M', strtotime($dates[0]['start']))) . '</div>';
				$output .= '<div class="month day-month">' . __(date('j M', strtotime($dates[count($dates) - 1]['end']))) . '</div>';
				$output .= '<div class="year">' . date('Y', strtotime($dates[count($dates) - 1]['end'])) . '</div>';
			endif;
		endif;

		return $output;
}

add_filter( 'nav_menu_link_attributes', 'ogletree_main_menu_atts', 10, 3 );
function ogletree_main_menu_atts( $atts, $item, $args )
{
	$atts['data-text'] = __($item->title, 'ogletree');
  return $atts;
}

/**
 * Returns featured image with fallbacks for od_insight and od_podcast
 *
 * @param int $id
 * @return string
 */
function od_insight_image($id = 0) {
	$output = '';
	if($id == 0) $id = get_the_id();

	if(has_post_thumbnail( $id )) {
    $output .= get_the_post_thumbnail( $id, 'thumb-insight' );
  } else {
		$images = array();
		$post_cats = wp_get_post_terms($id, 'category');
		foreach($post_cats as $cat) {
			$cat_images = get_field('images', $cat);
			if(!empty($cat_images)) {
				foreach($cat_images as $image) {
					$images[] = $image['image']['ID'];
				}
			}
		}
		if(!empty($images)) {
			$output .= wp_get_attachment_image( $images[array_rand($images, 1)], 'thumb-insight' );
		} else {
			$output .= wp_get_attachment_image( get_field('insight_fallback_image', 'option')['id'], 'thumb-insight' );
		}
	}

	return $output;
}


add_action('admin_head', 'od_admin_styles');

function od_admin_styles() {
  echo '<style>
    #media-search-input {
      visibility: hidden !important;
		}
		.post-type-od_news div#postimagediv,
		.post-type-od_news label[for="postimagediv-hide"],
		.post-type-od_press_release div#postimagediv,
		.post-type-od_press_release label[for="postimagediv-hide"],
		.post-type-od_job div#postimagediv,
		.post-type-od_job label[for="postimagediv-hide"] { display: none !important; }
  </style>';
}


// Rename certain archives
add_filter( 'post_type_archive_title', function ($title) {
	if( is_post_type_archive('od_insight') ) {
    $title = __('Blog', 'ogletree');
  } elseif( is_post_type_archive('od_job') ) {
		$title = __('Job Opportunities', 'ogletree');
  } elseif( is_post_type_archive('od_news') ) {
		$title = __('Media Center', 'ogletree');
  } elseif( is_post_type_archive('od_press_release') ) {
    $title = __('Media Center', 'ogletree');
  }
  return $title;
}, 9);


add_action('admin_menu', 'remove_built_in_roles');
function remove_built_in_roles() {
    global $wp_roles;

    $roles_to_remove = array('subscriber', 'contributor', 'author', 'wpseo_manager', 'wpseo_editor');

    foreach ($roles_to_remove as $role) {
        if (isset($wp_roles->roles[$role])) {
            $wp_roles->remove_role($role);
        }
    }
}


// code to affect tinymce italic button for all excerpts
// source: https://marcgratch.com/add-tinymce-to-excerpt/
function lb_editor_remove_meta_box() {
    global $post_type;
/**
 *  Check to see if the global $post_type variable exists
 *  and then check to see if the current post_type supports
 *  excerpts. If so, remove the default excerpt meta box
 *  provided by the WordPress core. If you would like to only
 *  change the excerpt meta box for certain post types replace
 *  $post_type with the post_type identifier.
 */
    if (isset($post_type) && post_type_supports($post_type, 'excerpt')){
        remove_meta_box('postexcerpt', $post_type, 'normal');
    }
}
add_action('admin_menu', 'lb_editor_remove_meta_box');

function lb_editor_add_custom_meta_box() {
    global $post_type;
    /**
     *  Again, check to see if the global $post_type variable
     *  exists and then if the current post_type supports excerpts.
     *  If so, add the new custom excerpt meta box. If you would
     *  like to only change the excerpt meta box for certain post
     *  types replace $post_type with the post_type identifier.
     */
    if (isset($post_type) && post_type_supports($post_type, 'excerpt')){
        add_meta_box('postexcerpt', __('Excerpt'), 'lb_editor_custom_post_excerpt_meta_box', $post_type, 'normal', 'high');
    }
}
add_action( 'add_meta_boxes', 'lb_editor_add_custom_meta_box' );

function lb_editor_custom_post_excerpt_meta_box( $post ) {

    /**
     *  Adjust the settings for the new wp_editor. For all
     *  available settings view the wp_editor reference
     *  http://codex.wordpress.org/Function_Reference/wp_editor
     */
    $settings = array( 'media_buttons' => false, 'tinymce' => array('toolbar1' => 'italic', 'toolbar2' => '') );

    /**
     *  Create the new meta box editor and decode the current
     *  post_excerpt value so the TinyMCE editor can display
     *  the content as it is styled.
     */
    wp_editor(html_entity_decode(stripcslashes($post->post_excerpt)), 'excerpt', $settings);

    // The meta box description - adjust as necessary
    echo '<p><em>Excerpts are optional, hand-crafted, summaries of your content.</em></p>';
}

function od_scheduling_unpublish(){

    $people = get_posts(array(
        'numberposts' => -1,
        'post_type'   => 'od_person',
        'meta_key'    => 'enable_scheduling',
        'meta_value'  => true
    ));

    foreach ($people as $key => $p) {
        $unpublish_date = get_field("schedule_unpublish", $p->ID);

        $set_date = strtotime('+3 hour +55 minutes',strtotime($unpublish_date)); // at 3am
        $set_date = date('Y-m-d H:i:s A', $set_date);
        $current  = date('Y-m-d H:i:s A');
        echo '<br>'.$current.'='.$set_date;
        echo '<br>'.$current.'='.$set_date;
        echo '<br>'.$current.'='.$set_date;
        echo '<br>'.$current.'='.$set_date;
        if($current > $set_date){
            // echo $p->ID.' This person will be unpublish';
            wp_update_post(array( 'ID' => $p->ID, 'post_status' => 'draft'));
        }
    }
}
add_action('od_scheduling_unpublish', 'od_scheduling_unpublish');

if (! wp_next_scheduled ( 'od_scheduling_unpublish' )) {
		wp_schedule_event(time(), 'daily', 'od_scheduling_unpublish', []);
}

function od_mind_defer_scripts( $tag, $handle, $src ) {
  $defer = array( 
		'afr-js',
		'addtoany'
  );
  if ( in_array( $handle, $defer ) ) {
     return '<script src="' . $src . '" defer="defer" type="text/javascript"></script>' . "\n";
  }
    
    return $tag;
} 
// add_filter( 'script_loader_tag', 'od_mind_defer_scripts', 10, 3 );

function od_add_rel_preload($html, $handle, $href, $media) {
    
	if (is_admin())
			return $html;

	 $html = <<<EOT
<link rel='preload' as='style' onload="this.onload=null;this.rel='stylesheet'" id='$handle' href='$href' type='text/css' media='all' />
EOT;
	return $html;
}
// add_filter( 'style_loader_tag', 'od_add_rel_preload', 10, 4 );


add_filter('acf/load_field/name=firm_overview', function($fields){
	$i = 0;
	$choices = [];
	$options = get_field('firm_overview_options', 'option');
	foreach($options as $key => $value){
		$choices['Blurb_' . $i] = $value['overview'];
		$i++;
	}
	
	$fields['choices'] = $choices;
	return $fields;
}, 20, 3);
