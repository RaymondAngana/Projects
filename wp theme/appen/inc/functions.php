<?php
require_once 'ots-catalog-v2.php';
require_once 'schema.php';
require_once 'ajax-endpoints.php';
require_once 'menu-filter.php';
require_once 'assets.php';

$theme_version = time();
if (strpos($_SERVER['HTTP_HOST'], 'appen.com') !== false) {
	$theme_version = wp_get_theme()->get('Version');
}
define('APPEN_VERSION', $theme_version);

function appen_changes_page_search_to_404() {
	/*
		if ( is_search() ) {
			global $wp_query;
			$wp_query->set_404();
			status_header( 404 );
		}
	*/
	if (is_page('download-now') ||
		is_page('watch-webinar') ||
		is_singular('posts_slider') ||
		is_tax('uk_blog_tags') ||
		is_tax('media_source') ||
		is_tax('life_at_appen_category') ||
		is_post_type_archive('x-portfolio')
	) {
		if (!isset($_GET['redirect_url'])) {
			global $wp_query;
			$wp_query->set_404();
			status_header(404);
		}
	}
}
add_action('wp', 'appen_changes_page_search_to_404');

function appen_author_page_to_404() {
	if (is_author()) {
		global $wp_query;
		$wp_query->set_404();
		status_header(404);
	}
}
add_action('template_redirect', 'appen_author_page_to_404');

add_action('wp_head', 'appen_custom_head');
function appen_custom_head() {
	?>
    <link rel="icon" type="image/png" sizes="16x16" href="/wp-content/themes/pro-child/static/dist/favicon-16x16.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/wp-content/themes/pro-child/static/dist/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/wp-content/themes/pro-child/static/dist/favicons/favicon-96x96.png">
    <!-- Disable tap highlight on IE -->
    <meta name="msapplication-tap-highlight" content="no">
    <meta name="format-detection" content="telephone=no">
    <link rel="shortcut icon" href="/wp-content/themes/pro-child/static/dist/favicons/favicon.ico">
    <!-- Add to homescreen for Chrome on Android -->
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="application-name" content="">
    <link rel="icon" sizes="36x36" href="/wp-content/themes/pro-child/static/dist/favicons/android-icon-36x36.png">
    <link rel="icon" sizes="48x48" href="/wp-content/themes/pro-child/static/dist/favicons/android-icon-48x48.png">
    <link rel="icon" sizes="72x72" href="/wp-content/themes/pro-child/static/dist/favicons/android-icon-72x72.png">
    <link rel="icon" sizes="96x96" href="/wp-content/themes/pro-child/static/dist/favicons/android-icon-96x96.png">
    <link rel="icon" sizes="144x144" href="/wp-content/themes/pro-child/static/dist/favicons/android-icon-144x144.png">
    <link rel="icon" sizes="192x192" href="/wp-content/themes/pro-child/static/dist/favicons/android-icon-192x192.png">
    <!-- Add to homescreen for Safari on iOS -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="">
    <link rel="apple-touch-icon" sizes="57x57" href="/wp-content/themes/pro-child/static/dist/favicons/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/wp-content/themes/pro-child/static/dist/favicons/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/wp-content/themes/pro-child/static/dist/favicons/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/wp-content/themes/pro-child/static/dist/favicons/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/wp-content/themes/pro-child/static/dist/favicons/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/wp-content/themes/pro-child/static/dist/favicons/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/wp-content/themes/pro-child/static/dist/favicons/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/wp-content/themes/pro-child/static/dist/favicons/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/wp-content/themes/pro-child/static/dist/favicons/apple-icon-180x180.png">
    <!-- Tile icon for Win8 (144x144 + tile color) -->
    <meta name="msapplication-TileImage" content="/wp-content/themes/pro-child/static/dist/favicons/ms-icon-70x70.png">
    <meta name="msapplication-TileImage" content="/wp-content/themes/pro-child/static/dist/favicons/ms-icon-144x144.png">
    <meta name="msapplication-TileImage" content="/wp-content/themes/pro-child/static/dist/favicons/ms-icon-150x150.png">
    <meta name="msapplication-TileImage" content="/wp-content/themes/pro-child/static/dist/favicons/ms-icon-310x310.png">
    <meta name="msapplication-TileColor" content="#2F3BA2">
    <link rel="manifest" href="/wp-content/themes/pro-child/static/dist/favicons/manifest.json">
    <meta name="msapplication-config" content="/wp-content/themes/pro-child/static/dist/favicons/browserconfig.xml">
	<?php if(!is_404() && !is_page('404-2') && !is_page('404')) { ?>
	<!-- Hreflang -->
	<link rel="alternate" hreflang="en" href="https://appen.com<?php echo $_SERVER['REQUEST_URI']  ?>"/>
	<?php } ?>
	<?php 
	/*
		$jp_url = 'https://japan.appen.com'. $_SERVER['REQUEST_URI'];
		$is_404_jp_url = @get_headers($jp_url)[0];
		if(strpos($is_404_jp_url, "200")){
			?>
			<link rel="alternate" hreflang="ja" href="<?php echo $jp_url; ?>"/>
			<?php
		}
	*/
}

