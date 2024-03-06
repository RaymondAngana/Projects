<?php
/*
YARPP Template: Appen Related Posts
Description: Related Posts Template for Appen
Author: Tsema Alexander
 */
?>
    <style>
        .latest-news__slide {
            z-index: auto;
            background-color: rgb(255, 255, 255);
        }
    </style>
<!--    <div brightfunnel trigger="scroll"></div>-->
<?php if (have_posts()): ?>
    <div class="news-slider swiper-container">
		<div class="swiper-wrapper">
		<?php	while (have_posts()):
	the_post();
	if ($parent = get_category_by_slug('content-types')) {
		$categories = get_the_category(get_the_ID());
		foreach ($categories as $category) {
			if ($category->parent == $parent->term_id) {
				$primary_category = $category;
				break;
			}
		}
	} else {
		$post_categories = get_post_primary_category(get_the_ID());
		$primary_category = $post_categories['primary_category'];
	}
	?>
					<a href="<?php echo get_the_permalink(); ?>" class="swiper-slide latest-news__slide">
						<div class="latest-news__preview">
							<?php
	if (has_post_thumbnail()) {
		echo get_the_post_thumbnail(null, appen_is_amp() ? 'medium_large' : 'recommended');
	} else {
		if ($placeholder = wp_get_attachment_image(32329, appen_is_amp() ? 'medium_large' : 'recommended')) {
			echo $placeholder;
		} else {
			echo '<img src="/wp-content/themes/pro-child/static/dist/images/placeholder.jpg" alt="post preview">';
		}
	}
	?>
						</div>
						<div class="latest-news__category"><?php echo isset($primary_category) ? $primary_category->name : ''; ?></div>
						<p class="latest-news__title"><?php the_title()?></p>
						<span class="latest-news__read-more"><?php _e('Read More', 'appen');?></span>
					</a>
				<?php endwhile;?>
		</div>
    </div>
<?php
endif;