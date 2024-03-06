<?php

/**
 * Dual CTA Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

require_once('helper-functions.php');
$field_or_subfield = isset($is_flex) ? 'get_sub_field' : 'get_field';

// Load values and assign defaults.
$headline = call_user_func($field_or_subfield, 'dual_headline');
$subheadline = call_user_func($field_or_subfield, 'dual_sub_headline');
$cta_title = call_user_func($field_or_subfield, 'cta_title');
$cta_text = call_user_func($field_or_subfield, 'cta_text');
$dual_button_style = call_user_func($field_or_subfield, 'dual_button_style');
$align = call_user_func($field_or_subfield, 'headline_alignment');
$padding = call_user_func($field_or_subfield, 'custom_padding');
?>

<section id="dualCTA" class="dual-cta gh-cards" style="<?php echo $padding['padding_top'] != '' ? "padding-top: " . $padding['padding_top'] . 'px; ' : ''; echo $padding['padding_bottom'] != '' ? "padding-bottom: " . $padding['padding_bottom']. "px" : ''; ?>">
    <div class="row align-center align-middle">
        <div class="columns">
          <?php if (!empty($headline)): ?>
            <h2 <?php echo $align ? 'class="'. $align .'"' : ''; ?>><?php echo $headline; ?></h2>
        <?php endif; ?>
        <?php if (!empty($subheadline)): ?>
            <p class="head2-sub" <?php echo $align ? 'class="'. $align .'"' : ''; ?>><?php echo $subheadline; ?></p>  
        <?php endif; ?>
    </div>
</div>
<div class="row">
    <?php if (have_rows('cta_card')) : ?>
        <?php while (have_rows('cta_card')) : the_row(); ?>
            <div class="card-col large-6 medium-6 small-12 columns">
                <div class="cta-card card">
                    <?php if (get_sub_field('cta_title')): ?>
                        <h3><?php the_sub_field('cta_title'); ?></h3>
                    <?php endif; ?>
                    <?php if (get_sub_field('cta_text')): ?>
                        <span class="head3-sub"><?php the_sub_field('cta_text');  ?></span>
                    <?php endif; ?>
                    <?php if (get_sub_field('button')): ?>
                        <?php $link = get_sub_field('button'); ?>
                        <a href="<?php echo $link['url']; ?>" 
                            target="<?php echo $link['target']; ?>" 
                            aria-label="<?php echo $link['title']; ?>" class="button <?php the_sub_field('dual_button_style'); ?>">
                            <?php echo $link['title']; ?>
                        </a>
                    <?php endif ?>
                </div>
            </div>
        <?php endwhile; ?>
    <?php endif; ?>
</div>
</section>