add_action('acf/init', 'acf_init_callback');
function acf_init_callback() {

	if (function_exists('acf_add_options_page')) {

		acf_add_options_page([
			'page_title' => 'Options',
			'menu_title' => 'Options',
			'menu_slug' => 'posts-options',
			'parent_slug' => 'edit.php',
		]);

		acf_add_options_page([
			'page_title' => 'UK Blog Page',
			'menu_title' => 'UK Blog Page',
			'menu_slug' => 'uk-blog-page',
			'parent_slug' => 'edit.php?post_type=uk_blog',
		]);

		acf_add_options_page([
			'page_title' => 'Life at Appen',
			'menu_title' => 'Life at Appen',
			'menu_slug' => 'life-at-appen',
			'parent_slug' => 'edit.php?post_type=life_at_appen',
		]);

	}

}

add_shortcode('appen_raw_html', 'appen_raw_html');
function appen_raw_html() {
	return get_field('raw_html');
}

add_shortcode('appen_posts_slider_by_cat', 'appen_latest_posts_slider_by_cat');
if (!function_exists('appen_latest_posts_slider_by_cat')) {
	function appen_latest_posts_slider_by_cat($atts) {

		$atts = shortcode_atts(['cat' => false, 'numberposts' => '5', 'findcat' => false], $atts);

		ob_start();

		if ($atts['cat'] && ($primary_category = get_category_by_slug($atts['cat']))) {
			$posts = get_posts([
				'post_type' => 'post',
				'tax_query' => [
					[
						'taxonomy' => 'category',
						'field' => 'slug',
						'terms' => $primary_category->slug,
					],
				],
				'status' => 'publish',
				'posts_per_page' => $atts['numberposts'],
			]);

			if (!empty($posts)) {

				foreach ($posts as $post) {
					if ($atts['findcat'] == 'true' && ($parent = get_category_by_slug('content-types'))) {
						$categories = get_the_category($post->ID);

						foreach ($categories as $category) {
							if ($category->parent == $parent->term_id) {
								$primary_category = $category;
								break;
							}
						}
					}
					?>
						<a href="<?php echo get_permalink($post->ID); ?>" class="swiper-slide latest-news__slide">
							<div class="latest-news__preview">
								<?php echo get_the_post_thumbnail($post->ID, appen_is_amp() ? 'medium_large' : 'recommended'); ?>
							</div>
							<div class="latest-news__category"><?php echo $primary_category->name; ?></div>
							<p class="latest-news__title"><?php echo $post->post_title; ?></p>
							<span class="latest-news__read-more"><?php _e('Read More', 'appen');?></span>
						</a>
					<?php
}
			}
		}

		return ob_get_clean();
	}
}

