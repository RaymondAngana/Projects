<?php

/**
 * Do not edit anything in this file unless you know what you're doing
 */

use Roots\Sage\Config;
use Roots\Sage\Container;

/**
 * Helper function for prettying up errors
 * @param string $message
 * @param string $subtitle
 * @param string $title
 */
$sage_error = function ($message, $subtitle = '', $title = '') {
  $title = $title ?: __('Sage &rsaquo; Error', 'sage');
  $footer = '<a href="https://roots.io/sage/docs/">roots.io/sage/docs/</a>';
  $message = "<h1>{$title}<br><small>{$subtitle}</small></h1><p>{$message}</p><p>{$footer}</p>";
  wp_die($message, $title);
};

/**
 * Ensure compatible version of PHP is used
 */
if (version_compare('7.1', phpversion(), '>=')) {
  $sage_error(__('You must be using PHP 7.1 or greater.', 'sage'), __('Invalid PHP version', 'sage'));
}

/**
 * Ensure compatible version of WordPress is used
 */
if (version_compare('4.7.0', get_bloginfo('version'), '>=')) {
  $sage_error(__('You must be using WordPress 4.7.0 or greater.', 'sage'), __('Invalid WordPress version', 'sage'));
}

/**
 * Ensure dependencies are loaded
 */
if (!class_exists('Roots\\Sage\\Container')) {
  if (!file_exists($composer = __DIR__.'/../vendor/autoload.php')) {
    $sage_error(
      __('You must run <code>composer install</code> from the Sage directory.', 'sage'),
      __('Autoloader not found.', 'sage')
    );
  }
  require_once $composer;
}

/**
 * Sage required files
 *
 * The mapped array determines the code library included in your theme.
 * Add or remove files to the array as needed. Supports child theme overrides.
 */
array_map(function ($file) use ($sage_error) {
  $file = "../app/{$file}.php";
  if (!locate_template($file, true, true)) {
    $sage_error(sprintf(__('Error locating <code>%s</code> for inclusion.', 'sage'), $file), 'File not found');
  }
}, ['helpers', 'setup', 'filters', 'admin', 'post-types', 'taxonomies', 'acf-blocks']);

/**
 * Here's what's happening with these hooks:
 * 1. WordPress initially detects theme in themes/sage/resources
 * 2. Upon activation, we tell WordPress that the theme is actually in themes/sage/resources/views
 * 3. When we call get_template_directory() or get_template_directory_uri(), we point it back to themes/sage/resources
 *
 * We do this so that the Template Hierarchy will look in themes/sage/resources/views for core WordPress themes
 * But functions.php, style.css, and index.php are all still located in themes/sage/resources
 *
 * This is not compatible with the WordPress Customizer theme preview prior to theme activation
 *
 * get_template_directory()   -> /srv/www/example.com/current/web/app/themes/sage/resources
 * get_stylesheet_directory() -> /srv/www/example.com/current/web/app/themes/sage/resources
 * locate_template()
 * ├── STYLESHEETPATH         -> /srv/www/example.com/current/web/app/themes/sage/resources/views
 * └── TEMPLATEPATH           -> /srv/www/example.com/current/web/app/themes/sage/resources
 */
array_map(
  'add_filter',
  ['theme_file_path', 'theme_file_uri', 'parent_theme_file_path', 'parent_theme_file_uri'],
  array_fill(0, 4, 'dirname')
);
Container::getInstance()
->bindIf('config', function () {
  return new Config([
    'assets' => require dirname(__DIR__).'/config/assets.php',
    'theme' => require dirname(__DIR__).'/config/theme.php',
    'view' => require dirname(__DIR__).'/config/view.php',
  ]);
}, true);


if (function_exists('acf_add_options_page') ) {

  acf_add_options_page(array(
    'page_title'    => __('Global Settings'),
    'menu_title'    => __('Global Settings'),
    'menu_slug'     => 'global-settings',
    'capability'    => 'edit_posts',
    'redirect'      => false
  ));

  acf_add_options_sub_page(array(
    'page_title'  => 'Resources Archive Page',
    'menu_title'  => 'Resources Archive Page',
    'menu_slug'   => 'resources-ach-page',
    'capability'  => 'edit_posts',
    'parent_slug' => 'global-settings',
    'redirect'    => false
  ));

  acf_add_options_sub_page(array(
    'page_title'  => 'Restaurant Stories Archive Page',
    'menu_title'  => 'Restaurant Stories Archive Page',
    'menu_slug'   => 'success-stories-ach-page',
    'capability'  => 'edit_posts',
    'parent_slug' => 'global-settings',
    'redirect'    => false
  ));

  acf_add_options_sub_page(array(
    'page_title'  => 'Help Archive Page',
    'menu_title'  => 'Help Archive Page',
    'menu_slug'   => 'help-ach-page',
    'capability'  => 'edit_posts',
    'parent_slug' => 'global-settings',
    'redirect'    => false
  ));

  acf_add_options_sub_page(array(
    'page_title'  => 'Products Archive Page',
    'menu_title'  => 'Products Archive Page',
    'menu_slug'   => 'products-ach-page',
    'capability'  => 'edit_posts',
    'parent_slug' => 'global-settings',
    'redirect'    => false
  ));

}

