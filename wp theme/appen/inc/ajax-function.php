<?php

// templates/category_featured_grid.php
function return_featured_posts_html( $categories, $search = '' ) {
    if ( !empty( $categories ) ) {
        ob_start();

        $builded_featured_section = [
            'post' => [],
            'posts' => []
        ];

        if ( count( $categories ) > 1 ) {
            $first = true;
            $reserved_posts = false;
            $reserved_title = false;

            foreach ($categories as $category) {
                $term             = get_term_by('slug', $category, 'category');
                $type_featured_section = get_field( 'type_featured_section', $term );
                if ( $type_featured_section && ( $type_featured_section == 'none' ) ) continue;
                $featured_section = get_field( 'featured_section', 'category_' . $term->term_id );

                if ( !empty( $featured_section ) ) {
                    if ( !empty( $featured_section['posts'] ) ) {
                        $reserved_posts = $featured_section['posts'];
                        // $reserved_title = $term->name;
                    }

                    if ( ( $type_featured_section == 'grid' ) && isset( $featured_section['post'][0] ) ) {
                        $featured_post = $featured_section['post'][0];
                    } elseif ( isset( $featured_section['posts'][0] ) ) {
                        $featured_post = $featured_section['posts'][0];
                    }

                    if ( isset( $featured_post ) ) {
                        if ( $first ) {
                            $first = false;

                            $builded_featured_section['post'][0] = $featured_post;
                        } else {
                            if ( !in_array($featured_post, $builded_featured_section['post']) && 
                                 !in_array($featured_post, $builded_featured_section['posts']) ) {
                                array_push($builded_featured_section['posts'], $featured_post);
                            }
                        }
                    }
                }
            }

            // if ( empty( $builded_featured_section['posts'] ) && $reserved_posts ) $builded_featured_section['posts'] = $reserved_posts;
            // else $reserved_title = false;
        } else {
            $term             = $categories[0];
            $term             = get_term_by('slug', $term, 'category');
            $reserved_title   = __( 'Discover Featured', 'appen' ) . ' <span>' . $term->name . '</span>';
            $type_featured_section = get_field( 'type_featured_section', $term );
            if ( $type_featured_section && ( $type_featured_section == 'none' ) ) $featured_section = false;
            else $featured_section = get_field( 'featured_section', 'category_' . $term->term_id );

            if ( ( $type_featured_section != 'grid' ) && !isset( $featured_section['post'][0] ) ) {
                if ( !empty( $featured_section['posts'] ) ) $featured_section['post'][0] = array_shift( $featured_section['posts'] );
            }

            if ( !empty( $featured_section['title'] ) ) $reserved_title = $featured_section['title'];

            $builded_featured_section = $featured_section;
        }

        $featured_section = $builded_featured_section;

        ?>
        <?php if ( !empty( $featured_section ) && ( isset( $featured_section['post'][0] ) || !empty( $featured_section['posts'] ) ) ) : ?>
        
        <?php if ( $reserved_title ) : ?>
            <h2><?php echo $reserved_title; ?></h2>
        <?php else : ?>
            <h2><?php _e( 'Discover Featured <span>Resources</span>', 'appen' ); ?></h2>
        <?php endif; ?>

        <div class="swiper-container js-resourse-slider">
            <div class="swiper-wrapper resourses__featured-list">
                <?php
                    $featured_section = $builded_featured_section;

                    if ( isset( $featured_section['post'][0] ) ) :

                    $post_categories  = get_post_primary_category( $featured_section['post'][0], 'category' );
                    $primary_category = $post_categories['primary_category'];
                ?>
                <a href="<?php echo get_permalink( $featured_section['post'][0] ); ?>" class="swiper-slide resourses__featured-item resourses__featured-item--important">
                    <div class="resourses__featured-bg-img">
                        <?php echo get_the_post_thumbnail( $featured_section['post'][0], 'large' ); ?>
                    </div>
                    <div class="resourses__featured-content">
                        <h3><?php echo $primary_category->name; ?></h3>
                        <p><?php echo get_the_title( $featured_section['post'][0] ); ?></p>
                        <span class="resourses__read-more"><?php _e( 'Read More', 'appen' ); ?></span>
                    </div>
                </a>
                <?php endif; ?>
                <?php if ( !empty( $featured_section['posts'] ) ) : ?>
                <?php
                if($search == '') {
                ?>
                <?php foreach ( $featured_section['posts'] as $post_id ) : ?>
                    <?php
                    $post_categories  = get_post_primary_category( $post_id, 'category' );
                    $primary_category = $post_categories['primary_category'];

                    if($primary_category->slug == 'research-papers') {
                        $link = get_field('research_paper_link', $post_id);
                    } else {
                        $link = get_permalink( $post_id );
                    }
                    ?>
                    <a href="<?php echo $link; ?>" class="swiper-slide resourses__featured-item<?php if($primary_category->slug == 'research-papers') { ?> research-paper-wrap<?php } ?>"<?php if($primary_category->slug == 'research-papers') { ?> target="_blank"<?php } ?>>
                        <div class="resourses__featured-img">
                            <?php echo get_the_post_thumbnail( $post_id, 'large' ); ?>
                        </div>
                        <h3><?php echo $primary_category->name; ?></h3>
                        <p><?php echo get_the_title( $post_id ); ?></p>
                        <?php if($primary_category->slug == 'research-papers' && get_post_meta($post_id, 'research_paper_author', true) != '') { ?>
                            <div class="research-paper-author">
                                <p>Authors:<strong>&nbsp;<?php echo get_post_meta($post_id, 'research_paper_author', true); ?></strong></p>
                            </div>
                        <?php } ?>
                        <?php if($primary_category->slug == 'research-papers') { ?>
                        <span class="resourses__read-more research-paper-view"><img src="<?php echo get_stylesheet_directory_uri(); ?>/custom/images/link-icons.png"><?php _e( 'View Paper', 'appen' ); ?></span>
                        <?php } else { ?>
                        <span class="resourses__read-more"><?php _e( 'Read More', 'appen' ); ?></span>
                        <?php } ?>
                    </a>
                <?php endforeach; ?>
                <?php } else { ?>
                <?php
                    $args = array(
                        'post_type' => 'post',
                        'posts_per_page' => -1,
                        'post__in' => $featured_section['posts'],
                        'post_status' => 'publish',
                        's' => $search,
                        'engine' => 'resources_search'
                    );
                    $the_query = new SWP_Query( $args );
                    if ( $the_query->have_posts() ) :
                        while ( $the_query->have_posts() ) : $the_query->the_post();
                            $post_id = get_the_ID();
                            ?>
                            <?php
                            $post_categories  = get_post_primary_category( $post_id, 'category' );
                            $primary_category = $post_categories['primary_category'];

                            if($primary_category->slug == 'research-papers') {
                                $link = get_field('research_paper_link', $post_id);
                            } else {
                                $link = get_permalink( $post_id );
                            }
                            ?>
                            <a href="<?php echo $link; ?>" class="swiper-slide resourses__featured-item<?php if($primary_category->slug == 'research-papers') { ?> research-paper-wrap<?php } ?>"<?php if($primary_category->slug == 'research-papers') { ?> target="_blank"<?php } ?>>
                                <div class="resourses__featured-img">
                                    <?php echo get_the_post_thumbnail( $post_id, 'large' ); ?>
                                </div>
                                <h3><?php echo $primary_category->name; ?></h3>
                                <p><?php echo get_the_title( $post_id ); ?></p>
                                <?php if($primary_category->slug == 'research-papers' && get_post_meta($post_id, 'research_paper_author', true) != '') { ?>
                                    <div class="research-paper-author">
                                        <p>Authors:<strong>&nbsp;<?php echo get_post_meta($post_id, 'research_paper_author', true); ?></strong></p>
                                    </div>
                                <?php } ?>
                                <?php if($primary_category->slug == 'research-papers') { ?>
                                <span class="resourses__read-more research-paper-view"><img src="<?php echo get_stylesheet_directory_uri(); ?>/custom/images/link-icons.png"><?php _e( 'View Paper', 'appen' ); ?></span>
                                <?php } else { ?>
                                <span class="resourses__read-more"><?php _e( 'Read More', 'appen' ); ?></span>
                                <?php } ?>
                            </a>
                        <?php  
                        endwhile;
                    endif; 
                ?>                    
                <?php } ?>
                <?php endif; ?>
            </div>
            <div class="resourses__navigation">
                <div class="resourses__navigation-prev-btn js-resourses-prev"></div>
                <div class="resourses__navigation-next-btn js-resourses-next"></div>
            </div>
        </div>
        <?php else : ?>
            <?php return false; ?>
        <?php endif; ?>
        <?php

        $html = ob_get_contents();
        ob_end_clean();

        return $html;
    }
}

