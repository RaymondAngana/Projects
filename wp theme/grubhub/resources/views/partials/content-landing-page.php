<?php
// Load values and assign defaults.
$mh_headline = get_field('mh_headline') ? : 'Headline';
$mh_text_color = get_field('mh_text_color') ? : '#189096';
$mh_backgroundImg = get_field('mh_background_img') ? : 'Background Image';
$mh_backgroundImgMob = get_field('mh_backgroundImgMob') ? : 'Background Mobile';
$mh_show_form = get_field('mh_show_form') ? : 'Show Form';
$mh_form_headline = get_field('mh_form_headline') ? : 'Form Headline';
?>

<style>
  .marq-h-content {
    color: <?php echo $mh_text_color; ?>
  }

  .marq-bg {
    background-image: url(<?php echo $mh_backgroundImg; ?>);
    height: 300px;
    background-repeat: no-repeat;
    background-position: top;
    background-size: cover;
  }
  @media screen and (min-width: 440px) {
    .marq-bg {
      height: 400px;
      background-repeat: no-repeat;
      background-position: right;
    }
  }
  @media screen and (min-width: 768px) {
    .marq-bg {
      height: 500px;
      background-repeat: no-repeat;
      background-position: right;
    }
  }
  @media screen and (min-width: 1024px) {
    .marq-bg {
      height: 670px;
      background-repeat: no-repeat;
      background-position: right;
    }
  }

</style>

<section id="marqHalf">
  <div class="row align-justify align-middle half-half">
    <div class="columns small-12 medium-12 large-5 marq-h-content">
      <?php if (get_field('mh_headline')): ?>
        <h1><?php the_field('mh_headline'); ?></h1>
      <?php endif; ?>
      <?php if (get_field('mh_subheadline')): ?>
        <p class="head2-sub"><?php the_field('mh_subheadline'); ?></p>
      <?php endif; ?>
      <div class="subscription-form">
        <?php if (get_field('mh_show_form')) :  ?>
          <h3 class="text-left medium head3-special"><?php the_field('mh_form_headline'); ?></h3>
          <div class="form-wrap">
            <?php
            $mh_formID = get_field('mh_formID');
            if (get_field('mh_formID')) {
              inc_form($mh_formID);
            } else {
              echo '<p class="no-form">No form selected.</p>';
            }
            ?>
          </div>
        </div>
      </div>
    <?php endif; ?>
    <div class="columns small-12 medium-12 large-6 marq-bg"></div>
  </div>
</section>
<?php 
$headline = get_field('grid_headline');
$subheadline = get_field('grid_sub_headline');
$align = get_field('headline_alignment');
$postTypes = get_field('post_type');
$categories = get_field('post_categories');
?>
<section class="grid-cards gh-cards">
  <div class="row align-center align-middle">
    <div class="columns">
      <?php if (get_field('grid_headline') || get_sub_field('grid_headline')): ?>
      <h2 <?php echo $align ? 'class="'. $align .'"' : ''; ?>><?php echo $headline; ?></h2>
    <?php endif; ?>
    <?php if (get_field('grid_sub_headline') || get_sub_field('grid_sub_headline')): ?>
    <h3 <?php echo $align ? 'class="'. $align .'"' : ''; ?>><?php echo $subheadline; ?></h3>  
  <?php endif; ?>
</div>
</div>
<div class="row" data-equalizer>
  <?php
  $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
  $args = array(
    'post_type' => $postTypes,
    'posts_per_page' => 8,
    'paged' => $paged,
    'tax_query' => array(
      'relation' => 'OR',
      array(
        'taxonomy' => 'cattypes',
        'field' => 'slug',
        'terms' => $categories
      ),
      array(
        'taxonomy' => 'category',
        'field' => 'slug',
        'terms' => $categories
      ),
    )
  );
  $catQuery = new WP_Query( $args );
  while ( $catQuery->have_posts() ) : $catQuery->the_post();
    ?>
    <div class="card-col columns large-3 medium-6 small-12 <?php echo get_field('disable_animation') ? '' : 'card-anim' ?>" data-equalizer-watch>
      <div class="card white img-card text-left content-archive">
        <a href="<?php the_permalink(); ?>">
          <div class="img">
            <?php if ( has_post_thumbnail() ) : ?>
             <?php the_post_thumbnail(); ?>
           <?php endif; ?>
         </div>
         <h3 class="even head3-special"><?php echo limit_text(get_the_title(), 8); ?></h3>
         <p class="p-even"><?php echo limit_text(get_the_excerpt(), 20); ?></p>
       </a>
     </div>
   </div>
 <?php endwhile; wp_reset_query(); ?>