function new_submenu_class($menu) {
  $menu = preg_replace('/ class="sub-menu"/','/ class="dropdown" /',$menu);
  return $menu;
}
add_filter('wp_nav_menu','new_submenu_class');

/**
 * Asset Include Function
 */
function gh_assets($asset) {
  return "/wp-content/themes/GrubHub/dist/images/{$asset}";
}

/**
 * CTA Form Include
 */
function inc_form($formID) {
  include(dirname(__DIR__)."/resources/views/components/cta-form.php");
}

function inc_gridCards($postID) {
  include(dirname(__DIR__)."/resources/views/components/grid-cards.php");
}

function my_acf_admin_head() { ?>
  <style type="text/css">

    .repeat-horizontal .acf-repeater tr.acf-row .acf-image-uploader .image-wrap img {
      max-height: 80px !important;
      min-height: 80px;
    }

    .repeat-horizontal .acf-repeater tbody {
      display: flex;
      flex-direction: row;
      flex-wrap: wrap;
    }
    .repeat-horizontal .acf-repeater tr.acf-row:not(.acf-clone) {
      width: 100%;
      flex-grow: 1;
      flex-shrink: 0;
      flex-basis: 21%; /* 21% because 25% gives CSS bugs when content pushes width and not 20 because we want the max to be 4 */
      border-bottom: 1px solid #eee;
    }
    .repeat-horizontal .acf-repeater tr.acf-row:not(.acf-clone) td.acf-fields {
      width: 100% !important; /* important is necessary because it gets overwritten on drag&drop  */
    }
    .repeat-horizontal .acf-repeater .acf-row-handle,
    .repeat-horizontal .acf-repeater .acf-fields{
      border-width: 0px 0px 0px 1px;
    }
    .repeat-horizontal .acf-repeater .acf-row-handle.order{
      min-width: 10px; /* to stop breaking layout if we keep the max rows bellow 10 */
    }
    .repeat-horizontal .acf-repeater .acf-row:last-child .acf-row-handle{
      border-width: 0px;
    }
    .repeat-horizontal .acf-repeater .acf-row-handle .acf-icon{
      position: relative;
      margin: 10px 0;
    }
    .repeat-horizontal .acf-repeater .acf-row:hover .acf-row-handle .acf-icon{
      display: none; /* remove standard annoying hover */
    }
    .repeat-horizontal .acf-repeater .acf-row-handle.remove:hover .acf-icon{
      display: block; /* re-apply hover on set block */
    }

    .acf-flexible-content .layout .acf-fc-layout-handle {
      /*background-color: #00B8E4;*/
      background-color: #202428;
      color: #eee;
    }

    .acf-repeater.-row > table > tbody > tr > td,
    .acf-repeater.-block > table > tbody > tr > td {
      border-top: 2px solid #202428;
    }

    .acf-repeater .acf-row-handle {
      vertical-align: top !important;
      padding-top: 16px;
    }

    .acf-repeater .acf-row-handle span {
      font-size: 14px;
      font-weight: bold;
      color: #202428;
    }

    .imageUpload img {
      width: 75px;
    }

    .acf-repeater .acf-row-handle .acf-icon.-minus {
      top: 30px;
    }

    .acf-fields > .acf-field {
      border: none;
      border-bottom: 2px solid #eee;
    }

    .acf-link .link-wrap {
      border: none;
    }

    .acf-field[data-width] + .acf-field[data-width] {
      border-left: none;
    }

    .acf-field .acf-label label {
      font-size: 15px;
    }

    .acf-link .link-wrap .link-title {
      font-size: 14px;
    }

    .acf-repeater .acf-row-handle.order {
      background: #fff;
    }

    .acf-field-message {
      border-bottom: none !important;
      background-color: #ff8000;
    }

    .acf-field-message .acf-label label {
      font-size: 24px;
      text-align: center;
      padding: 20px 0;
      color: #fff;
    }

    .acf-field-message .acf-input img {
      height: 320px;
      width: 100%;
      object-fit: contain;
    }

    .acf-radio-list input[type=radio]:checked::before {
      width: 0.6rem !important;
      height: 0.6rem !important;
    }

    .acf-field-image,
    .acf-field-wysiwyg {
      border-bottom: none !important;
    }

    .hndle.ui-sortable-handle {
      background-color: #f5f5f5;
      font-size: 24px;
    }

    .inside.acf-fields {
      background-color: #f5f5f5;
    }

    .acf-fields > .acf-field {
      border-bottom: none !important;
    }

  </style>
  <?php
}

add_action('acf/input/admin_head', 'my_acf_admin_head');

function short_excerpt( $length ) {
  return 22;
}
add_filter( 'excerpt_length', 'short_excerpt', 999 );

//Register tag cloud filter
add_filter('widget_tag_cloud_args', 'tag_widget_limit');

