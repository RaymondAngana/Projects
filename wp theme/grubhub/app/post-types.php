<?php

/**
 * Custom Post Types
 **/

add_action(
    'init', function () {
        // Post Type's Labels & Info Here
        $plural_name     = 'FAQs';
        $singular_name   = 'FAQ';
        $slug            = 'faq';
        $registered_name = 'gh_faq';
        $menu_icon       = 'dashicons-star-empty';

        $labels = [
            'name'                  => $plural_name,
            'singular_name'         => $singular_name,
            'add_new'               => "Add New",
            'add_new_item'          => "Add New {$singular_name}",
            'edit_item'             => "Edit {$singular_name}",
            'new_item'              => "New {$singular_name}",
            'view_item'             => "View {$singular_name}",
            'view_items'            => "View {$plural_name}",
            'search_items'          => "Search {$plural_name}",
            'not_found'             => "No {$plural_name} found.",
            'not_found_in_trash'    => "No '{$plural_name} found in trash.",
            'parent_item_colon'     => "Parent {$plural_name}:",
            'all_items'             => "All {$plural_name}",
            'archives'              => "{$singular_name} Archives",
            'attributes'            => "{$singular_name} Attributes",
            'insert_into_item'      => "Insert Into {$singular_name}",
            'uploaded_to_this_item' => "Uploaded to this {$singular_name}",
            'menu_name'             => $plural_name,
            'name_admin_bar'        => $singular_name,
        ];

        $args = [
            'label'               => $plural_name,
            'labels'              => $labels,
            'description'         => '',
            'public'              => true,
            'exclude_from_search' => false,
            'public_queryable'    => true,
            'show_ui'             => true,
            'show_in_nav_menus'   => true,
            'show_in_menu'        => true,
            'show_in_admin_bar'   => true,
            'menu_position'       => 9999,
            'menu_icon'           => $menu_icon, // Custom icon in WP-admin area
            'hierarchical'        => false,
            'supports'            => [
                'title',
                'editor',
                'author',
                'thumbnail',
            ],
            'has_archive'         => false,
            'rewrite'             => ['slug' => $slug, 'with_front' => false],
            'query_var'           => true,
            'can_export'          => true,
            'show_in_rest'        => false
        ];

        register_post_type($registered_name, $args);

        // Post Type's Labels & Info Here
        $plural_name     = 'Products';
        $singular_name   = 'Product';
        $slug            = 'products';
        $registered_name = 'gh_products';
        $menu_icon       = 'dashicons-carrot';

        $labels = [
            'name'                  => $plural_name,
            'singular_name'         => $singular_name,
            'add_new'               => "Add New",
            'add_new_item'          => "Add New {$singular_name}",
            'edit_item'             => "Edit {$singular_name}",
            'new_item'              => "New {$singular_name}",
            'view_item'             => "View {$singular_name}",
            'view_items'            => "View {$plural_name}",
            'search_items'          => "Search {$plural_name}",
            'not_found'             => "No {$plural_name} found.",
            'not_found_in_trash'    => "No '{$plural_name} found in trash.",
            'parent_item_colon'     => "Parent {$plural_name}:",
            'all_items'             => "All {$plural_name}",
            'archives'              => "{$singular_name} Archives",
            'attributes'            => "{$singular_name} Attributes",
            'insert_into_item'      => "Insert Into {$singular_name}",
            'uploaded_to_this_item' => "Uploaded to this {$singular_name}",
            'menu_name'             => $plural_name,
            'name_admin_bar'        => $singular_name,
        ];

        $args = [
            'label'               => $plural_name,
            'labels'              => $labels,
            'description'         => '',
            'public'              => true,
            'exclude_from_search' => false,
            'public_queryable'    => true,
            'show_ui'             => true,
            'show_in_nav_menus'   => true,
            'show_in_menu'        => true,
            'show_in_admin_bar'   => true,
            'menu_position'       => 9999,
            'menu_icon'           => $menu_icon, // Custom icon in WP-admin area
            'hierarchical'        => false,
            'supports'            => [
                'title',
                'editor',
                'author',
                'thumbnail',
                'excerpt',
            ],
            'has_archive'         => true,
            'rewrite'             => ['slug' => $slug, 'with_front' => false],
            'query_var'           => true,
            'can_export'          => true,
            'show_in_rest'        => true
        ];

        register_post_type($registered_name, $args);

        // Post Type's Labels & Info Here
        $plural_name     = 'Resources';
        $singular_name   = 'Resource';
        $slug            = 'resources';
        $registered_name = 'gh_resources';
        $menu_icon       = 'dashicons-open-folder';

        $labels = [
            'name'                  => $plural_name,
            'singular_name'         => $singular_name,
            'add_new'               => "Add New",
            'add_new_item'          => "Add New {$singular_name}",
            'edit_item'             => "Edit {$singular_name}",
            'new_item'              => "New {$singular_name}",
            'view_item'             => "View {$singular_name}",
            'view_items'            => "View {$plural_name}",
            'search_items'          => "Search {$plural_name}",
            'not_found'             => "No {$plural_name} found.",
            'not_found_in_trash'    => "No '{$plural_name} found in trash.",
            'parent_item_colon'     => "Parent {$plural_name}:",
            'all_items'             => "All {$plural_name}",
            'archives'              => "{$singular_name} Archives",
            'attributes'            => "{$singular_name} Attributes",
            'insert_into_item'      => "Insert Into {$singular_name}",
            'uploaded_to_this_item' => "Uploaded to this {$singular_name}",
            'menu_name'             => $plural_name,
            'name_admin_bar'        => $singular_name,
        ];

        $args = [
            'label'               => $plural_name,
            'labels'              => $labels,
            'description'         => '',
            'public'              => true,
            'exclude_from_search' => false,
            'public_queryable'    => true,
            'show_ui'             => true,
            'show_in_nav_menus'   => true,
            'show_in_menu'        => true,
            'show_in_admin_bar'   => true,
            'menu_position'       => 9999,
            'menu_icon'           => $menu_icon, // Custom icon in WP-admin area
            'hierarchical'        => false,
            'supports'            => [
                'title',
                'editor',
                'author',
                'thumbnail',
                'excerpt',
            ],
            'has_archive'         => true,
            'rewrite'             => ['slug' => $slug, 'with_front' => false],
            'query_var'           => true,
            'can_export'          => true,
            'show_in_rest'        => true
        ];

        register_post_type($registered_name, $args);

        // Post Type's Labels & Info Here
        $plural_name     = 'Restaurant Stories';
        $singular_name   = 'Restaurant Story';
        $slug            = 'restaurant-stories';
        $registered_name = 'gh_success';
        $menu_icon       = 'dashicons-chart-area';

        $labels = [
            'name'                  => $plural_name,
            'singular_name'         => $singular_name,
            'add_new'               => "Add New",
            'add_new_item'          => "Add New {$singular_name}",
            'edit_item'             => "Edit {$singular_name}",
            'new_item'              => "New {$singular_name}",
            'view_item'             => "View {$singular_name}",
            'view_items'            => "View {$plural_name}",
            'search_items'          => "Search {$plural_name}",
            'not_found'             => "No {$plural_name} found.",
            'not_found_in_trash'    => "No '{$plural_name} found in trash.",
            'parent_item_colon'     => "Parent {$plural_name}:",
            'all_items'             => "All {$plural_name}",
            'archives'              => "{$singular_name} Archives",
            'attributes'            => "{$singular_name} Attributes",
            'insert_into_item'      => "Insert Into {$singular_name}",
            'uploaded_to_this_item' => "Uploaded to this {$singular_name}",
            'menu_name'             => $plural_name,
            'name_admin_bar'        => $singular_name,
        ];

        $args = [
            'label'               => $plural_name,
            'labels'              => $labels,
            'description'         => '',
            'public'              => true,
            'exclude_from_search' => false,
            'public_queryable'    => true,
            'show_ui'             => true,
            'show_in_nav_menus'   => true,
            'show_in_menu'        => true,
            'show_in_admin_bar'   => true,
            'menu_position'       => 9999,
            'menu_icon'           => $menu_icon, // Custom icon in WP-admin area
            'hierarchical'        => false,
            'supports'            => [
                'title',
                'editor',
                'author',
                'thumbnail',
                'excerpt',
            ],
            'has_archive'         => true,
            'rewrite'             => ['slug' => $slug, 'with_front' => false],
            'query_var'           => true,
            'can_export'          => true,
            'show_in_rest'        => true
        ];

        register_post_type($registered_name, $args);

        // Post Type's Labels & Info Here
        $plural_name     = 'Help Center';
        $singular_name   = 'Help Center';
        $slug            = 'help-center';
        $registered_name = 'gh_help_center';
        $menu_icon       = 'dashicons-editor-help';

        $labels = [
            'name'                  => $plural_name,
            'singular_name'         => $singular_name,
            'add_new'               => "Add New",
            'add_new_item'          => "Add New {$singular_name}",
            'edit_item'             => "Edit {$singular_name}",
            'new_item'              => "New {$singular_name}",
            'view_item'             => "View {$singular_name}",
            'view_items'            => "View {$plural_name}",
            'search_items'          => "Search {$plural_name}",
            'not_found'             => "No {$plural_name} found.",
            'not_found_in_trash'    => "No '{$plural_name} found in trash.",
            'parent_item_colon'     => "Parent {$plural_name}:",
            'all_items'             => "All {$plural_name}",
            'archives'              => "{$singular_name} Archives",
            'attributes'            => "{$singular_name} Attributes",
            'insert_into_item'      => "Insert Into {$singular_name}",
            'uploaded_to_this_item' => "Uploaded to this {$singular_name}",
            'menu_name'             => $plural_name,
            'name_admin_bar'        => $singular_name,
        ];

        $args = [
            'label'               => $plural_name,
            'labels'              => $labels,
            'description'         => '',
            'public'              => true,
            'exclude_from_search' => false,
            'public_queryable'    => true,
            'show_ui'             => true,
            'show_in_nav_menus'   => true,
            'show_in_menu'        => true,
            'show_in_admin_bar'   => true,
            'menu_position'       => 9999,
            'menu_icon'           => $menu_icon, // Custom icon in WP-admin area
            'hierarchical'        => false,
            'supports'            => [
                'title',
                'editor',
                'author',
                'thumbnail',
                'excerpt',
            ],
            'has_archive'         => true,
            'rewrite'             => ['slug' => $slug, 'with_front' => false],
            'query_var'           => true,
            'can_export'          => true,
            'show_in_rest'        => true
        ];

        register_post_type($registered_name, $args);

    }
);