</div>
<div class="row">
  <div class="columns">
    <div class="pagination">
      <?php
      $SVG = [
        'dbLeft' => '<svg width="31" height="24" class="dbl" viewBox="0 0 31 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M22 18L16 12L22 6" stroke="#572AF8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M15 18L9 12L15 6" stroke="#572AF8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
        'dbRight' => '<svg width="30" height="24" class="dbl" viewBox="0 0 30 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M9 18L15 12L9 6" stroke="#572AF8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M15 18L21 12L15 6" stroke="#572AF8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
        'singLeft' => '<svg width="45" height="45" viewBox="0 0 45 45" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="22.5" cy="22.5" r="22.5" transform="rotate(-180 22.5 22.5)" fill="#572AF8"/><path d="M28.6362 22.7729H15.7206" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/><path d="M21.4946 30.0664L15.3407 22.7729L21.4946 15.4794" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>',
        'singRight' => '<svg width="45" height="45" viewBox="0 0 45 45" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="22.5" cy="22.5" r="22.5" fill="#572AF8"/><path d="M16.3638 22.2271L29.2794 22.2271" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/><path d="M23.5054 14.9336L29.6593 22.2271L23.5054 29.5206" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>',
      ];
    // global $wp_query;
      $total = $catQuery->max_num_pages;
      if ( $total > 1 )  {
       if ( !$current_page = get_query_var('paged') )
        $current_page = 1;
      $format = empty( get_option('permalink_structure') ) ? '&page=%#%' : 'page/%#%/';
      // Create Beginning Page Link
      echo ($current_page != 1) ? '<a href="'. esc_url( get_pagenum_link(1)) .'" aria-label="go to first page of results" role="button" class="fp">' . $SVG['dbLeft'] . '</a>' : '<span aria-label="you are on the first page" class="start">'. str_replace('#572AF8', '#BEBEBE', $SVG['dbLeft']) .'</span>';
      // Create Previous Page Link
      echo get_previous_posts_link() ? previous_posts_link($SVG['singLeft']) : '<span class="inactive l">' .str_replace('#572AF8', '#BEBEBE', $SVG['singLeft']) . '</span>';
      echo paginate_links(array(
        'base' => get_pagenum_link(1) . '%_%',
        'format' => $format,
        'current' => $current_page,
        'aria_current' => $current_page,
        'total' => $total,
        'mid_size' => 1,
        'type' => 'list',
        'prev_text' => $SVG['singLeft'],
        'next_text' => $SVG['singRight'],
        'prev_next' => false
      ));
      // Create Next Page Link
      echo ($current_page < $total) ? '<a href="'. esc_url( get_pagenum_link($current_page + 1)) .'">' . $SVG['singRight'] . '</a>' : '<span class="inactive r">' .str_replace('#572AF8', '#BEBEBE', $SVG['singRight']) . '</span>';
      // Create End Page Link
      echo ($current_page >= $total) ? '<span aria-label="you are on the last page" class="end">'. str_replace('#572AF8', '#BEBEBE', $SVG['dbRight']) .'</span>' : '<a href="'. esc_url( get_pagenum_link($total)) .'"  aria-label="go to last page of results" class="lp" role="button">' . $SVG['dbRight'] . '</a>';
    }
    ?>
  </div>
</div>
</div>
</section>

<?php the_content(); ?>