add_shortcode('appen_company_news_slider', 'appen_company_news_slider');
function appen_company_news_slider($atts) {

	$atts = shortcode_atts(['numberposts' => '5'], $atts);

	ob_start();

	if ($primary_category = get_category_by_slug('press-release')) {
		$posts = get_posts([
			'post_type' => 'post',
			'tax_query' => [
				[
					'taxonomy' => 'category',
					'field' => 'slug',
					'terms' => $primary_category->slug,
				],
			],
			'status' => 'publish',
			'posts_per_page' => $atts['numberposts'],
		]);

		if (!empty($posts)) {

			foreach ($posts as $post) {
				?>
					<a href="<?php echo get_permalink($post->ID); ?>" class="swiper-slide latest-news__slide">
						<div class="latest-news__preview">
							<?php echo get_the_post_thumbnail($post->ID, appen_is_amp() ? 'medium_large' : 'recommended'); ?>
						</div>
						<div class="latest-news__category"><?php echo $primary_category->name; ?></div>
						<p class="latest-news__title"><?php echo $post->post_title; ?></p>
						<span  class="latest-news__read-more"><?php _e('Read More', 'appen');?></span>
					</a>
				<?php
}
		}
	}

	return ob_get_clean();
}

add_shortcode('appen_posts_slider', 'appen_posts_slider');
if (!function_exists('appen_posts_slider')) {
	function appen_posts_slider($atts) {
		$atts = shortcode_atts(['id' => false], $atts);

		ob_start();

		if ($atts['id']) {
			$posts = get_field('posts', $atts['id']);

			foreach ($posts as $post) {
				if ($parent = get_category_by_slug('content-types')) {
					$categories = get_the_category($post->ID);

					foreach ($categories as $category) {
						if ($category->parent == $parent->term_id) {
							$primary_category = $category;
							break;
						}
					}
				} else {
					$post_categories = get_post_primary_category($post->ID, 'category');
					$primary_category = $post_categories['primary_category'];
				}
				?>
					<a href="<?php echo get_permalink($post->ID); ?>" class="swiper-slide latest-news__slide">
						<div class="latest-news__preview">
							<?php echo get_the_post_thumbnail($post->ID, appen_is_amp() ? 'medium_large' : 'recommended'); ?>
						</div>
						<div class="latest-news__category"><?php echo $primary_category->name; ?></div>
						<p class="latest-news__title"><?php echo $post->post_title; ?></p>
						<span  class="latest-news__read-more"><?php _e('Read More', 'appen');?></span>
					</a>
				<?php
}
		}

		return ob_get_clean();
	}
}

add_action('edit_form_after_title', 'appen_show_shortcode_for_posts_slider');
function appen_show_shortcode_for_posts_slider($post) {
	if ($post && isset($post->post_type) && ($post->post_type == 'posts_slider')) {
		echo '<div><h4 style="display: inline-block;">Use shortcode: </h4><code style="user-select: all;">[appen_posts_slider id="' . $post->ID . '"]</code></div>';
	}
}

// Add the custom columns to the book post type:
add_filter('manage_posts_slider_posts_columns', 'set_custom_edit_posts_slider_columns');
function set_custom_edit_posts_slider_columns($columns) {
	$columns['shortcode'] = 'Shortcode';

	return $columns;
}

// Add the custom columns to the book post type:
add_filter('manage_resource_posts_columns', 'set_custom_edit_resource_columns');
function set_custom_edit_resource_columns($columns) {
	$columns['contenttype'] = 'Content Type';

	return $columns;
}
// Add the data to the custom columns for the book post type:
add_action('manage_resource_posts_custom_column', 'custom_resource_column', 10, 2);
function custom_resource_column($column, $post_id) {
	switch ($column) {
	case 'contenttype':
		echo get_field('resource_type', $post_id);
		break;
	}
}

// Add the data to the custom columns for the book post type:
add_action('manage_posts_slider_posts_custom_column', 'custom_posts_slider_column', 10, 2);
function custom_posts_slider_column($column, $post_id) {
	switch ($column) {
	case 'shortcode':
		echo '<code style="user-select: all;">[appen_posts_slider id="' . $post_id . '"]</code>';
		break;
	}
}

