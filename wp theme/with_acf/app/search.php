<?php

// add_filter('relevanssi_content_to_index', 'rlv_relationship_content', 10, 2);
// function rlv_relationship_content($content, $post) {
// 	if(get_post_type($post) == 'od_person'){
// 		$relationships = get_post_meta($post->ID, 'bar_admission', true);
// 		if (!is_array($relationships)) $relationships = array($relationships); 
// 		foreach ($relationships as $related_post) {
// 			$content .= " " . get_the_title($related_post);
// 		}
// 	}

// 	if(get_post_type($post) == 'od_insight'){
// 		$relationships = get_post_meta($post->ID, 'authors', true);
// 		if (!is_array($relationships)) $relationships = array($relationships); 
// 		foreach ($relationships as $related_post) {
// 			$content .= " " . get_the_title($related_post);
// 		}
// 	}
	
// 	if(get_post_type($post) == 'od_webinar' || get_post_type($post) == 'od_seminar' || get_post_type($post) == 'od_podcast'){
// 		$relationships = get_post_meta($post->ID, 'speakers', true);
// 		if (!is_array($relationships)) $relationships = array($relationships); 
// 		foreach ($relationships as $related_post) {
// 			$content .= " " . get_the_title($related_post);
// 		}
// 	}

// 	if(get_post_type($post) == 'od_webinar' || get_post_type($post) == 'od_seminar'){
// 		$relationships = get_post_meta($post->ID, 'moderators', true);
// 		if (!is_array($relationships)) $relationships = array($relationships); 
// 		foreach ($relationships as $related_post) {
// 			$content .= " " . get_the_title($related_post);
// 		}
// 	}

// 	if(get_post_type($post) == 'od_job'){
// 		$relationships = get_post_meta($post->ID, 'location', true);
// 		if (!is_array($relationships)) $relationships = array($relationships); 
// 		foreach ($relationships as $related_post) {
// 			$content .= " " . get_the_title($related_post);
// 		}
// 	}
	

// 	// Fetching the post data by the relationship field
// 	$relationships = get_post_meta($post->ID, 'moderators', true);
// 	if (!is_array($relationships)) $relationships = array($relationships); 
// 	foreach ($relationships as $related_post) {
// 		$content .= " " . get_the_title($related_post);
// 	}

// 	if(get_post_type($post) == 'od_person'){
// 		// Fetching the name of the taxonomy connection field information field
// 		// The name of this field is the name of your taxonomy connection field with an underscore prefix
// 		$taxonomy_info_field_name = get_post_meta($post->ID, '_bar_admission', true);
	
// 		// Fetching the name of the taxonomy from the information field
// 		global $wpdb;
// 		$taxonomy_field_info = $wpdb->get_var($wpdb->prepare("SELECT meta_value FROM $wpdb->postmeta WHERE meta_key = %s", $taxonomy_info_field_name));
// 		$taxonomy_field_info = unserialize($taxonomy_field_info);
// 		$taxonomy = "";
// 		if (isset($taxonomy_field_info['taxonomy'])) $taxonomy = $taxonomy_field_info['taxonomy'];
	
// 		// Or you can just skip all that and set the $taxonomy variable directly
	
// 		// Fetching the taxonomy term data
// 		if (isset($taxonomy)) {
// 			$taxonomies = get_post_meta($post->ID, 'bar_admission', true);
// 			if (!is_array($taxonomies)) $taxonomies = array($taxonomies);
// 			foreach ($taxonomies as $term_id) {
// 				$term = get_term($term_id, $taxonomy);
// 				$content .= " " . $term->name;
// 			}
// 		}
// 	}
// 	return $content;
// }
// function od_get_search_query($post_type, $per_page, $s, $paged){
// 	$args = array(
// 		'post_type' => $post_type,
// 		'posts_per_page' => $per_page ?: -1,
// 		's' => $s,
// 		'paged' => $paged
// 	);
// 	return new WP_Query($args);
// }
// function apply_query_overrides($query, $overrides){
// 	foreach($overrides as $key => $value){
// 		$query->set($key, $value);
// 	}
// 	return $query;
// }
// function cat_query_override($cat){
// 	return $cat ? array('cat' => $_GET['cat']) : array();
// }
// function keyword_query_override($keyword){
// 	return $keyword ? array('s' => $keyword) : array();	
// }
// function sticky_post_overrides(){
// 	return array(
// 		// sticky featured at top of list, then sort by post date
// 		// 'meta_query' => array(
// 		// 	'relation' => 'AND',
// 		// 	'featured' => array(
// 		// 		'key' => 'featured',
// 		// 	),
// 		// ),
// 		'orderby' => array(
// 			// 'featured' => 'DESC',
// 			'post_date' => 'DESC',
// 		)	
// 	); 
// }
// function insights_overrides($keyword, $cat){
// 	return array_replace(
// 		sticky_post_overrides(),
// 		keyword_query_override($keyword),
// 		cat_query_override($cat)
// 	);
// }

