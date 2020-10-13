<?php
    /*
     Plugin Name: Widen Collective
     Plugin URI: http://widen.com
     Description: Add Assets from your Widen Collective system into WordPress posts, pages, and the Media Library.  To get started, configure the connection to your Collective site in 'Settings|Widen Collective', then search for Assets in 'Media|Widen Collective'.
     Version: 1.0.0
     Author: Widen Enterprises
     Author URI: http://widen.com
     */
require_once('widen_ajax.php');
require_once('widen_restapi.php');
include_once( ABSPATH . WPINC. '/class-http.php' );

function widen_admin()
{
    include('widen_admin.php');
}

function widen_media()
{
    include('widen_media.php');
    if( !empty($_POST['url'])) {
        $url = strtok($_POST['url'], '?');
        $http = new WP_Http();
        $response = $http->request( $url );
        if( $response['response']['code'] != 200 ) {
            return 'An error occurred: ' . $response['response']['code'];
            // return false;
        }

        $upload = wp_upload_bits( basename($url), null, $response['body'] );
        if (is_wp_error($upload)) {
          return false;
        }

        $file_path = $upload['file'];
        $file_name = basename( $file_path );
        $file_type = wp_check_filetype( $file_name, null );
        $attachment_title = sanitize_file_name( pathinfo( $file_name, PATHINFO_FILENAME ) );
        $wp_upload_dir = wp_upload_dir();

        $post_info = array(
            'guid'        => $wp_upload_dir['url'] . '/' . $file_name,
            'post_mime_type'  => $file_type['type'],
            'post_title'    => $attachment_title,
            'post_content'    => '',
            'post_status'   => 'inherit',
        );

        // Create the attachment
        $attach_id = wp_insert_attachment( $post_info, $file_path, NULL );

        // Include image.php
        require_once( ABSPATH . 'wp-admin/includes/image.php' );

        // Define attachment metadata
        $attach_data = wp_generate_attachment_metadata( $attach_id, $file_path );

        // Assign metadata to attachment
        wp_update_attachment_metadata( $attach_id,  $attach_data );

        return $attach_id;
        wp_die();
    }
}

function widen_admin_actions()
{
    add_options_page("Widen Collective Settings", "Widen Collective Settings", "read", "DAMSettings", "widen_admin");
    add_media_page("Widen Collective", "Widen Collective", "read", "DAMLibrary", "widen_media");
}

function widen_upload_media_menu($tabs)
{
    wp_enqueue_script('media-upload');
    $tabs['widen_upload']='Insert from Widen Collective';
    return $tabs;
}

function widen_upload_menu_handle()
{
    return wp_iframe('widen_media');
}

function widen_tinymce_button() {
    $token = get_option('widen_access_token');
    // $token = 'YES';

    // Check if the logged in WordPress User can edit Posts or Pages
    // If not, don't register our TinyMCE plugin
    if ( ! current_user_can( 'edit_posts' ) && ! current_user_can( 'edit_pages' ) ) {
        return;
    }

    // Check if the logged in WordPress User has the Visual Editor enabled
    // If not, don't register our TinyMCE plugin
    if ( get_user_option( 'rich_editing' ) !== 'true' ) {
        return;
    }

    if (isset($token) && (strlen($token) != 0)) {
        // Setup some filters
        add_filter( 'mce_external_plugins', 'widen_add_tinymce_plugin' );
        add_filter( 'mce_buttons_2', 'widen_add_tinymce_toolbar_button' );
        include('widen_tinymce.php');
    }
}

function widen_add_settings_link( $links ) {
    $settings_link = '<a href="options-general.php?page=DAMSettings">' . __( 'Settings Configuration' ) . '</a>';
    array_push( $links, $settings_link );
    return $links;
}

$plugin = plugin_basename( __FILE__ );
add_filter( "plugin_action_links_$plugin", 'widen_add_settings_link' );

add_action('admin_menu', 'widen_admin_actions');

add_filter('media_upload_tabs', 'widen_upload_media_menu');

add_action('media_upload_widen_upload', 'widen_upload_menu_handle');

add_action( 'init', 'widen_tinymce_button');
add_action( 'init', 'widen_media_enqueue');
function widen_media_enqueue($hook) {
    if (isset($_GET['page'])) {
      if ($_GET['page'] != 'DAMLibrary') {
        // Only applies to dashboard panel
        return;
        }
    }

    wp_enqueue_script( 'ajax-script', plugins_url( '/js/upload-media.js', __FILE__ ), array('jquery') );

    // in JavaScript, object properties are accessed as ajax_object.ajax_url, ajax_object.we_value
    wp_localize_script( 'ajax-script', 'ajax_object',
            array( 'ajax_url' => admin_url( 'admin-ajax.php' )) );
}

add_action( 'wp_ajax_widen_media', 'widen_media' );

add_action('admin_enqueue_scripts', function() {
    $domain = get_option('widen_domain');
    $token = get_option('widen_access_token');
    if (isset($domain) && (strlen($domain) != 0)) {
        wp_enqueue_script( 'widen-media-tab', plugin_dir_url( __FILE__ ) . '/js/widen_media_tab.js', array( 'jquery' ), '', true );
    }
});
?>