add_shortcode('apex_ann', 'apex_ann');
function apex_ann($atts, $content = null) {
	$a = shortcode_atts(
		array(
			'count' => 10,
			'show_pagination' => 'true',
			'type' => 'announcements',
			'cat' => false,
		), $atts);

	ob_start();

	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	$array = array(
		'post_status' => 'publish',
		'paged' => $paged,
		'posts_per_page' => $a['count'],
		'orderby' => 'date',
		'order' => 'DESC',
		'post_type' => $a['type'],
	);

	if ($a['cat']) {
		$array['cat'] = $a['cat'];
	}

	$query = new WP_Query($array);

	if ($query->have_posts()) {
		?>
	    <div class="single_ap_outer">
	    <?php
while ($query->have_posts()) {
			$query->the_post();
			$download_link = get_field('announcement_pdf_download_link');
			$link = get_the_content();
			if ($download_link && isset($download_link['url'])) {
				$link = $download_link['url'];
			}
			?>
			<div class="single_ap">
				<a href="<?php echo $link; ?>" target="_blank" class="ac_link">
					<i class="fa fa-download" aria-hidden="true"></i>
                    <span><?php echo get_the_date(); ?></span>
					<b><?php the_title();?></b>
				</a>
				<a href="<?php echo $link; ?>" target="_blank" class="ac_link download-link"><?php _e('Download', 'appen');?></a>
				<span class="ap_date"><?php echo get_the_date(); ?></span>
			</div>
			<?php
}
		?>
	    </div>
	    <?php
wp_reset_postdata();
		if ($a['show_pagination'] != 'false') {
			?>
		    <div class="pagination">
		        <?php

			/*
				        $previous = get_previous_posts_link('‹');
				        $previous = $previous ? $previous : '‹';
				        $current = max( 1, get_query_var( 'paged' ) );
				        $max = $query->max_num_pages;
				        $next = get_next_posts_link('›', $max);
				        $next = $next ? $next : '›';

				        echo $previous . ' ' . $current . ' / ' . $max . ' ' . $next;

			*/

			echo paginate_links(array(
				'base' => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
				'total' => $query->max_num_pages,
				'current' => max(1, get_query_var('paged')),
				'format' => '?paged=%#%',
				'show_all' => false,
				'type' => 'plain',
				'end_size' => 2,
				'mid_size' => 1,
				'prev_next' => true,
				'prev_text' => sprintf('%1$s', __('‹', 'text-domain')),
				'next_text' => sprintf('%1$s', __('›', 'text-domain')),
				'add_args' => false,
				'add_fragment' => '',
			));
			?>
		    </div>
		    <?php
}
	}

	return ob_get_clean();
}

add_filter('pt_cv_view_type_custom_output', 'cvp_theme_view_type_custom_output', 100, 3);
function cvp_theme_view_type_custom_output($args, $fields_html, $post) {
	global $pt_cv_id;

	if (in_array($pt_cv_id, ['3682039rst'])) {
		ob_start();
		if (!empty($fields_html['custom-fields'])) {
			preg_match('/<a.*?>(.*)<\/a>/', $fields_html['custom-fields'], $podmena);

			if (isset($podmena[1])) {
				$fields_html['custom-fields'] = str_replace($podmena[1], 'Download', $fields_html['custom-fields']);
			}
		}
		$fields_html['custom-fields'] = str_replace('<a href=', '<a target="_blank" href=', $fields_html['custom-fields']);
		echo implode("\n", $fields_html);

		$args = ob_get_clean();
	}

	return $args;
}

function get_thankyou_page_url() {
	return home_url('thank-you-download');
}

function appen_download_shortcode($atts) {
	$html = '';

	if (isset($_GET['download_id'])) {
		$id = $_GET['download_id'];

		if ($file_url = get_field('file_url', $id)) {
			ob_start();
			?>
				<a class="js-thankyou-download" target="_blank" href="<?php echo $file_url; ?>" download><?php _e('Download', 'appen');?></a>
				<script type="text/javascript">
					document.querySelector('.js-thankyou-download').click();
				</script>
			<?php

			$html = ob_get_contents();
			ob_end_clean();
		}
	}

	return $html;
}
add_shortcode('appen_download', 'appen_download_shortcode');

function get_static_file_name($name) {
	if (file_exists(get_stylesheet_directory() . '/static/dist/assets.json')) {
		$assets = json_decode(file_get_contents(get_stylesheet_directory() . '/static/dist/assets.json'));

		if (isset($assets->$name) && !empty($assets->$name)) {
			return $assets->$name;
		}
	}

	return $name;
}

