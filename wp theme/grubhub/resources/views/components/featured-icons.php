<?php

/**
 * Featured Icons
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Load values and assign defaults.
$bg = get_field('background');
$icons = get_field('icons');

?>


<div style="background:<?=$bg;?>">
  <div class="wp-block-columns section-block-bg section-call is-layout-flex wp-container-9 row align-center">
  <?php  if( $icons ): ?>
    
      <?php foreach ($icons as $icon): 
        $link = $icon['icon']['url'];
        $color = $icon['bigger_text']['color'];
      ?>
      <div class="wp-block-column call-for-speaker custom-content-box is-layout-flow" style="background:<?=$icon['background'];?>">
        <div class="wp-block-image">
          <a href="<?=$link;?>"><img decoding="async" loading="lazy" width="301" height="300" src="<?=$icon['icon']['url'];?>" alt="<?=$icon['icon']['alt'];?>" class="wp-image-218" srcset="<?=$icon['icon']['url'];?> 301w, https://cebu.wordcamp.org/2023/files/2022/11/Speakers-150x150.webp 150w" sizes="(max-width: 301px) 100vw, 301px"></a>
        </div>


        <h3 class="wp-block-heading has-text-align-center"><a href="<?=$link;?>"><?=$icon['text'];?></a></h3>
        <h3 class="wp-block-heading has-text-align-center"><span class="call-for-speaker__speaker"><a style="color:<?=$color;?>" href="<?=$link;?>"><?=$icon['bigger_text']['text'];?></a></span></h3>
      </div>

    <?php endforeach; ?>
  <?php endif; ?>
  </div>
</div>