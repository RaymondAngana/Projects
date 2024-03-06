<ul class="right">
    <li>Share</li>
    <?php if (have_rows('social_links', 'option')) : ?>
        <?php while (have_rows('social_links', 'option')) : the_row(); ?>
            <?php
            $current_url = get_permalink();
            $social = get_sub_field('url');
            $social_share = [
                'facebook' => 'https://www.facebook.com/sharer/sharer.php?u=',
            ];
            $url = strpos($social, 'facebook') >= 1 ? ('https://www.facebook.com/sharer/sharer.php?u=' . $current_url) : $social;
            $url = strpos($social, 'twitter') >= 1 ? ('http://twitter.com/share?url=' . $current_url) : $url;
            ?>
            <li><a href="<?=$url;?>" target="_blank" class="social"><img src="<?php the_sub_field('icon'); ?>" alt="<?php the_sub_field('alt'); ?>"></a></li>
        <?php endwhile; ?>
    <?php endif; ?>
</ul>