if (!(function_exists('get_post_primary_category'))) {
	function get_post_primary_category($post_id, $term = 'category', $return_all_categories = false) {
		$return = array();

		if (class_exists('WPSEO_Primary_Term')) {
			// Show Primary category by Yoast if it is enabled & set
			$wpseo_primary_term = new WPSEO_Primary_Term($term, $post_id);
			$primary_term = get_term($wpseo_primary_term->get_primary_term());

			if (!is_wp_error($primary_term)) {
				$return['primary_category'] = $primary_term;
			}
		}

		if (empty($return['primary_category']) || $return_all_categories) {
			$categories_list = get_the_terms($post_id, $term);

			if (empty($return['primary_category']) && !empty($categories_list)) {
				$return['primary_category'] = $categories_list[0]; //get the first category
			}
			if ($return_all_categories) {
				$return['all_categories'] = array();

				if (!empty($categories_list)) {
					foreach ($categories_list as &$category) {
						$return['all_categories'][] = $category->term_id;
					}
				}
			}
		}

		return $return;
	}
}

function get_the_resources_by_parent_category($by) {
	$parent_category = false;

	foreach ($by['posts'] as $post_id) {
		if (!$parent_category) {
			$terms = get_the_category($post_id);

			foreach ($terms as $term) {
				if ($parent_category && ($term->parent == 0)) {
					$parent_category = false;
					break;
				}
				if ($term->parent == 0) {
					$parent_category = $term;
				}

			}
		}
	}

	if (!$parent_category) {
		$parents = [];

		foreach ($by['posts'] as $post_id) {
			$terms = get_the_category($post_id);

			foreach ($terms as $term) {
				if ($term->parent == 0) {
					if (!isset($parents[$term->term_id])) {
						$parents[$term->term_id] = 0;
					} else {
						$parents[$term->term_id]++;
					}

				}
			}
		}

		arsort($parents);
		foreach ($parents as $parent_id => $parent_count) {
			$parent_category = get_category($parent_id);
			break;
		}
	}

	return $parent_category;
}

if (!(function_exists('get_the_resources_by_category'))) {
	function get_the_resources_by_category($by) {
		if ($by['posts']):
			ob_start();?>

				<section class="resourses__cards">
					<div class="appen-wrap">
						<?php if ($by['title']): ?>
							<h2><?php echo $by['title']; ?></h2>
						<?php endif;?>
					<div class="swiper-container js-resourse-slider">
						<div class="swiper-wrapper resourses__featured-list">
							<?php
$parent_category = get_the_resources_by_parent_category($by)
		?>

							<?php foreach ($by['posts'] as $post_id): ?>
								<?php
$post_categories = get_post_primary_category($post_id, 'category');
		$primary_category = $post_categories['primary_category'];

		if ($primary_category->parent != $parent_category->term_id) {
			$terms = get_the_category($post_id);

			foreach ($terms as $term) {
				if ($term->parent == $parent_category->term_id) {
					$primary_category = $term;
					break;
				}
			}
		}
		?>
								<a href="<?php echo get_permalink($post_id); ?>" class="swiper-slide resourses__featured-item">
									<div class="resourses__featured-img">
										<?php echo get_the_post_thumbnail($post_id, 'large'); ?>
									</div>
									<h3><?php echo $primary_category->name; ?></h3>
									<p><?php echo get_the_title($post_id); ?></p>
									<a class="resourses__read-more"><?php _e('Read More', 'appen');?></a>
								</a>
							<?php endforeach;?>
						</div>
						<div class="resourses__navigation">
							<div class="resourses__navigation-prev-btn js-resourses-prev"></div>
							<div class="resourses__navigation-next-btn js-resourses-next"></div>
						</div>
					</div>
				</div>
			</section>

			<?php return ob_get_clean();?>
		<?php endif;?>
		<?php
return '';
	}
}