// add_action( 'pre_get_posts', 'ogletree_search');
// function ogletree_search( $query ) {
// 	$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : null;
// 	$cat = isset($_GET['cat']) ? $_GET['cat'] : null; 
	
// 	// do not modify queries in the admin
// 	if( is_admin() ) return $query;

// 	// main search
// 	if ($query->is_main_query() && is_search() ) {
// 		return;
// 	}

// 	// insights archives
// 	if( $query->is_main_query() && is_post_type_archive('od_insight') ) {
// 		apply_query_overrides(
// 			$query,
// 			insights_overrides($keyword, $cat)
// 		);
// 		if(!isset($_GET['archive']) || $_GET['archive'] != true){
// 			$query->set('date_query', array(
// 				'after' => '2015-01-01',
// 			));
// 		}
// 	} // insights archives

// 	// podcasts archives
// 	if( $query->is_main_query() && is_post_type_archive('od_podcast') ) {

// 		// sticky featured at top of list, then sort by post date
// 		$query->set('meta_query', array(
// 			'relation' => 'AND',
// 			// 'featured' => array(
// 				// 'key' => 'featured',
// 				// 'compare' => 'EXISTS',
// 			// ),
// 		));
// 		$query->set('orderby', array(
// 			// 'featured' => 'DESC',
// 			'post_date' => 'DESC',
// 		));

// 		if( isset($_GET['keyword']) ) $query->set( 's', $_GET['keyword']);
// 			// $query->set( 'meta_query', array(
// 			// 	array(
// 			// 		'key' => 'authors_search_index',
// 			// 		'value' => $_GET['keyword'],
// 			// 		'compare' => 'LIKE'
// 			// 	),
// 			// ));

// 		if( isset($_GET['cat']) ) $query->set( 'cat', $_GET['cat']);
// 	} // podcasts archives

// 	// people archives
// 	if( $query->is_main_query() && is_post_type_archive('od_person') ) {

// 		$query->set('posts_per_page', 6);

// 		// sort by last name
// 		$query->set('meta_query', array(
// 			'relation' => 'AND',
// 			'last_name' => array(
// 				'key' => 'last_name',
// 				// 'compare' => 'EXISTS',
// 			),
// 			'first_name' => array(
// 				'key' => 'first_name',
// 				// 'compare' => 'EXISTS',
// 			),
// 		));
// 		$query->set('orderby', array(
// 			'last_name' => 'ASC',
// 			'first_name' => 'ASC',
// 		));

// 		if( isset($_GET['keyword']) ) $query->set( 's', $_GET['keyword']);

// 		if( isset($_GET['name_search']) ) {
// 			$name_search_array = explode(' ', $_GET['name_search']);
// 			$new_query = $query->get('meta_query');

// 			$new_query['name_search'] = array('relation' => 'AND');
// 			$fields = array('first_name', 'middle_initial', 'last_name', 'generational_name', 'alt_surname', 'nick_name', 'common_misspellings');
// 			$count = 0;

// 			foreach($name_search_array as $word) {
// 				$new_query['name_search']['name_search_'.$count] = array('relation' => 'OR');
// 				foreach($fields as $field) {
// 					$new_query['name_search']['name_search_'.$count]['name_search_'.$count.'_'.$field] = array(
// 						'key' => $field,
// 						'value' => $word,
// 						'compare' => 'LIKE',
// 					);
// 				}
// 				$count++;
// 			}
// 			$query->set('meta_query', $new_query);
// 		}

