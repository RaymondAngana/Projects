<footer>
  <div class="row social-row">
    <div class="social-row-left small-12 medium-6 large-6">
     <ul class="left">
      <?php $footerLogo = get_field('footer_logo', 'option') ?>
      <li class="home"><a class="brand" href="<?php echo home_url('/'); ?>"><img src="<?php echo $footerLogo['url']; ?>" alt="echo $footerLogo['alt'];" /></a></li>
    </ul>
  </div>
  <div class="social-row-right small-12 medium-6 large-6">
   <ul class="right">
    <li>Connect</li>
    <?php if (have_rows('footer_social_links', 'option')) : ?>
      <?php while (have_rows('footer_social_links', 'option')) : the_row(); ?>
        <li><a href="<?php the_sub_field('url'); ?>" target="_blank" class="social"><img src="<?php the_sub_field('icon'); ?>" alt="<?php the_sub_field('alt'); ?>" /></a></li>
      <?php endwhile; ?>
    <?php endif; ?>
  </ul>
</div>
</div>
<div class="row resources-row">
  <div class="resources-section columns small-12 medium-12 large-9 small-order-2 medium-order-2 large-order-1">
    <?php if (have_rows('footer_menu', 'option')) : ?>
      <?php while (have_rows('footer_menu', 'option')) : the_row(); ?>
        <div class="menu-row">
          <ul>
            <li><h3><?php the_sub_field('column_headline', 'option'); ?></h3></li>
            <?php if ( have_rows('menu_items', 'option')) : ?>
              <?php while ( have_rows('menu_items', 'option')) : the_row(); ?>
                <?php $link = get_sub_field('link', 'option'); ?>
                <li><a href="<?php echo $link['url']; ?>" target="<?php echo $link['target']; ?>"><?php echo $link['title']; ?></a></li>
              <?php endwhile; ?>
            <?php endif; ?>
          </ul>
        </div>
      <?php endwhile; ?>
    <?php endif; ?>
  </div>
  <div role="form" class="newsletter-form cta-form columns small-12 medium-12 large-3 small-order-1 medium-order-1 large-order-2">
    <div class="form-wrap">
      <h3 class="text-left medium head3-special">Sign up for<br>restaurant insights</h3>
      <?php
      inc_form(147);
      ?>
    </div>

  </div>
</div>
<div class="row legal-row">
  <div class="columns">
    <div class="legal-wrap">
      <?php $legal = get_field('legal_links', 'option'); ?>
      <?php echo $legal; ?>
    </div>
  </div>
</div>
</footer>