if (!(function_exists('get_life_at_appen_breadcrumbs'))) {
	function get_life_at_appen_breadcrumbs() {
		echo '<ul class="appen-hero__breadcrumbs">';
		echo '<li>';
		if (is_post_type_archive()) {
			_e('Life at Appen', 'appen');
		} else {
			echo '<a href="' . get_post_type_archive_link('life_at_appen') . '">' . __('Life at Appen', 'appen') . '</a>';
		}
		echo '</li>';
		$term = get_queried_object();
		if (is_object($term) && (get_class($term) == 'WP_Term')) {
			echo '<li>' . $term->name . '</li>';
		}
		echo '</ul>';
	}
}

if (!(function_exists('get_life_at_appen_single_breadcrumbs'))) {
	function get_life_at_appen_single_breadcrumbs() {
		echo '<ul class="appen-hero__breadcrumbs">';
		echo '<li>';
		if (is_post_type_archive()) {
			_e('Life at Appen', 'appen');
		} else {
			echo '<a href="' . get_post_type_archive_link('life_at_appen') . '">' . __('Life at Appen', 'appen') . '</a>';
		}
		echo '</li>';
		$categories = get_the_terms(get_the_ID(), 'life_at_appen_category');
		if (!empty($categories)) {
			$category = array_shift($categories);
			echo '<li>' . $category->name . '</li>';
		}
		echo '</ul>';
	}
}

if (!(function_exists('get_uk_blog_breadcrumbs'))) {
	function get_uk_blog_breadcrumbs() {
		echo '<ul class="appen-hero__breadcrumbs">';
		echo '<li>';
		if (is_post_type_archive()) {
			_e('U.K. Blog', 'appen');
		} else {
			echo '<a href="' . get_post_type_archive_link('uk_blog') . '">' . __('U.K. Blog', 'appen') . '</a>';
		}
		echo '</li>';
		$term = get_queried_object();
		if (is_object($term) && (get_class($term) == 'WP_Term')) {
			echo '<li><a href="' . get_term_link($term) . '">' . $term->name . '</a></li>';
		}
		echo '</ul>';
	}
}

if (!(function_exists('get_uk_single_post_breadcrumbs'))) {
	function get_uk_single_post_breadcrumbs() {
		echo '<ul class="appen-hero__breadcrumbs">';
		echo '<li>';
		if (is_post_type_archive()) {
			_e('U.K. Blog', 'appen');
		} else {
			echo '<a href="' . get_post_type_archive_link('uk_blog') . '">' . __('U.K. Blog', 'appen') . '</a>';
		}
		echo '</li>';
		$categories = get_the_terms(get_the_ID(), 'uk_blog_category');
		if (!empty($categories)) {
			$category = array_shift($categories);
			echo '<li><a href="' . get_term_link($category) . '">' . $category->name . '</a></li>';
		}
		echo '</ul>';
	}
}

if (!(function_exists('get_blog_breadcrumbs'))) {
	function get_blog_breadcrumbs() {
		echo '<ul class="appen-hero__breadcrumbs">';
		echo '<li>';
		if (is_page('resources')) {
			_e('Resources', 'appen');
		} else {
			$resources_page = get_page_by_path('resources');
			if ($resources_page) {
				echo '<a href="' . get_permalink($resources_page) . '">' . __('Resources', 'appen') . '</a>';
			} else {
				_e('Resources', 'appen');
			}
		}
		echo '</li>';
		$term = get_queried_object();
		if (is_object($term) && (get_class($term) == 'WP_Term')) {
			// echo '<li>' . $term->name . '</li>';
		}
		echo '</ul>';
	}
}

if (!(function_exists('get_single_post_breadcrumbs'))) {
	function get_single_post_breadcrumbs() {
		echo '<ul class="appen-hero__breadcrumbs">';
		echo '<li>';
		if (is_page('resources')) {
			_e('Resources', 'appen');
		} else {
			$resources_page = get_page_by_path('resources');
			if ($resources_page) {
				echo '<a href="' . get_permalink($resources_page) . '">' . __('Resources', 'appen') . '</a>';
			} else {
				_e('Resources', 'appen');
			}
		}
		echo '</li>';
		$category_name = get_query_var('category_name');
		if ($category_name) {
			$term = get_term_by('slug', $category_name, 'category');
			if ($term) {
				echo '<li><a href="' . get_term_link($term) . '">' . $term->name . '</a></li>';
			}

		}
		echo '</ul>';
	}
}

