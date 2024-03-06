<?php

/**
 * Grid Card Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

$field_or_subfield = isset($is_flex) ? 'get_sub_field' : 'get_field';

// Load values and assign defaults.
$headline = call_user_func($field_or_subfield, 'section_headline');
$subheadline = call_user_func($field_or_subfield, 'section_subheadline');
$align = call_user_func($field_or_subfield, 'section_headline_alignment') ? : 'Headline Alignment';
$cardAlign = call_user_func($field_or_subfield, 'card_text_alignment') ? : 'Card Text Alignment';
$color = call_user_func($field_or_subfield, 'feed_card_headline_color') ? : 'Card Headline Color';
$featured_posts = call_user_func($field_or_subfield, 'feed_data');
$cardStyle = call_user_func($field_or_subfield, 'card_style');
$gridStyle = call_user_func($field_or_subfield, 'grid_style');
$cols = call_user_func($field_or_subfield, 'tablet_grid_style');
$animation = call_user_func($field_or_subfield, 'disable_animation');
$btnType = call_user_func($field_or_subfield, 'button_type');
$btnStyle = call_user_func($field_or_subfield, 'button_style');
$imgType = call_user_func($field_or_subfield, 'image_type');
$padding = call_user_func($field_or_subfield, 'custom_padding');
?>
<section class="s-grid-cards gh-cards" style="<?php echo $padding['padding_top'] != '' ? "padding-top: " . $padding['padding_top'] . 'px; ' : ''; echo $padding['padding_bottom'] != '' ? "padding-bottom: " . $padding['padding_bottom']. "px" : ''; ?>">
  <div class="row align-center align-middle">
    <div class="columns">
      <?php if (!empty($headline)): ?>
      <h2 class="<?php echo $align; echo $animation ? '' : ' card-anim'; ?>"><?php echo $headline; ?></h2>
    <?php endif; ?>
    <?php if (!empty($subheadline)): ?>
    <p class="head2-sub <?php echo $align; echo $animation ? '' : ' card-anim'; ?>"><?php echo $subheadline; ?></p>
  <?php endif; ?>
</div>
</div>
<div class="row align-center spacing" data-equalizer>
  <?php
  if( $featured_posts ): ?>
    <?php foreach( $featured_posts as $featured_post ): 
      $permalink = get_permalink( $featured_post->ID );
      $title = get_the_title( $featured_post->ID );
      $feedSnippet = get_field('feed_card_snippet', $featured_post->ID);
      $feedCTA = get_field('feed_card_cta_text', $featured_post->ID);
      ?>
      <div class="card-col columns <?php echo $gridStyle === 'three-up' ? 'large-4 ' : 'large-3 '; echo $cols === 'two-up-stacked' ? 'medium-6' : 'medium-10'; ?> small-12 <?php echo $animation ? '' : ' card-anim'; ?>" data-equalizer-watch>
        <div class="card <?php echo $cardStyle === 'white' ? 'white' : 'transparent'; ?>" 
          <?php $btnType === 'inline' ? 'onclick=location.href="'.$permalink.'"' : ''; ?>>
          <?php if ($imgType === 'icon'): ?>
            <div class="icon">
              <?php echo get_the_post_thumbnail($featured_post->ID); ?>
            </div>
            <?php else: ?>
              <div class="img">
                <?php echo get_the_post_thumbnail($featured_post->ID); ?>
              </div>
            <?php endif; ?>
            <h3 class="subhead <?php echo $color .' '. $cardAlign; ?> even"><?php echo $title; ?></h3>
            <?php if ($btnType === 'inline'): ?>
              <?php if ($feedSnippet): ?>
                <p><?php echo $feedSnippet; ?></p>
              <?php endif; ?>
              <p class="<?php echo $cardAlign; ?>"><?php echo limit_text(get_the_excerpt($featured_post->ID), 20); ?> <a href="<?php echo $permalink; ?>" class="read-more">&hellip;</a></p>
              <?php else: ?>
                <?php if ($feedSnippet): ?>
                  <p class="<?php echo $cardAlign; ?>"><?php echo $feedSnippet; ?></p>
                  <?php else: ?>
                  <p class="<?php echo $cardAlign; ?>"><?php echo limit_text(get_the_excerpt($featured_post->ID), 20); ?></p>
                <?php endif; ?>
                <a href="<?php echo $permalink; ?>" class="button <?php echo $btnStyle ?>">
                  <?php echo $feedCTA ? $feedCTA : 'Learn more'; ?>
                </a>
              <?php endif ?>
            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>  
    </div>
  </section>