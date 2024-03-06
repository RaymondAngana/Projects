<?php

/**
 * Multi View Half & Half Template
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
$cta = call_user_func($field_or_subfield, 'cta');
$image = call_user_func($field_or_subfield, 'image');
$content = call_user_func($field_or_subfield, 'content');
$aria_title = call_user_func($field_or_subfield, 'icon_aria_and_title');
$padding = call_user_func($field_or_subfield, 'custom_padding');

$link = $cta['text'];
$subheading = $content['subheading'];
$bullet_items = $content['bullet_items'];
$medium_up = 'show-for-medium show-for-large';
$aria = $aria_title ?? 'Click here to reveal more info';
$link_html = '';

if (!empty($cta['text'])) {
    $link_html = '<div class="btn-wrap">' . print_cta($cta) . '</div>';
}

$image_mobile = '<div class="columns mobile-img hide-for-large">' . print_img($image) . '</div>';
$toggle_image = print_img($image, ['toggle', $medium_up]);
?>

<section class="multi-view" style="<?php echo $padding['padding_top'] != '' ? "padding-top: " . $padding['padding_top'] . 'px; ' : ''; echo $padding['padding_bottom'] != '' ? "padding-bottom: " . $padding['padding_bottom']. "px" : ''; ?>">
	<div class="row contained align-right align-middle">
        <?php echo $image_mobile; ?>
		<div class="columns small-12 medium-12 large-4">
			<?php echo print_header($heading, 'h3'); ?>
			<?php echo $link_html; ?>
		</div>
		<div class="columns small-12 medium-12 large-7 content-holder">
            <div class="button-and-image">
                <span title="<?=$aria;?>" aria-label="<?=$aria;?>" class="<?=$medium_up;?> top" data-tooltip tabindex="0">
                    <i class="fas fa-plus"></i>
                </span>
                <?php echo $toggle_image; ?>
            </div>
            <div class="bullet-item">
                <?php echo print_bullet_items($bullet_items, $subheading); ?>
            </div>
		</div>
	</div>
</section>