if (!(function_exists('appen_terms_checklist_args'))) {

	/**
	 * Change category list sort
	 */
	function appen_terms_checklist_args($args, $post_id) {
		$args['checked_ontop'] = false;
		return $args;
	}

	add_filter('wp_terms_checklist_args', 'appen_terms_checklist_args', 2, 10);
}

function appen_video_shortcode($atts) {
	$video = get_field('video');

	if (empty($video) || !$video['url']) {
		return '';
	}

	ob_start();
	?>
	<div class="video-section js-video-row">
        <div class="video-section__frame js-video-frame">
            <div class="video-section__preview js-video-preview">
            	<?php if (!empty($video['preview'])): ?>
            		<img src="<?php echo $video['preview']['url']; ?>" alt="">
            	<?php endif;?>
            </div>
            <iframe data-src="<?php echo $video['url']; ?>" frameborder="0" allow="autoplay" allowfullscreen></iframe>
        </div>
        <div class="video-section__desc">
            <h3><?php echo $video['title']; ?></h3>
            <p><?php echo $video['description']; ?></p>
        </div>
    </div>
	<?php

	$html = ob_get_contents();
	ob_end_clean();

	return $html;
}
add_shortcode('appen_video', 'appen_video_shortcode');

add_filter('post_link', 'content_type_permalink', 10, 3);
// add_filter('post_type_link', 'content_type_permalink', 10, 3);
function content_type_permalink($permalink, $post_id, $leavename) {
	if (strpos($permalink, '%content_type%') === FALSE) {
		return $permalink;
	}

	// Get post
	$post = get_post($post_id);
	if (!$post) {
		return str_replace('%content_type%', '', $permalink);
	}

	// Get taxonomy terms
	$terms = get_the_category($post->ID);
	$categories = get_content_type_categories();
	if (!is_wp_error($terms) && !empty($terms) && !empty($categories)) {
		foreach ($terms as $term) {
			if (in_array($term->slug, $categories)) {
				return str_replace('%content_type%', $term->slug . '/', $permalink);
			}
		}
	}

	return str_replace('%content_type%', 'blog/', $permalink);
}

add_action('init', 'custom_rewrite_rules');
function custom_rewrite_rules() {
	$categories = get_content_type_categories();

	foreach ($categories as $category) {
		add_rewrite_rule(
			$category . '/([^/]+)(?:/([0-9]+))?/?$',
			'index.php?category_name=' . $category . '&name=$matches[1]&page=$matches[2]',
			'top' // The rule position; either 'top' or 'bottom' (default).
		);
	}
}

function get_content_type_categories() {
	$category = get_category_by_slug('content-types');

	if ($category) {
		$categories = get_categories(
			['parent' => $category->term_id]
		);

		if (!empty($categories)) {
			$categories_list = [];

			foreach ($categories as $category) {
				array_push($categories_list, $category->slug);
			}

			return $categories_list;
		}
	}

	return false;
}

function appen_is_amp() {
	if (isset($_GET['amp'])) {
		return true;
	}

	return false;
}

if (function_exists('add_image_size')) {
	add_image_size('recommended', 330, 196, true); // recommended__featured-img
}

