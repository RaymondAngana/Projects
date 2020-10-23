<?php
namespace App;

// Returns array of post titles from relationship field array
function relationship_field_titles_array($author_post_array){
    return array_map(function($author){
        return $author->post_title;
    }, $author_post_array);
}
// Returns CSV string of post titles from relationship field array
function relationship_field_titles_csv($author_post_array){
    $author_titles_array = relationship_field_titles_array($author_post_array);

    if(sizeOf($author_titles_array) < 3){
        return join(
            $author_titles_array,
            ' and '
        );
    }
    $array_head = array_slice($author_titles_array, 0, -1);
    $head = join(
        $array_head,
        ', '
    );
    return $head . ', and ' . end($author_titles_array);
}
function author_links_csv($author_post_array){
    $author_links_array = array_map(function($author){
        return '<a style ="color: #092f41" href="' . $author->guid . '">' . $author->post_title . '</a>';
    }, $author_post_array);
    if(sizeOf($author_links_array) < 3){
        return join(
            $author_links_array,
            ' and '
        );
    }
    $array_head = array_slice($author_links_array, 0, -1);
    $head = join(
        $array_head,
        ', '
    );
    return $head . ', and ' . end($author_links_array);
}
function od_custom_rss() {
    switch(get_post_type()){
        case('od_insight'):
            $relationship_fieldname = 'authors';
            break;
        case('od_podcast'):
            $relationship_fieldname = 'speakers';
            break;
        case('od_publication'):
        case('od_press_release'):
        case('od_news'):
            $relationship_fieldname = 'office_location';
            break;
        case('od_job'):
            $relationship_fieldname = 'location';
            break;
        default:
            $relationship_fieldname = null;
            break;
    }
    echo template(
        'feed-rss2', 
        [
            'authors' => function() use ($relationship_fieldname){
                $author_post_array = get_field($relationship_fieldname) ?: [];
                return !empty($author_post_array)
                    ? relationship_field_titles_csv(
                        $author_post_array
                    )
                    : []; 
            },
        ]
    );
    die();
}
remove_all_actions( 'do_feed_rss2' );
add_action( 'do_feed_rss2', __NAMESPACE__ . '\\od_custom_rss', 10, 1 );

function od_custom_feed(){
    $datetimefrom = isset($_GET['datetimefrom']) ? htmlspecialchars($_GET['datetimefrom']) . 'T000000' : '20190131T000000';
    $datetimeto = isset($_GET['datetimeto']) ? htmlspecialchars($_GET['datetimeto']) . 'T000000' : null;
    echo template(
        'feed-custom', 
        [
            'authors' => function(){
                $type = get_post_type();
                if($type === 'od_podcast'){
                    $relationship_fieldname = 'speakers';
                } else {
                    $relationship_fieldname = 'authors';
                }
                $author_post_array = get_field($relationship_fieldname) ?: [];
                return !empty($author_post_array)
                    ? author_links_csv(
                        $author_post_array
                    )
                    : []; 
            },
            'datetimefrom' => $datetimefrom,
            'datetimeto' => $datetimeto
        ]
    );
    die();
}
add_action( 'pre_get_posts', function($query){
    if( !$query->is_main_query() || !is_feed('custom')){
		return;
    }
    $date_query = [[]];
    $date = isset($_GET['datetimefrom'])
        ? \DateTime::createFromFormat('Ymd\THis', $_GET['datetimefrom'] . 'T000000')->getTimestamp()
        : \DateTime::createFromFormat('Ymd\THis', '20190131T000000')->getTimestamp(); 
    $date_query = [
        [
            'after' => date('Y-m-d H:i:s', $date)
        ]
    ];
    if(isset($_GET['datetimeto'])){
        $date = \DateTime::createFromFormat('Ymd\THis', htmlspecialchars($_GET['datetimeto']) . 'T000000')->getTimestamp(); 
        $date_query[0]['before'] = date('Y-m-d H:i:s', $date); 
    }
    $date_query[0]['inclusive'] = true;
    $query->set('date_query', $date_query);
    $query->set('post_type', array('od_insight', 'od_podcast'));
    return $query;
}, 10, 1);


// Add events and custom feed.
function od_rss_init(){
    add_feed('events', __NAMESPACE__ . '\\od_events_rss');
    add_feed('all', __NAMESPACE__ . '\\od_all_rss');
    add_feed('custom', __NAMESPACE__ . '\\od_custom_feed');
}
add_action('init', __NAMESPACE__ . '\\od_rss_init');

add_action('init', function(){
    add_rewrite_rule(
        'insights/feed/(custom)/?',
        'index.php?post_type=od_insight&feed=$matches[1]',
        'top'
    );
});

// Set the correct HTTP header for Content-type. 
function od_rss_content_type( $content_type, $type ) {
	if ( 'events' === $type || 'all' === $type ) {
		return feed_content_type( 'rss2' );
	}
	return $content_type;
}
add_filter( 'feed_content_type', __NAMESPACE__ . '\\od_rss_content_type', 10, 2 );

function od_events_rss() {
    echo template(
        'feed-rss2', 
        [
            'authors' => function(){ 
                return get_field('speakers')
                    ? relationship_field_titles_csv(
                        get_field('speakers')
                    )
                    : [];
            },
            'title' => 'Ogletree Deakins',
        ]
    );
    die();
}
function od_all_rss() {
    echo template(
        'feed-all', 
        [
            'authors' => function(){
                $type = get_post_type();
                if($type === 'od_podcast'){
                    $field = 'speakers';
                } else {
                    $field = 'authors';
                }
                return get_field($field)
                    ? relationship_field_titles_csv(
                        get_field($field)
                    )
                    : [];
            },
            'title' => 'Ogletree Deakins',
        ]
    );
    die();
}
function od_set_events_feed_query($query) {
    if($query->query_vars['feed'] === 'events'){
        $query->set('post_type', array('od_webinar', 'od_seminar'));
    }
    return $query;
}
add_action( 'pre_get_posts', __NAMESPACE__ . '\\od_set_events_feed_query', 10, 1 );

function od_set_all_feed_query($query) {
    if($query->query_vars['feed'] === 'all'){
        $query->set('post_type', array('od_insight', 'od_podcast'));
    }
    return $query;
}
add_action( 'pre_get_posts', __NAMESPACE__ . '\\od_set_all_feed_query', 10, 1 );

add_filter( 'option_posts_per_rss', __NAMESPACE__ . '\\posts_per_rss' );
function posts_per_rss( $option ) {
    if( isset( $_GET['limit'] ) ) {
        return (int) $_GET['limit'] ? htmlspecialchars($_GET['limit']) : $option;
    }
    return $option;
}