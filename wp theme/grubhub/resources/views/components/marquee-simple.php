<?php

/**
 * Simple Marquee Form Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

require_once('helper-functions.php');
// Create id attribute allowing for custom "anchor" value.
$id = 'ms-' . $block['id'];
if( !empty($block['anchor']) ) {
  $id = $block['anchor'];
}

$field_or_subfield = isset($is_flex) ? 'get_sub_field' : 'get_field';

// Load values and assign defaults.
$ms_headline = call_user_func($field_or_subfield, 'ms_headline');
$ms_button = call_user_func($field_or_subfield, 'ms_button') ? : 'Button';
$ms_button_style = call_user_func($field_or_subfield, 'ms_button_style') ? : 'Primary';
$ms_align_style = call_user_func($field_or_subfield, 'ms_align_style') ? : 'Center';
?>
<style>
    .text-center {
      text-align: center;  
    }
    .text-left {
        width: 100%;
        text-align: left;
    }
</style>

<section id="simpleMarq" class="simple-marq">
    <div class="row align-justify align-middle <?php get_field('ms_align_style'); ?>">
      <div class="columns small-12 medium-12 ">
        <?php print print_header($ms_headline, 'h1'); ?>
        <?php if (get_field('ms_button')): ?>
            <?php $link = get_field('ms_button'); ?>
            <a class="button <?php the_field('ms_button_style'); ?>" href="<?php echo $link['url']; ?>" 
                target="<?php echo $link['target']; ?>" 
                aria-label="<?php echo $link['title']; ?>">
                <?php echo $link['title']; ?>
            </a>
        <?php endif ?>
      </div>
    </div>
</section>