// 		if( isset($_GET['location']) && $_GET['location'] != 'all' ) {
// 			$new_query = $query->get('meta_query');
// 			$new_query['location'] = array(
// 				'key' => 'title_and_location_$_location', // search all rows
// 				'value' => $_GET['location'],
// 				'compare' => '='
// 			);
// 			$query->set('meta_query', $new_query);
// 		}

// 		if( isset($_GET['title']) && $_GET['title'] != 'all' ) {
// 			$new_query = $query->get('meta_query');
// 			$new_query['title'] = array(
// 				'key' => 'title_and_location_$_title', // search all rows
// 				'value' => $_GET['title'],
// 				'compare' => 'LIKE'
// 			);
// 			$query->set('meta_query', $new_query);
// 		}

// 		if( isset($_GET['group']) && $_GET['group'] != 'all' ) {
// 			$new_query = $query->get('meta_query');
// 			$new_query['areas_of_practice'] = array(
// 				'key' => 'areas_of_practice',
// 				'value' => $_GET['group'],
// 				'compare' => 'LIKE'
// 			);
// 			$query->set('meta_query', $new_query);
// 		}

// 		if( isset($_GET['bar']) && $_GET['bar'] != 'all' ) {
// 			// $query->set('tax_query', array(
// 			// 	'relation' => 'AND',
// 			// 	array(
// 			// 		'taxonomy' => 'od_bar_admission',
// 			// 		'field' => 'name',
// 			// 		'terms' => urldecode($_GET['bar']),
// 			// 	),
// 			// ));
// 			$new_query = $query->get('meta_query');
// 			$new_query['bar_admission'] = array(
// 				'key' => 'bar_admission_search_index',
// 				'value' => urldecode($_GET['bar']),
// 				'compare' => 'LIKE'
// 			);
// 			$query->set('meta_query', $new_query);
// 		}

// 		if( isset($_GET['glossary']) ) {
// 			$new_query = $query->get('meta_query');
// 			$new_query['glossary'] = array(
// 				'key' => 'last_name',
// 					'value' => '^'.$_GET['glossary'], // regex for 'starts with'
// 					'compare' => 'REGEXP'
// 			);
// 			$query->set('meta_query', $new_query);
// 		}

// 	} // people archives

// 	// webinars and seminars archives
// 	if ( $query->is_main_query() && (is_post_type_archive(array('od_webinar', 'od_seminar')) || (isset($query->query_vars['post_type']) && $query->query_vars['post_type'] == array('od_webinar', 'od_seminar'))) ) {
// 		$query = App\apply_events_query_vars($query);
// 	} // webinars and seminars archive

// 	// jobs archives
// 	if( $query->is_main_query() && is_post_type_archive('od_job') ) {

// 		$query->set('posts_per_page', 4);
		
// 		// set meta_query now so you can sort by it later
// 		$query->set('meta_query', array(
// 			'relation' => 'AND',
// 			'location' => array(
// 				'key' => 'location_search_index',
// 				// 'compare' => 'EXISTS'
// 			),
// 			'position' => array(
// 				'key' => 'position',
// 				// 'compare' => 'EXISTS',
// 			),
// 		));

// 		// default sort alphabetical by title
// 		$query->set('orderby', array(
// 			'post_title' => 'ASC',
// 		));

// 		if( isset($_GET['sort']) ) {
// 			if($_GET['sort'] == 'location') {
// 				$query->set('orderby', array(
// 					'location' => 'ASC',
// 					'post_title' => 'ASC',
// 				));
// 			} elseif($_GET['sort'] == 'position') {
// 				$query->set('orderby', array(
// 					'position' => 'DESC',
// 					'post_title' => 'ASC',
// 				));
// 			}
// 		}

// 		if( isset($_GET['keyword']) ) $query->set( 's', $_GET['keyword']);

// 		if( isset($_GET['location']) && $_GET['location'] != 'all' ) {
// 			$query->set( 'meta_query', array(
// 				'relation' => 'AND',
// 				array(
// 					'key' => 'location',
// 					'value' => $_GET['location'],
// 					'compare' => 'LIKE'
// 				),
// 			));
// 		}