//Limit number of tags ` widget
function tag_widget_limit($args){

    //Check if taxonomy option inside widget is set to tags
  if(isset($args['taxonomy']) && $args['taxonomy'] == 'post_tag'){
        $args['number'] = 10; //Limit number of tags
      }

      return $args;
    }

// pretty search URL

    function gh_change_search_url() {
      if ( is_search() && ! empty( $_GET['s'] ) ) {
        wp_redirect( home_url( "/search/" ) . urlencode( get_query_var( 's' ) ) );
        exit();
      }
    }
    add_action( 'template_redirect', 'gh_change_search_url' );

    function gh_numeric_pagination() {
      $SVG = [
        'dbLeft' => '<svg width="31" height="24" class="dbl" viewBox="0 0 31 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M22 18L16 12L22 6" stroke="#572AF8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M15 18L9 12L15 6" stroke="#572AF8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
        'dbRight' => '<svg width="30" height="24" class="dbl" viewBox="0 0 30 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M9 18L15 12L9 6" stroke="#572AF8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M15 18L21 12L15 6" stroke="#572AF8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
        'singLeft' => '<svg width="45" height="45" viewBox="0 0 45 45" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="22.5" cy="22.5" r="22.5" transform="rotate(-180 22.5 22.5)" fill="#572AF8"/><path d="M28.6362 22.7729H15.7206" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/><path d="M21.4946 30.0664L15.3407 22.7729L21.4946 15.4794" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>',
        'singRight' => '<svg width="45" height="45" viewBox="0 0 45 45" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="22.5" cy="22.5" r="22.5" fill="#572AF8"/><path d="M16.3638 22.2271L29.2794 22.2271" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/><path d="M23.5054 14.9336L29.6593 22.2271L23.5054 29.5206" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>',
      ];
      global $wp_query;
      $total = $wp_query->max_num_pages;
      if ( $total > 1 )  {
       if ( !$current_page = get_query_var('paged') )
        $current_page = 1;
      $format = empty( get_option('permalink_structure') ) ? '&page=%#%' : 'page/%#%/';
      // Create Beginning Page Link
      echo ($current_page != 1) ? '<a href="'. esc_url( get_pagenum_link(1)) .'" aria-label="go to first page of results" role="button" class="fp">' . $SVG['dbLeft'] . '</a>' : '<span aria-label="you are on the first page" class="start">'. str_replace('#572AF8', '#BEBEBE', $SVG['dbLeft']) .'</span>';
      // Create Previous Page Link
      echo get_previous_posts_link() ? previous_posts_link($SVG['singLeft']) : '<span class="inactive l">' .str_replace('#572AF8', '#BEBEBE', $SVG['singLeft']) . '</span>';
      echo paginate_links(array(
        'base' => get_pagenum_link(1) . '%_%',
        'format' => $format,
        'current' => $current_page,
        'aria_current' => 'page',
        'total' => $total,
        'mid_size' => 1,
        'type' => 'list',
        'prev_text' => $SVG['singLeft'],
        'next_text' => $SVG['singRight'],
        'prev_next' => false
      ));
      // Create Next Page Link
      echo get_next_posts_link() ? next_posts_link($SVG['singRight']) : '<span class="inactive r">' .str_replace('#572AF8', '#BEBEBE', $SVG['singRight']) . '</span>';
      // Create End Page Link
      echo ($current_page >= $total) ? '<span aria-label="you are on the last page" class="end">'. str_replace('#572AF8', '#BEBEBE', $SVG['dbRight']) .'</span>' : '<a href="'. esc_url( get_pagenum_link($total)) .'" aria-label="go to last page of results" role="button" class="lp">' . $SVG['dbRight'] . '</a>';
    }
  }

  add_filter('next_posts_link_attributes', 'posts_next_link_attributes');
  add_filter('previous_posts_link_attributes', 'posts_prev_link_attributes');

  function posts_next_link_attributes() {
    return 'class="styled-button" aria-label="go to next page"';
  }

  function posts_prev_link_attributes() {
    return 'class="styled-button" aria-label="go to previous page"';
  }

 // add_filter( 'alm_query_args_searchwp', 'my_alm_query_args_searchwp');

// Search results count
  function gh_search_posts_per_page( $query) {
    if ( $query->is_search() && $query->is_main_query() && ! is_admin() ) {
      $query->set( 'posts_per_page', '3' );
    }
  }
  add_filter( 'pre_get_posts', 'gh_search_posts_per_page' );

// shove YOAST settings panel in editor to bottom 
  add_filter( 'wpseo_metabox_prio', function() { return 'low'; } );

// Disable Auto formatting to allow for line breaks
// remove_filter ('the_content', 'wpautop');

// Allow excerpts on Pages

  add_action( 'init', 'add_excerpts_to_pages' );
  function add_excerpts_to_pages() {
    add_post_type_support( 'page', 'excerpt' );
  }

  function limit_text($text, $limit) {
    if (str_word_count($text, 0) > $limit) {
      $words = str_word_count($text, 2);
      $pos   = array_keys($words);
      $text  = substr($text, 0, $pos[$limit]).'...';
    }
    return $text;
  }

