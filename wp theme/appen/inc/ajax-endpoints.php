<?php

require_once('ajax-function.php');

add_action( 'wp_ajax_get_featured_posts', 'ajax_get_featured_posts' );
add_action( 'wp_ajax_nopriv_get_featured_posts', 'ajax_get_featured_posts' );
function ajax_get_featured_posts() {
    $categories = isset( $_POST['categories'] ) ? data_categories_to_slug_only( $_POST['categories'] ) : false;
    $search = isset( $_POST['resources_search'] ) ? data_categories_to_slug_only( $_POST['resources_search'] ) : false;
    $html = return_featured_posts_html( $categories, $search );

    wp_send_json( $html );
    wp_die();
}

add_action( 'wp_ajax_get_all_resources', 'ajax_get_all_resources' );
add_action( 'wp_ajax_nopriv_get_all_resources', 'ajax_get_all_resources' );
function ajax_get_all_resources() {
    $categories = isset( $_POST['categories'] ) ? data_categories_to_group_slug_only( $_POST['categories'] ) : false;
    $html = return_all_resources_html( $categories );

    wp_send_json( $html );
    wp_die();
}

function data_categories_to_slug_only( $categories ) {
	$data = [];

	foreach ( $categories as $group ) {
        foreach ( $group as $category ) {
            array_push( $data, $category['slug'] );
        }
	}

	return $data;
}

function data_categories_to_group_slug_only( $categories ) {
    $data = [];
    $group_id = 0;

    foreach ( $categories as $group ) {
        $data[$group_id] = [];

        foreach ( $group as $category ) {
            array_push( $data[$group_id], $category['slug'] );
        }

        $group_id++;
    }

    return $data;
}

add_action( 'wp_ajax_get_initial_featured_posts', 'ajax_get_initial_featured_posts' );
add_action( 'wp_ajax_nopriv_get_initial_featured_posts', 'ajax_get_initial_featured_posts' );
function ajax_get_initial_featured_posts() {
    $html = return_initial_featured_posts_html();

    wp_send_json( $html );
    wp_die();
}

add_action( 'wp_ajax_get_all_initial_resources', 'ajax_get_all_initial_resources' );
add_action( 'wp_ajax_nopriv_get_all_initial_resources', 'ajax_get_all_initial_resources' );
function ajax_get_all_initial_resources() {
    $html = return_all_initial_resources_html();

    wp_send_json( $html );
    wp_die();
}

add_action( 'wp_ajax_get_searched_resources', 'get_searched_resources' );
add_action( 'wp_ajax_nopriv_get_searched_resources', 'get_searched_resources' );
function get_searched_resources() {

    echo return_searched_resourced($_POST['resources_search'], $_POST['resources_cats'], $_POST['resources_sort']);

    wp_die();
}



add_action( 'wp_ajax_get_load_resources', 'get_load_resources' );
add_action( 'wp_ajax_nopriv_get_load_resources', 'get_load_resources' );
function get_load_resources() {
    echo return_load_resourced($_POST['paged'], $_POST['per_page']);
    wp_die();
}

add_action( 'wp_ajax_get_recaptcha_response', 'get_recaptcha_response' );
add_action( 'wp_ajax_nopriv_get_recaptcha_response', 'get_recaptcha_response' );
function get_recaptcha_response() {
    echo return_recaptcha_response($_POST['g-recaptcha-response']);
    wp_die();
}