// 		if( isset($_GET['position']) && $_GET['position'] != 0 ) {
// 			$query->set( 'tax_query', array(
// 				'relation' => 'AND',
// 				array(
// 					'taxonomy' => 'od_job_position',
// 					'terms' => $_GET['position'],
// 				),
// 			));
// 		}

// 		if( isset($_GET['seniority']) && $_GET['seniority'] != 0 ) {
// 			$query->set( 'tax_query', array(
// 				'relation' => 'AND',
// 				array(
// 					'taxonomy' => 'od_job_seniority',
// 					'terms' => $_GET['seniority'],
// 				),
// 			));
// 		}

// 		if( (isset($_GET['position']) && $_GET['position'] != 0) &&  (isset($_GET['seniority']) && $_GET['seniority'] != 0)) {
// 			$query->set( 'tax_query', array(
// 				'relation' => 'AND',
// 				array(
// 					'taxonomy' => 'od_job_position',
// 					'terms' => $_GET['position'],
// 				),
// 				array(
// 					'taxonomy' => 'od_job_seniority',
// 					'terms' => $_GET['seniority'],
// 				),
// 			));
// 		}
// 	} // jobs archives

// 	// publications archives
// 	if( $query->is_main_query() && is_post_type_archive('od_publication') ) {

// 		$query->set('posts_per_page', 3);

// 		// sticky featured at top of list, then sort by post date
// 		$query->set('meta_query', array(
// 			'relation' => 'AND',
// 			// 'featured' => array(
// 				// 'key' => 'featured',
// 				// 'compare' => 'EXISTS',
// 			// ),
// 		));
// 		$query->set('orderby', array(
// 			// 'featured' => 'DESC',
// 			'post_date' => 'DESC',
// 		));

// 		if( isset($_GET['keyword']) ) $query->set( 's', $_GET['keyword']);

// 		if( isset($_GET['publication_cat']) && $_GET['publication_cat'] != 0 ) {
// 			$query->set( 'tax_query', array(
// 				'relation' => 'AND',
// 				array(
// 					'taxonomy' => 'od_publication_cat',
// 					'terms' => $_GET['publication_cat'],
// 				),
// 			));
// 		}
// 		if(!isset($_GET['archive']) || $_GET['archive'] != true){
// 			$query->set('date_query', array(
// 				'after' => '2015-01-01',
// 			));
// 		}
// 	} // publications archives

// 	// news archives
// 	if( $query->is_main_query() && is_post_type_archive('od_news') ) {

// 		$query->set('posts_per_page', 5);

// 		// sticky featured at top of list, then sort by post date
// 		$query->set('meta_query', array(
// 			'relation' => 'AND',
// 			// 'featured' => array(
// 				// 'key' => 'featured',
// 				// 'compare' => 'EXISTS',
// 			// ),
// 			'sort_date' => array(
// 				'key' => 'sort_date',
// 				'compare' => 'EXISTS',
// 			)
// 		));
// 		$query->set('orderby', array(
// 			// 'featured' => 'DESC',
// 			'sort_date' => 'DESC',
// 		));

// 		if( isset($_GET['keyword']) ) $query->set( 's', $_GET['keyword']);

// 		if( isset($_GET['y']) && $_GET['y'] != 'all' ) {
// 			$y = $_GET['y'];
// 			$y_start = $y . '0101';
// 			$y_end = $y . '1231';
// 			$meta_query = $query->get('meta_query');

// 			// method #1: two separate meta_queries
// 			// $additions = array(
// 			// 	'key' => 'sort_date',
// 			// 	'value' => $y_start,
// 			// 	'compare' => '>=',
// 			// 	'type' => 'DATE'
// 			// );
// 			// $meta_query['y_start'] = $additions;
// 			// $additions = array(
// 			// 	'key' => 'sort_date',
// 			// 	'value' => $y_end,
// 			// 	'compare' => '<=',
// 			// 	'type' => 'DATE'
// 			// );
// 			// $meta_query['y_end'] = $additions;

// 			// method #2: one ranged meta_query
// 			$additions = array(
// 				'key' => 'sort_date',
// 				'value' => array($y_start, $y_end),
// 				'compare' => 'BETWEEN',
// 				'type' => 'DATE'
// 			);
// 			$meta_query['specific_year'] = $additions;

