<?php

/**
 * Feature Components Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Load values and assign defaults.
$component = isset($is_flex) ? get_sub_field('feature_component_type') : get_field('feature_component_type');
$dir = get_stylesheet_directory() . '/views/components/';

include($dir . $component . '.php');
