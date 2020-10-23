<?php

namespace App;

use Sober\Controller\Controller;

class App extends Controller
{
    public function siteName()
    {
        return get_bloginfo('name');
    }

    public static function title()
    {
        if (is_home()) {
            if ($home = get_option('page_for_posts', true)) {
                return get_the_title($home);
            }
            return __('Latest Posts', 'sage');
        }
        if (is_archive()) {
            // return get_the_archive_title();
            return __(post_type_archive_title( '', false ), 'ogletree');
        }
        if (is_search()) {
            return sprintf(__('Search Results for %s', 'sage'), get_search_query());
        }
        if (is_404()) {
            return __('Not Found', 'sage');
        }
        return get_the_title();
    }

    public static function author_format($people)
    {   
        $count = 1;
        $output = "<span class='sep leading'>" . __('by', 'ogletree') . "&nbsp</span>";
        
        foreach( $people as $person ) {
            if(get_post_status($person) == 'publish') {
                $output .= "<span class='author'><a href='" . get_permalink( $person->ID ) . "'><span class='name'>" . get_the_title( $person->ID ) . "</span></a>";
                if((count($people) > 2 && $count != count($people)))
                $output .= '<span class="sep">, </span>'; 
                if(count($people) == 2 && $count != 2) 
                $output .= '<span class="sep"> and </span>'; 
                if(count($people) != 2 && $count == count($people)-1) 
                $output .= '<span class="sep"> and </span></span>'; 
                $count++; 
            }
        }

        return $output;
    }
}
