<?php

namespace App;

use Roots\Sage\Container;

/**
 * Get the sage container.
 *
 * @param string $abstract
 * @param array  $parameters
 * @param Container $container
 * @return Container|mixed
 */
function sage($abstract = null, $parameters = [], Container $container = null)
{
    $container = $container ?: Container::getInstance();
    if (!$abstract) {
        return $container;
    }
    return $container->bound($abstract)
        ? $container->makeWith($abstract, $parameters)
        : $container->makeWith("sage.{$abstract}", $parameters);
}

/**
 * Get / set the specified configuration value.
 *
 * If an array is passed as the key, we will assume you want to set an array of values.
 *
 * @param array|string $key
 * @param mixed $default
 * @return mixed|\Roots\Sage\Config
 * @copyright Taylor Otwell
 * @link https://github.com/laravel/framework/blob/c0970285/src/Illuminate/Foundation/helpers.php#L254-L265
 */
function config($key = null, $default = null)
{
    if (is_null($key)) {
        return sage('config');
    }
    if (is_array($key)) {
        return sage('config')->set($key);
    }
    return sage('config')->get($key, $default);
}

/**
 * @param string $file
 * @param array $data
 * @return string
 */
function template($file, $data = [])
{
    if (remove_action('wp_head', 'wp_enqueue_scripts', 1)) {
        wp_enqueue_scripts();
    }

    return sage('blade')->render($file, $data);
}

/**
 * Retrieve path to a compiled blade view
 * @param $file
 * @param array $data
 * @return string
 */
function template_path($file, $data = [])
{
    return sage('blade')->compiledPath($file, $data);
}

/**
 * @param $asset
 * @return string
 */
function asset_path($asset)
{
    return sage('assets')->getUri($asset);
}

/**
 * @param string|string[] $templates Possible template files
 * @return array
 */
function filter_templates($templates)
{
    $paths = apply_filters('sage/filter_templates/paths', [
        'views',
        'resources/views'
    ]);
    $paths_pattern = "#^(" . implode('|', $paths) . ")/#";

    return collect($templates)
        ->map(function ($template) use ($paths_pattern) {
            /** Remove .blade.php/.blade/.php from template names */
            $template = preg_replace('#\.(blade\.?)?(php)?$#', '', ltrim($template));

            /** Remove partial $paths from the beginning of template names */
            if (strpos($template, '/')) {
                $template = preg_replace($paths_pattern, '', $template);
            }

            return $template;
        })
        ->flatMap(function ($template) use ($paths) {
            return collect($paths)
                ->flatMap(function ($path) use ($template) {
                    return [
                        "{$path}/{$template}.blade.php",
                        "{$path}/{$template}.php",
                        "{$template}.blade.php",
                        "{$template}.php",
                    ];
                });
        })
        ->filter()
        ->unique()
        ->all();
}

/**
 * @param string|string[] $templates Relative path to possible template files
 * @return string Location of the template
 */
function locate_template($templates)
{
    return \locate_template(filter_templates($templates));
}

/**
 * Determine whether to show the sidebar
 * @return bool
 */
function display_sidebar()
{
    static $display;
    isset($display) || $display = apply_filters('sage/display_sidebar', false);
    return $display;
}

/**
 * Apply query vars to events listings. 
 */
function apply_events_query_vars($query){
	// $query->set('posts_per_page', 5);

	// sticky featured at top of list, suppress past events, then sort by start date
	$query->set('meta_query', array(
		'relation' => 'AND',
		// 'featured' => array(
		// 	'key' => 'featured',
		// ),
		'sort_date' => array(
			'key' => 'sort_date',
        ),
        'sort_date_end' => array(
            'key' => 'sort_date_end',
        ),
		'hide_past' => array(
            array(
                'key' => 'sort_date_end',
                // 'value' => date("Y-m-d H:i:s", strtotime("now - 27 hours")), // value based on max difference between user's timezone and UTC (26 hours between GMT-12 and GMT+14 plus DST). more precise timezone tracking available in javascript to hide past events, implement it there?
                'value' => date("Y-m-d H:i:s"), // value based on max timezone difference between client's offices (America/Los_Angeles and Europe/Berlin) plus DST
                'compare' => '>=',
                'type' => 'DATETIME',
            ),
		),
	));
	$query->set('orderby', array(
		// 'featured' => 'DESC',
        'sort_date' => 'ASC',
        'sort_date_end' => 'ASC',
	));

	// keyword filter
	if( isset($_GET['keyword']) ) $query->set( 's', htmlspecialchars($_GET['keyword']));

    // start/end date filters
    if( (isset($_GET['start_date']) && $_GET['start_date'] != '') || (isset($_GET['end_date']) && $_GET['end_date'] != '') ) {
        $meta_query = $query->get('meta_query');
        if( (isset($_GET['start_date']) && $_GET['start_date'] != '') && (isset($_GET['end_date']) && $_GET['end_date'] != '') ) {
            $start_date_raw = htmlspecialchars($_GET['start_date']);
            $start_date = date('Ymd', strtotime($start_date_raw));
            $end_date_raw = htmlspecialchars($_GET['end_date']);
            $end_date = date('Ymd', strtotime($end_date_raw));
            $additions = array(
                'relation' => 'AND',
                array(
                    'key' => 'sort_date',
                    'value' => $start_date,
                    'compare' => '>=',
                    'type' => 'DATE'
                ),
                array(
                    'key' => 'sort_date_end',
                    'value' => $end_date,
                    'compare' => '<=',
                    'type' => 'DATE'
                ),
            );
        } elseif((isset($_GET['start_date']) && $_GET['start_date'] != '')) {
            $start_date_raw = htmlspecialchars($_GET['start_date']);
            $start_date = date('Ymd', strtotime($start_date_raw));
            $additions = array(
                'key' => 'sort_date',
                'value' => $start_date,
                'compare' => '>=',
                'type' => 'DATE'
            );
        } elseif((isset($_GET['end_date']) && $_GET['end_date'] != '')) {
            $end_date_raw = htmlspecialchars($_GET['end_date']);
            $end_date = date('Ymd', strtotime($end_date_raw));
            $additions = array(
                'key' => 'sort_date_end',
                'value' => $end_date,
                'compare' => '<=',
                'type' => 'DATE'
            );
        }
        $meta_query['date_range'] = $additions;
        
        $query->set('meta_query', $meta_query);
    }

	if( isset($_GET['location']) && $_GET['location'] != 'all' ) {
		$meta_query = $query->get('meta_query');
		$additions = array(
			'key' => 'office_location',
			'value' => htmlspecialchars($_GET['location']),
			'compare' => 'LIKE'
		);
		$meta_query['location'] = $additions;
		$query->set('meta_query', $meta_query);
	}
	return $query;
}