// category.php
function return_all_resources_html( $categories ) {
    if ( !empty( $categories ) ) {
        ob_start();

        $args = [
            'post_type' => 'post',
            'tax_query' => [
                'relation' => 'AND'
            ],
            'status' => 'publish',
            'posts_per_page' => -1
        ];

        foreach ($categories as $group) {
            $group_query = [
                'relation' => 'OR'
            ];

            foreach ($group as $category) {
                array_push($group_query, [
                    'taxonomy' => 'category',
                    'field' => 'slug',
                    'terms' => $category
                ]);
            }

            array_push($args['tax_query'], $group_query);
        }

        $posts = get_posts($args);

        $cards_classes = '';
        $is_webinars = false;

        if ( count( $categories ) == 1 ) {
            $group = array_shift( $categories );

            if ( count( $group ) == 1 ) {
                $category = array_shift( $group );

                if ( $category == 'webinars' ) {
                    $cards_classes = ' resourses__cards--big resourses__cards--not-slider';
                    $is_webinars = true;
                }
            }
        }
        ?>
        <div class="resourses__cards-wrap">
            <section class="resourses__cards<?php echo $cards_classes; ?>">
                <div class="appen-wrap">
                    <?php if ( !empty( $posts ) ) : ?>
                        <h2 class="filtered-title"><?php _e( 'Explore Filtered <span>Resources</span>', 'appen' ); ?></h2>
                        <div class="resourses__featured-list resourses__featured-list--not-slider">
                            <?php
                            foreach ( $posts as $post ) {
                                if ( $is_webinars ) get_the_webinar_cards_html( $post );
                                else get_the_post_cards_html( $post );
                            }
                            ?>
                        </div>
                    <?php else : ?>
                        <?php _e( 'Sorry, nothing found.', 'appen' ); ?>
                    <?php endif; ?>
                </div>
            </section>
        </div>
        <?php

        $html = ob_get_contents();
        ob_end_clean();

        return $html;
    }
}

