<?php

function appen_enqueue_scripts() {
	include_once ABSPATH . 'wp-admin/includes/plugin.php';
	wp_enqueue_script( 'initSliders', get_stylesheet_directory_uri() . '/static/dist/scripts/' . get_static_file_name( 'initSliders.js' ), [], APPEN_VERSION, true );

	if ( is_page( 'resources' ) || is_archive() || is_single() || is_page( 'download-now' ) || is_page( 'watch-webinar' ) || get_post_meta( get_the_ID(), 'load_dynamic_js', true ) ) {
		$disable = is_single() && ( ( get_query_var( 'category_name' ) == 'case-studies' ) || ( get_query_var( 'category_name' ) == 'datasets' ) );
		if ( ! $disable ) {
			wp_enqueue_script( 'resources', get_stylesheet_directory_uri() . '/static/dist/scripts/' . get_static_file_name( 'app.js' ), [], APPEN_VERSION, true );
			wp_localize_script( 'resources', 'ajaxUrl', admin_url( 'admin-ajax.php' ) );
		}

		if ( !is_page( 'resources' ) || is_category() || get_post_meta( get_the_ID(), 'load_dynamic_js', true ) && ! is_page( 'off-the-shelf-datasets' ) ) {
			//wp_enqueue_script( 'resources-filter', get_stylesheet_directory_uri() . '/static/dist/scripts/' . get_static_file_name( 'resources-filter.js' ), [ 'resources' ], APPEN_VERSION, true );
		}
	}

	if ( is_singular( 'uk_blog' ) ) {
		wp_enqueue_script( 'blog-single', get_stylesheet_directory_uri() . '/static/dist/scripts/' . get_static_file_name( 'blog-single.js' ), [], APPEN_VERSION, true );
	}

	if ( $category_name = get_query_var( 'category_name' ) ) {
		if ( $category_name == 'case-studies' ) {
			wp_enqueue_script( 'case-study', get_stylesheet_directory_uri() . '/static/dist/scripts/' . get_static_file_name( 'case-study.js' ), [], APPEN_VERSION, true );
		}
		if ( $category_name == 'blog' ) {
			wp_enqueue_script( 'blog-single', get_stylesheet_directory_uri() . '/static/dist/scripts/' . get_static_file_name( 'blog-single.js' ), [], APPEN_VERSION, true );
		}
		if ( $category_name == 'datasets' ) {
			wp_enqueue_script( 'blogWithMenu', get_stylesheet_directory_uri() . '/static/dist/scripts/' . get_static_file_name( 'blogWithMenu.js' ), [], APPEN_VERSION, true );
		}
		if ( ( $category_name == 'ebooks' ) || ( $category_name == 'whitepapers' ) || $category_name == 'webinars' ) {
			wp_enqueue_script( 'blogWithForm', get_stylesheet_directory_uri() . '/static/dist/scripts/' . get_static_file_name( 'blogWithForm.js' ), [], APPEN_VERSION, true );
		}
	}

	if ( is_page( 'speech-language-datasets' ) || is_page( 'product-catalog' ) || is_page( 'off-the-shelf-datasets' ) || is_page( 'pre-labeled-datasets' ) ) {
		wp_enqueue_script( 'datatable-js', get_stylesheet_directory_uri() . '/custom/jquery.dataTables.min.js', array( 'jquery' ), APPEN_VERSION, true );
		wp_enqueue_script( 'datatable-res-js', get_stylesheet_directory_uri() . '/custom/dataTables.responsive.min.js', array( 'jquery' ), APPEN_VERSION, true );
	}

	if ( is_page( 'resources' ) || is_category() ) {
		wp_enqueue_script( 'resources-filter-js', get_stylesheet_directory_uri() . '/static/dist/scripts/resources-filter-v2.js', [ 'jquery' ], APPEN_VERSION, true );
		wp_localize_script('resources-filter-js', 'CustomVar', array('ajaxurl' => admin_url('admin-ajax.php')));
		wp_enqueue_style( 'resources-filter-css', get_stylesheet_directory_uri() . '/static/dist/styles/resources-filter-v2.css', [], APPEN_VERSION, 'all' );
		wp_dequeue_script( 'resources-filter' );
	}

	/*wp_enqueue_script( 'aos-js', 'https://unpkg.com/aos@2.3.1/dist/aos.js', array( 'jquery' ) );
	wp_enqueue_style( 'aos-css', 'https://unpkg.com/aos@2.3.1/dist/aos.css' );*/
	//wp_enqueue_script( 'mousewheel-js', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-mousewheel/3.1.13/jquery.mousewheel.min.js', array( 'jquery' ) );
	wp_enqueue_script( 'TweenMax-js', get_stylesheet_directory_uri() . '/assets/scrollmagic/TweenMax.min.js', array( 'jquery' ) );
	wp_enqueue_script( 'ScrollMagic-js', get_stylesheet_directory_uri() . '/assets/scrollmagic/ScrollMagic.min.js', array( 'jquery' ) );
	wp_enqueue_script( 'gsap-js', get_stylesheet_directory_uri() . '/assets/scrollmagic/plugins/animation.gsap.min.js', array( 'jquery' ) );
	//wp_enqueue_script( 'addIndicators-js', get_stylesheet_directory_uri() . '/assets/scrollmagic/plugins/debug.addIndicators.min.js', array( 'jquery' ) );

	// Plugin a3_lazy_load
	wp_deregister_style( 'jquery-lazyloadxt-fadein-css' );
	wp_deregister_style( 'a3a3_lazy_load' );

	wp_deregister_style( 'wp-block-library' );
	wp_deregister_style( 'wp-block-library-theme' );

	wp_deregister_style( 'x-stack' );
	wp_deregister_style( 'x-child' );

	if ( is_plugin_active( 'cookie-notice/cookie-notice.php' ) ) {
		wp_deregister_style( 'cookie-notice-front' );
	}
	wp_deregister_style( 'smw-plugin-style' ); // plugins/premium-stock-market-widgets/css/style.css
	wp_deregister_style( 'font-awesome' ); // plugins/premium-stock-market-widgets/

	wp_deregister_style( 'SFSImainCss' ); // plugins/ultimate-social-media-icons/

	wp_deregister_style( 'tablepress-default' ); // plugins/tablepress/

	wp_deregister_style( 'ubermenu' ); // plugins/ubermenu/
	wp_deregister_style( 'ubermenu-vanilla' ); // plugins/ubermenu/
	wp_deregister_style( 'ubermenu-font-awesome-all' ); // plugins/ubermenu/

//	// dequeue THEME PRO SCRIPTS
//	wp_dequeue_script( 'cornerstone-site-body' );
//	wp_dequeue_script( 'vendor-ilightbox' );
//	wp_dequeue_script( 'x-site' );

}