function appenGetCurrentUrl() {
	return (is_ssl() ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
}



function search_sort( $query ) {
    if ( $query->is_search() ) {
    	if(isset($_GET['search_sort'])) {
    		switch ($_GET['search_sort']) {
			  case "date_desc":
			    $query->set( 'orderby', 'date' );
			    $query->set( 'order', 'DESC' );
			    break;
			  case "date_asc":
			    $query->set( 'orderby', 'date' );
			    $query->set( 'order', 'ASC' );
			    break;
			  case "title":
			    $query->set( 'orderby', 'name' );
			    $query->set( 'order', 'ASC' );
			    break;
			  default:
			    $query->set( 'orderby', 'date' );
			    $query->set( 'order', 'DESC' );
			}
		} else {
			$query->set( 'orderby', 'date' );
		    $query->set( 'order', 'DESC' );
		}
    }
}
add_action( 'pre_get_posts', 'search_sort' );

add_shortcode( 'search-form', 'search_form' );

function search_form() {
	ob_start();
	?>
	<form method="GET" action="" class="top-search-form">
		<input type="text" name="s" placeholder="Search" value="<?php if(isset($_GET['s'])) { echo $_GET['s']; } ?>">
		<a href="#"><img alt="Image" src="https://s33709.pcdn.co/wp-content/uploads/2020/12/close.svg" width="11" height="11"></a>
		<button type="submit" class="btn btn-success"> <i class="la la-search"></i> </button>
	</form>
	<?php
	return ob_get_clean();
}

// add tag support to pages
function tags_support_page() {
	register_taxonomy_for_object_type('post_tag', 'page');
}

// tag hooks
add_action('init', 'tags_support_page');

/* Shortcode for related page*/

add_shortcode( 'appen-page-related-post', 'appen_page_related_post');


function appen_page_related_post($atts, $content = null) {
	extract(
		shortcode_atts(
			array(
				'mobile_limit' => -1,
				'desktop_limit' => -1,
			),$atts
		)
	);
	ob_start();
	?>
	<style>
        .latest-news__slide {
            z-index: auto;
            background-color: rgb(255, 255, 255);
        }
    </style>
	<?php
	//Get Page Tags
	$getPostTags = array();
	$getTags = get_the_tags(get_the_ID());
	foreach ($getTags as $key => $getTagsValue) {
		$getPostTags[] = $getTagsValue->name;
	}
	$limit = $desktop_limit;
	if(wp_is_mobile()){
		$limit = $mobile_limit;	
	}

    if(isset($_GET['amp'])){
        $limit = 3;
    }

    $args = array(
		'post_type' => 'post',
		'posts_per_page' => $limit,
		'post_status' => 'publish',
		'order_by' => 'date',
		'order' => 'DESC',
		's' => implode(',', $getPostTags),
		'engine' => 'related_post_search',
		'category__not_in' => array( 1343, 365 )
	);

	$theQuery = new SWP_Query( $args );

	if ( $theQuery->have_posts() ) :
	?>
	<?php	while ( $theQuery->have_posts() ) : $theQuery->the_post(); ?>

		<div brightfunnel trigger="scroll"></div>

		<?php if ( $parent = get_category_by_slug( 'content-types' ) ) {
				$categories = get_the_category( get_the_ID() );
				foreach ( $categories as $category ) {
					if ( $category->parent == $parent->term_id ) {
						$primary_category = $category;
						break;
					}
				}
			} else {
				$post_categories  = get_post_primary_category( get_the_ID() );
				$primary_category = $post_categories['primary_category'];
			}
			?>
			<a href="<?php echo get_the_permalink(); ?>" class="swiper-slide latest-news__slide">
				<div class="latest-news__preview">
					<?php
					if ( has_post_thumbnail() ) {
						echo get_the_post_thumbnail( null, appen_is_amp() ? 'medium_large' : 'recommended' );
					} else {
						if ( $placeholder = wp_get_attachment_image( 32329, appen_is_amp() ? 'medium_large' : 'recommended' ) ) {
							echo $placeholder;
						} else {
							echo '<img src="/wp-content/themes/pro-child/static/dist/images/placeholder.jpg" alt="post preview">';
						}
					}
					?>
				</div>
				<div class="latest-news__category"><?php echo isset($primary_category) ? $primary_category->name : ''; ?></div>
				<p class="latest-news__title"><?php the_title() ?></p>
				<span class="latest-news__read-more"><?php _e( 'Read More', 'appen' ); ?></span>
			</a>
		<?php endwhile; ?>
	<?php
	else:
		_e( 'Sorry, nothing found.', 'appen' );
	endif;
	wp_reset_postdata();

	return ob_get_clean();
}

function remove_author() {
	?>
	<style>
		table.wp-list-table.users .view a, label.inline-edit-author, .metabox-prefs label[for="authordiv-hide"], #authordiv.postbox {
			display: none !important;
		}
	</style>
	<?php
}
  
add_action( 'admin_head', 'remove_author' );