// templates/resources_posts.php
function get_the_post_cards_html( $post, $attr = false ) {

    if ( $parent = get_category_by_slug('content-types') ) {
        $categories = get_the_category( $post->ID );

        foreach ( $categories as $category ) {
            if ( !isset( $term ) ) $term = $category;
            if ( $category->parent == $parent->term_id ) {
                $primary_category = $category;
                break;
            }
        }
    } else {
        $post_categories = get_post_primary_category( $post->ID, 'category' );
        $primary_category = $post_categories[ 'primary_category' ];
    }

    if($primary_category->slug == 'research-papers') {
        $link = get_field('research_paper_link', $post->ID);
    } else {
        $link = get_permalink( $post->ID );
    }

    $cat_list = '';

    if($attr) {
        $role = $industries = $content_types = array();
        $cats = wp_get_post_terms( $post->ID, 'category' );
        if(!empty($cats)) {
            foreach ( $cats as $cat) {
                if(isset($cat->parent) && $cat->parent != '') {
                    $term = get_term( $cat->parent, 'category' );
                    $slug = $term->slug;
                    if($slug == 'role') {
                        array_push($role, $cat->slug); 
                    }
                    if($slug == 'industries') {
                        array_push($industries, $cat->slug); 
                    }
                    if($slug == 'content-types') {
                        array_push($content_types, $cat->slug); 
                    }
                }
            }
            $cats_ar = array(
                'role' => $role,
                'industries' => $industries,
                'content-types' => $content_types
            );
        }
                                                
        if(!empty($cats_ar)) {
            foreach($cats_ar as $key => $cats) {
                $cat_list .= " data-".$key."='".json_encode($cats)."'";
            }
        }
    }

    ?>
    <a href="<?php echo $link; ?>" class="resourses__featured-item<?php if($primary_category->slug == 'research-papers') { ?> research-paper-wrap<?php } ?>"<?php if($primary_category->slug == 'research-papers') { ?> target="_blank"<?php } ?><?php echo $cat_list; ?>>
        <div class="resourses__featured-img">
            <?php echo get_the_post_thumbnail( $post->ID, 'large' ); ?>
        </div>
        <h3><?php echo isset( $primary_category ) ? $primary_category->name : $term->name; ?></h3>
        <p><?php echo get_the_title( $post->ID ); ?></p>
        <?php if($primary_category->slug == 'research-papers' && get_post_meta($post->ID, 'research_paper_author', true) != '') { ?>
            <div class="research-paper-author">
                <p>Authors:<strong>&nbsp;<?php echo get_post_meta($post->ID, 'research_paper_author', true); ?></strong></p>
            </div>
        <?php } ?>
        <?php if($primary_category->slug == 'research-papers') { ?>
        <span class="resourses__read-more research-paper-view"><img src="<?php echo get_stylesheet_directory_uri(); ?>/custom/images/link-icons.png"><?php _e( 'View Paper', 'appen' ); ?></span>
        <?php } else { ?>
        <span class="resourses__read-more"><?php _e( 'Read More', 'appen' ); ?></span>
        <?php } ?>
    </a>
    <?php
}