add_action( 'wp_enqueue_scripts', 'appen_enqueue_scripts', 99 );

add_action( 'wp_print_styles', 'appen_deregister_styles', 99 );
function appen_deregister_styles() {
	wp_dequeue_style( 'wp-block-library' );
}

function appen_footer_enqueue_styles() {
	include_once ABSPATH . 'wp-admin/includes/plugin.php';
	$current_url_raw = ( is_ssl() ? 'https' : 'http' ) . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	$current_url     = explode( '?', $current_url_raw );
	if ( is_array( $current_url ) ) {
		$current_url = array_shift( $current_url );
	}
	$appenBlogUrls    = [ site_url( 'blog/' ), site_url( 'uk/blog/' ) ];

	foreach ( $appenBlogUrls as $url ) {
		if ( strpos( $current_url, $url ) !== false ) {
			wp_enqueue_style( "appen-SFSImainCss", plugins_url( 'css/sfsi-style.css', '/ultimate-social-media-icons/ultimate_social_media_icons.php' ) ); //
			break;
		}
	}

	if ( is_page( 'speech-language-datasets' ) || is_page( 'product-catalog' ) || is_page( 'off-the-shelf-datasets' ) || is_page( 'pre-labeled-datasets' ) ) {
		wp_enqueue_style( 'appen-datatable-stylesheets', get_stylesheet_directory_uri() . '/custom/jquery.dataTables.min.css', [], APPEN_VERSION, 'all' );
		wp_enqueue_style( 'appen-datatable-res-stylesheets', get_stylesheet_directory_uri() . '/custom/responsive.dataTables.min.css', [], APPEN_VERSION, 'all' );
	}

	if ( is_plugin_active( 'cookie-notice/cookie-notice.php' ) && file_exists(  plugins_url( 'css/front' . ( ! ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '.min' : '' ) . '.css', '/cookie-notice/cookie-notice.php' ) ) ) {
		wp_enqueue_style( 'appen-cookie-notice-front', plugins_url( 'css/front' . ( ! ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '.min' : '' ) . '.css', '/cookie-notice/cookie-notice.php' ) );
	}

	wp_enqueue_style( 'appen-smw-plugin-style', plugins_url( 'css/style.css', '/premium-stock-market-widgets/premium-stock-market-widgets.php' ) );
	wp_enqueue_style( 'appen-font-awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css' );

	if ( is_singular( 'post' ) && has_category( 'datasets' ) ) {
		wp_enqueue_style( 'appen-tablepress-default', plugins_url( 'css/default.min.css', '/tablepress/tablepress.php' ) );
	}

}

add_action( 'get_footer', 'appen_footer_enqueue_styles' );

