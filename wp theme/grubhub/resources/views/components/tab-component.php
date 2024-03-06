<?php

/**
 * Tab Component Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

require_once('helper-functions.php');
$field_or_subfield = isset($is_flex) ? 'get_sub_field' : 'get_field';

// Load values and assign defaults.
$heading = call_user_func($field_or_subfield, 'heading');
$title = call_user_func($field_or_subfield, 'title');
$text = call_user_func($field_or_subfield, 'text');
$is_cta = call_user_func($field_or_subfield, 'add_cta');
$cta = call_user_func($field_or_subfield, 'cta');
$tab_img = call_user_func($field_or_subfield, 'image');
$tabs = call_user_func($field_or_subfield, 'tabs');
$padding = call_user_func($field_or_subfield, 'custom_padding');

$heading_alignment = $heading['alignment'] != '' ? $heading['alignment'] : 'center';
$tab_content = $tabs['tab_content'];
$tab_active = $tabs['active_indicator'];
$common_class = 'columns large-6 medium-12 small-12';
?>

<section class="tab-component" style="<?php echo $padding['padding_top'] != '' ? "padding-top: " . $padding['padding_top'] . 'px; ' : ''; echo $padding['padding_bottom'] != '' ? "padding-bottom: " . $padding['padding_bottom']. "px" : ''; ?>">
  <div class="row align-<?=$heading_alignment;?>">
    <?php print print_header($heading, 'h2', ' class="' . $heading['color'] . '"'); ?>
  </div>
  <div class="align-center contained">
    <div class="top-content row large-12 align-middle">
      <div class="<?=$common_class;?>" >
        <h3 class="<?=$title['color'];?>"><?php echo $title['text']; ?></h3>
        <p class="<?=$text['color'];?>"><?php echo $text['text']; ?></p>
        <?php if ($is_cta): ?>
          <div class="btn-wrap"><?php echo print_cta($cta); ?></div>
        <?php endif; ?>
      </div>
      <div class="<?=$common_class;?>">
        <?php if ($tab_img): ?>
          <img src="<?php echo esc_url($tab_img['url']); ?>" alt="<?php echo $tab_img['alt']; ?>"/>
        <?php endif; ?>
      </div>
    </div>
    <div class="tab-content row large-12 medium-12 small-12">
      <div class="columns large-12 medium-12 small-12 tab-wrap <?=$tab_active;?>">
        <?php
        foreach ($tab_content as $tab) {
          $tab_titles[] = $tab['title'];
          $tab_body[] = [
            'body' => $tab['body'],
            'img' => $tab['image'],
          ];
        }
        ?>

        <ul class="tabs items<?=sizeof($tab_titles). ' ' . $tabs['active_indicator'];?>" data-allow-all-closed="true" data-responsive-accordion-tabs="tabs small-accordion large-tabs" id="gh-tabs">
          <?php
          foreach ($tab_titles as $key => $title) {
            $is_active = $key == 0 ? ' is-active' : '';
            $aria = $key == 0 ? ' area-selected="true"' : '';
            echo '<li class="tabs-title'.$is_active.'"><a href="#panel'.$key.'"'.$aria.'>'.$title.'</a></li>';
          }
          ?>
        </ul>

        <div class="tabs-content" data-tabs-content="gh-tabs">
          <?php
          $html = '';
          foreach ($tab_body as $key => $tab) {
            $is_active = $key == 0 ? ' is-active' : '';
            $html .= '<div class="tabs-panel'.$is_active.'" id="panel'.$key.'">';
            $html .= '<div class="row align-middle">';
            $html .= '<div class="'.$common_class.'"><img src="'.$tab['img']['url'].'" /></div>';
            $html .= '<div class="'.$common_class.' align-self-middle">'.$tab['body'].'</div>';
            $html .= '</div></div>';
          }
          print $html;
          ?>
        </div>
      </div>
    </div>
  </div>
</section>