// templates/resources_posts_webinars.php
function get_the_webinar_cards_html( $post, $attr = false ) {
    $post_categories  = get_post_primary_category( $post->ID, 'category' );
    $primary_category = $post_categories['primary_category'];
    $type             = get_field( 'type', $post->ID );
    $date             = get_field( 'date', $post->ID );
    $duration         = get_field( 'duration', $post->ID );
    $name             = get_field( 'name', $post->ID );
    $role             = get_field( 'role', $post->ID );
    $company          = get_field( 'company', $post->ID );
    $term             = get_term_by( 'slug', 'webinars', 'category' );

    $cat_list = '';

    if($attr) {
        $role = $industries = $content_types = array();
        $cats = wp_get_post_terms( $post->ID, 'category' );
        if(!empty($cats)) {
            foreach ( $cats as $cat) {
                if(isset($cat->parent) && $cat->parent != '') {
                    $term = get_term( $cat->parent, 'category' );
                    $slug = $term->slug;
                    if($slug == 'role') {
                        array_push($role, $cat->slug); 
                    }
                    if($slug == 'industries') {
                        array_push($industries, $cat->slug); 
                    }
                    if($slug == 'content-types') {
                        array_push($content_types, $cat->slug); 
                    }
                }
            }
            $cats_ar = array(
                'role' => $role,
                'industries' => $industries,
                'content-types' => $content_types
            );
        }
                                                
        if(!empty($cats_ar)) {
            foreach($cats_ar as $key => $cats) {
                $cat_list .= " data-".$key."='".json_encode($cats)."'";
            }
        }
    }

    ?>
    <a href="<?php echo get_permalink( $post->ID ); ?>" class="resourses__featured-item"<?php echo $cat_list; ?>>
        <div class="resourses__featured-img">
            <?php echo get_the_post_thumbnail( $post->ID, 'large' ); ?>
        </div>
        <h3><?php echo $primary_category ? $primary_category->name : $term->name; ?></h3>
        <p><?php echo get_the_title( $post->ID ); ?></p>
        <?php if ( $type || $date || $duration || $name ) : ?>
            <div class="resourses__featured-about">
                <?php if ( $date ) : ?>
                    <div class="resourses__featured-about-row"><strong><?php echo $date; ?></strong></div>
                <?php endif; ?>
                <?php if ( $type ) : ?>
                    <div class="resourses__featured-about-row"><?php _e( 'Type:', 'appen' ); ?> <strong><?php echo $type; ?></strong></div>
                <?php endif; ?>
                <?php if ( $duration ) : ?>
                    <div class="resourses__featured-about-row"><?php _e( 'Duration:', 'appen' ); ?> <strong><?php echo $duration; ?></strong></div>
                <?php endif; ?>
                <?php if ( $name ) : ?>
                    <div class="resourses__featured-about-row"><?php _e( 'Featured Presenter:', 'appen' ); ?>
                        <strong>
                            <?php $featured_presenter = $name; ?>
                            <?php if ( $role || $company ) : ?>
                                <?php $featured_presenter .= ', '; ?>
                                <?php $featured_presenter .= ( $role && $company ) ? $role . ' | ' : $role; ?>
                                <?php if ( $company ) $featured_presenter .= $company; ?>
                            <?php endif ;?>
                            <?php echo $featured_presenter; ?>
                        </strong>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        <span class="resourses__read-more"><?php _e( 'Read More', 'appen' ); ?></span>
    </a>
    <?php
}