// 			$query->set('meta_query', $meta_query);
// 		}

// 		if( isset($_GET['date']) && $_GET['date'] != '' ) {
// 			$date = strtotime(urldecode($_GET['date']));
// 			$date_formatted = date('Y', $date) . date('m', $date) . date('d', $date);
// 			$meta_query = $query->get('meta_query');
// 			$additions = array(
// 				'key' => 'sort_date',
// 				'value' => $date_formatted,
// 				'compare' => '='
// 			);
// 			$meta_query['specific_date'] = $additions;

// 			$query->set('meta_query', $meta_query);
// 		}

// 		if( isset($_GET['location']) && $_GET['location'] != 'all' ) {
// 			$meta_query = $query->get('meta_query');
// 			$additions = array(
// 				'key' => 'office_location',
// 				'value' => $_GET['location'],
// 				'compare' => 'LIKE'
// 			);
// 			$meta_query['location'] = $additions;
// 			$query->set('meta_query', $meta_query);
// 		}
// 	} // news archives

// 	// press release archive
// 	if( $query->is_main_query() && is_post_type_archive('od_press_release') ) {

// 		$query->set('posts_per_page', 4);

// 		// sticky featured at top of list, then sort by post date
// 		$query->set('meta_query', array(
// 			'relation' => 'AND',
// 			// 'featured' => array(
// 				// 'key' => 'featured',
// 				// 'compare' => 'EXISTS',
// 			// ),
// 		));
// 		$query->set('orderby', array(
// 			// 'featured' => 'DESC',
// 			'post_date' => 'DESC',
// 		));

// 		if( isset($_GET['keyword']) ) $query->set( 's', $_GET['keyword']);

// 		if( isset($_GET['y']) && $_GET['y'] != 'all' ) {
// 			$query->set('date_query', array(
// 				array(
// 					'year' => $_GET['y'],
// 				),
// 			));
// 		}

// 		if( isset($_GET['date']) && $_GET['date'] != '' ) {
// 			$date = strtotime($_GET['date']);
// 			$y = date('Y', $date);
// 			$m = date('n', $date);
// 			$d = date('j', $date);
// 			$query->set('date_query', array(
// 				array(
// 					'year' => $y,
// 					'month' => $m,
// 					'day' => $d,
// 				),
// 			));
// 		}

// 		if( isset($_GET['location']) && $_GET['location'] != 'all' ) {
// 			$meta_query = $query->get('meta_query');
// 			$additions = array(
// 				'key' => 'office_location',
// 				'value' => $_GET['location'],
// 				'compare' => 'LIKE'
// 			);
// 			$meta_query['location'] = $additions;
// 			$query->set('meta_query', $meta_query);
// 		}

// 	} // press release archive

// 	// international newsletter archives
// 	if( $query->is_main_query() && is_tax('od_intl_art_edition') ) {

// 		$query->set('posts_per_page', -1);

// 		$query->set('meta_query', array(
// 			'country' => array(
// 				'key' => 'country_name',
// 			),
// 		));
// 		$query->set('orderby', array(
// 			'country' => 'ASC',
// 			'title' => 'ASC',
// 		));

// 	} // international newsletter archives

// 	return $query;
// }

// // hijack webinars-seminars main query for dual post type archive
// add_filter( 'request', function( array $query_vars ) {

// 	// do not modify queries in the admin
// 	if( is_admin() ) return $query_vars;

// 	// check also for page slug, because when pretty permalink are active
//   // WordPress use 'pagename' query_vars vars, not 'page_id'
//   $id = isset($query_vars['page_id']) && (int) $query_vars['page_id'] === 14;
//   $name = isset($query_vars['pagename']) && $query_vars['pagename'] === 'webinars-seminars';

//   if ( ( $id || $name)  && ! isset($query_vars['error']) ) {
//     $query_vars = array(
// 			'post_type' => array('od_webinar', 'od_seminar')
// 		);
//   }

// 	return $query_vars;
// });

// // custom function to allow meta query within all repeater rows for title_and_location
// function my_posts_where( $where ) {
// 	$where = str_replace("meta_key = 'title_and_location_$", "meta_key LIKE 'title_and_location_%", $where);
// 	return $where;
// }
// add_filter('posts_where', 'my_posts_where');