function appen_head_styles() {
	$fontsPath  = get_stylesheet_directory() . '/static/dist/styles/' . get_static_file_name( 'fonts.css' );
	$appPath    = get_stylesheet_directory() . '/static/dist/styles/' . get_static_file_name( 'app.css' );
	$swiperPath = get_stylesheet_directory() . '/static/dist/styles/vendors/swiper.min.css';
	$uploadDir  = wp_get_upload_dir();

	echo '<style>
		/* Ubermenu /plugins/ubermenu/ */
		' . file_get_contents( UBERMENU_DIR . 'assets/css/ubermenu.min.css' ) . '
		' . file_get_contents( UBERMENU_DIR . 'assets/css/skins/vanilla.css' ) . '
		/* Themes Pro Framework (x-stack)  /themes/pro/framework/dist/css/site/stacks/integrity-light.css */
		' . file_get_contents( X_TEMPLATE_PATH . '/framework/dist/css/site/stacks/integrity-light.css' ) . '
		/* Appen fonts /static/dist/styles/' . get_static_file_name( 'fonts.css' ) . ' */
		' . file_get_contents( $fontsPath ) . '
		/* Appen swiper /static/dist/styles/vendors/swiper.min.css */
		' . file_get_contents( $swiperPath ) . '
		/* A3_LAZY_LOAD  /plugins/a3-lazy-load/assets/css/jquery.lazyloadxt.fadein.css */ 
		' . file_get_contents( A3_LAZY_LOAD_DIR . '/assets/css/jquery.lazyloadxt.fadein.css' ) . '
		/* A3_LAZY_LOAD  /uploads/sass/a3_lazy_load.min.css */
		' . file_get_contents( $uploadDir['basedir'] . '/sass/a3_lazy_load.min.css' ) . '
	</style>';

	if ( is_page( 'resources' ) || is_archive() || is_single() || is_page( 'download-now' ) || is_page( 'watch-webinar' ) || get_post_meta( get_the_ID(), 'load_dynamic_js', true ) ) {
		echo '<style>
		/* Appen fonts /static/dist/styles/' . get_static_file_name( 'app.css' ) . ' */
		' . file_get_contents( $appPath ) . '
	</style>';
	}
}

add_action( 'wp_head', 'appen_head_styles', 5 );

function appen_wp_body_open_script() {
	$swiperPath  = get_stylesheet_directory() . '/static/dist/scripts/vendors/swiper.min.js';
	echo "<script>
		if (typeof window.navigator.userAgent === 'undefined' || !window.navigator.userAgent || !window.navigator.userAgent.toLocaleLowerCase().includes('lighthouse')) {
		/* swiper  /static/dist/scripts/vendors/swiper.min.js */
		" . file_get_contents( $swiperPath ) . "
		}
	</script>";

//	$swiperUrl = get_stylesheet_directory_uri() . '/static/dist/scripts/vendors/swiper.min.js';
//
//	echo "
//<script>
//
//    if (typeof window.navigator.userAgent === 'undefined' || !window.navigator.userAgent || !window.navigator.userAgent.toLocaleLowerCase().includes('lighthouse')) {
//      const tag = document.createElement('script');
//      tag.src = '" . $swiperUrl . "';
//      tag.setAttribute('type','text/javascript');
//      tag.setAttribute('async','async');
//      document.body.appendChild(tag)
//    }
//</script>
//	";
}

add_action( 'wp_body_open', 'appen_wp_body_open_script' );

/**
 * Disable the emoji's
 */
function disable_emojis() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
	add_filter( 'wp_resource_hints', 'disable_emojis_remove_dns_prefetch', 10, 2 );
}
add_action( 'init', 'disable_emojis' );

/**
 * Disable Pro Theme Actions
 */
function disableProThemeActions() {
	remove_action( 'x_before_head_css', 'x_google_fonts_queue_cached', 10 );
}
add_action( 'init', 'disableProThemeActions' );

/**
 * Filter function used to remove the tinymce emoji plugin.
 *
 * @param array $plugins
 * @return array Difference betwen the two arrays
 */
function disable_emojis_tinymce( $plugins ) {
	if ( is_array( $plugins ) ) {
		return array_diff( $plugins, array( 'wpemoji' ) );
	} else {
		return array();
	}
}

/**
 * Remove emoji CDN hostname from DNS prefetching hints.
 *
 * @param array $urls URLs to print for resource hints.
 * @param string $relation_type The relation type the URLs are printed for.
 * @return array Difference betwen the two arrays.
 */
function disable_emojis_remove_dns_prefetch( $urls, $relation_type ) {
	if ( 'dns-prefetch' == $relation_type ) {
		/** This filter is documented in wp-includes/formatting.php */
		$emoji_svg_url = apply_filters( 'emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/' );

		$urls = array_diff( $urls, array( $emoji_svg_url ) );
	}

	return $urls;
}