// resources page featured posts
function return_initial_featured_posts_html() {
    ob_start();

    $resources_page = get_page_by_path( 'resources' );
    $featured_section = get_field( 'featured_section', $resources_page->ID );

    if ( $featured_section ) : ?>
        <?php if ( $featured_section['title'] ) : ?>
            <h2><?php echo $featured_section['title']; ?></h2>
        <?php endif; ?>
        <div class="swiper-container js-resourse-slider">
            <div class="swiper-wrapper resourses__featured-list">
                <?php if ( $featured_section['post'][0] ) :
                    $post_categories = get_post_primary_category( $featured_section['post'][0], 'category' );
                    $primary_category = $post_categories['primary_category'];
                    ?>
                    <a href="<?php echo get_permalink( $featured_section['post'][0] ); ?>" 
                        class="swiper-slide resourses__featured-item resourses__featured-item--important">
                        <div class="resourses__featured-bg-img">
                            <?php echo get_the_post_thumbnail( $featured_section['post'][0], 'large' ); ?>
                        </div>
                        <div class="resourses__featured-content">
                            <h3><?php echo $primary_category->name; ?></h3>
                            <p><?php echo get_the_title( $featured_section['post'][0] ); ?></p>
                            <span class="resourses__read-more"><?php _e( 'Read More', 'appen' ); ?></span>
                        </div>
                    </a>
                <?php endif; ?>
                <?php if ( $featured_section['posts'] ) : ?>
                    <?php foreach ( $featured_section['posts'] as $post_id ) : ?>
                        <?php
                        $post_categories  = get_post_primary_category( $post_id, 'category' );
                        $primary_category = $post_categories['primary_category'];
                        ?>
                        <a href="<?php echo get_permalink( $post_id ); ?>" class="swiper-slide resourses__featured-item">
                            <div class="resourses__featured-img">
                                <?php echo get_the_post_thumbnail( $post_id, 'large' ); ?>
                            </div>
                            <h3><?php echo $primary_category->name; ?></h3>
                            <p><?php echo get_the_title( $post_id ); ?></p>
                            <span class="resourses__read-more"><?php _e( 'Read More', 'appen' ); ?></span>
                        </a>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <div class="resourses__navigation">
                <div class="resourses__navigation-prev-btn js-resourses-prev"></div>
                <div class="resourses__navigation-next-btn js-resourses-next"></div>
            </div>
        </div>
    <?php endif;

    $html = ob_get_contents();
    ob_end_clean();

    return $html;
}

// resources page all posts
function return_all_initial_resources_html() {
    ob_start();

    $resources_page = get_page_by_path( 'resources' );
    $posts_section = get_field( 'posts_section', $resources_page->ID );

    if ( !empty( $posts_section ) ) {
        foreach ( $posts_section as $section ) {
            if ( $section['type'] == 'shortcode' && $section['shortcode'] ) {
                ?>
                    <section class="resourses__cards">
                        <div class="appen-wrap">
                            <?php if ( $section['title'] ) : ?>
                                <h2><?php echo $section['title']; ?></h2>
                            <?php endif; ?>
                            <div class="swiper-container js-resourse-slider">
                                <div class="swiper-wrapper resourses__featured-list">
                                    <?php echo str_replace( ['latest-news__slide', 'latest-news__preview', 'latest-news__read-more', 'latest-news__title', 'latest-news__category'], ['resourses__featured-item', 'resourses__featured-img', 'resourses__read-more', 'resourses__title', 'resourses__category'], do_shortcode( $section['shortcode'] ) ); ?>
                                </div>
                                <div class="resourses__navigation">
                                    <div class="resourses__navigation-prev-btn js-resourses-prev"></div>
                                    <div class="resourses__navigation-next-btn js-resourses-next"></div>
                                </div>
                            </div>
                        </div>
                    </section>
                <?php
            } elseif ( $section['type'] == 'manually' && !empty( $section['posts'] ) ) {
                $by_manually = [
                    'title' => $section['title'],
                    'posts' => $section['posts']
                ];

                echo get_the_resources_by_category( $by_manually );
            }
        }
    }

    $html = ob_get_contents();
    ob_end_clean();

    return $html;
}

function return_searched_resourced($search, $cats, $sort) {
    ob_start();
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => -1,
        'post_status' => 'publish'
    );
    if($search != '') {
       $args['s'] = $search;
       $args['engine'] = 'resources_search';
    }
    $title_f = "<span>Explore Filtered</span> Resources";
    if(!empty($cats)) {
        if(count($cats) == 1) {
            $catObj = get_category_by_slug($cats[0]); 
            $catName = $catObj->name;
            $title_f = "<span>Explore Filtered</span> ".$catName;
        }
        /*$group_query = array(
            'relation' => 'OR'
        );

        $group = $cats;

        foreach ($group as $category) {
            array_push($group_query, array(
                'taxonomy' => 'category',
                'field' => 'slug',
                'terms' => $category
            ));
        }*/

        $args['tax_query'] = array(
            array(
                'taxonomy' => 'category',
                'field' => 'slug',
                'terms' => $cats
            )
        );
    }
    if($search != '') {
        $the_query = new SWP_Query( $args );
    } else {
        $the_query = new WP_Query( $args );
    }
    if ( $the_query->have_posts() ) :
        while ( $the_query->have_posts() ) : $the_query->the_post();
            $category = get_the_category();
            if ( class_exists('WPSEO_Primary_Term') ) {

                $wpseo_primary_term = new WPSEO_Primary_Term( 'category', get_the_id() );
                $wpseo_primary_term = $wpseo_primary_term->get_primary_term();
                $term = get_term( $wpseo_primary_term );

                if ( is_wp_error( $term ) ) {

                      $category = $category[0]->slug;

                } else {

                      $category_id = $term->term_id;
                      $category_term = get_category($category_id);
                      $category = $term->slug;

                 }

            } else {

                 $category = $category[0]->slug;

            }

            $is_webinars = false;
            if ( $category == 'webinars' ) {
                $cards_classes = ' resourses__cards--big resourses__cards--not-slider';
                $is_webinars = true;
            }
            global $post;
            if ( $is_webinars ) {
                get_the_webinar_cards_html( $post, true );
            } else { 
                get_the_post_cards_html( $post, true );
            }
        endwhile;
    else:
        _e( 'Sorry, nothing found.', 'appen' );
    endif; 
    $html = ob_get_clean();
    /*$featured = return_featured_posts_html( $cats, $search);
    if(!$featured) {
        $featured = '';
    }*/
    if($search != '') {
        $title_f = "<span>Search Results for:</span> ".$search;
    }
    $ret_ar = array(
        'count' => $the_query->found_posts,
        'title' => $title_f,
        'html' => $html,
        'featured' => ''
    );
    wp_reset_postdata();
    return json_encode($ret_ar);
}


function return_load_resourced($paged,$per_page) {
    ob_start();
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => $per_page,
        'paged' => $paged,
        'post_status' => 'publish'
    );
    
    $title_f = "<span>Explore Filtered</span> Resources";
    
    $the_query = new WP_Query( $args );
    if ( $the_query->have_posts() ) :
        while ( $the_query->have_posts() ) : 
            $the_query->the_post();
            $category = get_the_category();
            if ( class_exists('WPSEO_Primary_Term') ) {

                $wpseo_primary_term = new WPSEO_Primary_Term( 'category', get_the_id() );
                $wpseo_primary_term = $wpseo_primary_term->get_primary_term();
                $term = get_term( $wpseo_primary_term );

                if ( is_wp_error( $term ) ) {

                      $category = $category[0]->slug;

                } else {

                      $category_id = $term->term_id;
                      $category_term = get_category($category_id);
                      $category = $term->slug;

                 }

            } else {

                 $category = $category[0]->slug;

            }

            $is_webinars = false;
            if ( $category == 'webinars' ) {
                $cards_classes = ' resourses__cards--big resourses__cards--not-slider';
                $is_webinars = true;
            }
            global $post;
            if ( $is_webinars ) {
                get_the_webinar_cards_html( $post, true );
            } else { 
                get_the_post_cards_html( $post, true );
            }
        endwhile;
    endif; 
    $html = ob_get_clean();
    $ret_ar = array(
        'count' => $the_query->found_posts,
        'title' => $title_f,
        'html' => $html,
    );
    wp_reset_postdata();
    return json_encode($ret_ar);
}

function return_recaptcha_response($grecatpcha_token) {

    if (isset($grecatpcha_token)) {
        $captcha = $grecatpcha_token;
    } else {
        $captcha = false;
    }

    if (!$captcha) {
        return 'Invalid token';
    } else {
        $secret   = RECAPTCHA_SECRET_KEY;
        $response = file_get_contents(
            "https://www.google.com/recaptcha/api/siteverify?secret=" . $secret . "&response=" . $captcha
        );
        // use json_decode to extract json response
        $response = json_decode($response);

        if ($response->success === false) {
            return 'Google server request error';
        }
    }

    if ($response->success==true) {
        return($response->score);
    }
}

/*add_action( 'wp_ajax_appen_site_urls', 'appen_site_urls' );
add_action( 'wp_ajax_nopriv_appen_site_urls', 'appen_site_urls' );

function appen_site_urls() {
    $sitemap_ar = array();

    $args = array(
        'post_type' => 'post',
        'posts_per_page' => -1,
        'post_status' => 'publish'
    );
    $the_query = new WP_Query( $args );

    if ( $the_query->have_posts() ) :
    while ( $the_query->have_posts() ) : $the_query->the_post();
        array_push($sitemap_ar, array(
            'title' => get_the_title(),
            'post_type' => 'Post',
            'url' => get_the_permalink()
        ));
    endwhile;
    endif;
    wp_reset_postdata();

    $args = array(
        'post_type' => 'page',
        'posts_per_page' => -1,
        'post_status' => 'publish'
    );
    $the_query = new WP_Query( $args );

    if ( $the_query->have_posts() ) :
    while ( $the_query->have_posts() ) : $the_query->the_post();
        array_push($sitemap_ar, array(
            'title' => get_the_title(),
            'post_type' => 'Page',
            'url' => get_the_permalink()
        ));
    endwhile;
    endif;
    wp_reset_postdata();

    $args = array(
        'post_type' => 'uk_blog',
        'posts_per_page' => -1,
        'post_status' => 'publish'
    );
    $the_query = new WP_Query( $args );

    if ( $the_query->have_posts() ) :
    while ( $the_query->have_posts() ) : $the_query->the_post();
        array_push($sitemap_ar, array(
            'title' => get_the_title(),
            'post_type' => 'UK Blog',
            'url' => get_the_permalink()
        ));
    endwhile;
    endif;
    wp_reset_postdata();

    $args = array( 
        'taxonomy' => 'category',
    ); 

    $terms = get_terms( $args );

    if(!empty($terms)) {
        foreach ( $terms as $term ) {
            array_push($sitemap_ar, array(
                'title' => $term->name,
                'post_type' => 'Category',
                'url' => get_term_link( $term )
            ));
        }
    }

    $args = array( 
        'taxonomy' => 'uk_blog_category',
    ); 

    $terms = get_terms( $args );

    if(!empty($terms)) {
        foreach ( $terms as $term ) {
            array_push($sitemap_ar, array(
                'title' => $term->name,
                'post_type' => 'UK Blog Category',
                'url' => get_term_link( $term )
            ));
        }
    }

    header('Content-Type: application/csv');
    header('Content-Disposition: attachment; filename=Content-Statistics-'.date('Y-m-d').'.csv');
    header('Pragma: no-cache');

    $output = fopen("php://output", "wb");

    fputcsv($output, array(
        'Title',
        'Content type',
        'URL'
    ));
    if(!empty($sitemap_ar)) {
        foreach($sitemap_ar as $sitemap) {
            fputcsv($output, $sitemap);
        }
    }
    fclose($output);
    wp_die();
}*/