<?php

add_action('acf/init', 'grubhub_blocks');
function grubhub_blocks() {

    // Check function exists.
  if( function_exists('acf_register_block_type') ) {

    acf_register_block_type(array(
      'name'              => 'component-wrap',
      'title'             => __('Component Wrapper'),
      'description'       => __('Group components together inside a wrapper to create background style separation'),
      'render_template'   => 'views/components/component-wrap.php',
      'category'          => 'design',
      'icon'              => 'align-pull-left',
      'keywords'          => array( 'wrapper', ),
      'mode'              => 'preview',
      'icon' => array(
        'background' => '#572AF8',
        'foreground' => '#FF8000',
        'src' => 'columns',
      ),
      'supports'          => array(
        'align' => true,
        'mode' => false,
        'jsx' => true
      )
    ));

    acf_register_block_type(array(
      'name'              => 'bottom-form',
      'title'             => __('Bottom Form Component'),
      'description'       => __('Create a 50/50 split box with the standard CTA form'),
      'render_template'   => 'views/components/bottom-form.php',
      'category'          => 'widgets',
      'icon'              => 'align-pull-left',
      'keywords'          => array( 'split' ),
      'mode'              => 'edit',
      'icon' => array(
        'background' => '#572AF8',
        'foreground' => '#FF8000',
        'src' => 'columns',
      ),
      'supports'          => array(
        'align' => false
      )
    ));

    acf_register_block_type(array(
      'name'              => 'faq-block',
      'title'             => __('FAQ Component'),
      'description'       => __('Pull in the FAQs you want to render on the page'),
      'render_template'   => 'views/components/faq.php',
      'category'          => 'widgets',
      'icon'              => 'align-pull-left',
      'keywords'          => array( 'faq' ),
      'mode'              => 'edit',
      'icon' => array(
        'background' => '#572AF8',
        'foreground' => '#FF8000',
        'src' => 'columns',
      ),
      'supports'          => array(
        'align' => false
      )
    ));

    acf_register_block_type(array(
      'name'              => 'vc-block',
      'title'             => __('Video Carousel Component'),
      'description'       => __('Video Carousel'),
      'render_template'   => 'views/components/video-carousel.php',
      'category'          => 'widgets',
      'icon'              => 'align-pull-left',
      'keywords'          => array( 'carousel', 'video' ),
      'mode'              => 'edit',
      'icon' => array(
        'background' => '#572AF8',
        'foreground' => '#FF8000',
        'src' => 'columns',
      ),
      'supports'          => array(
        'align' => false
      )
    ));

    acf_register_block_type(array(
      'name'              => 'marquee-half-block',
      'title'             => __('Marquee Half & Half'),
      'description'       => __('Marquee Half & Half'),
      'render_template'   => 'views/components/marquee-half.php',
      'category'          => 'widgets',
      'icon'              => 'align-pull-left',
      'keywords'          => array( 'marquee', 'half' ),
      'mode'              => 'edit',
      'icon' => array(
        'background' => '#572AF8',
        'foreground' => '#FF8000',
        'src' => 'columns',
      ),
      'supports'          => array(
        'align' => false
      )
    ));

    acf_register_block_type(array(
      'name'              => 'marquee',
      'title'             => __('Marquee Component'),
      'description'       => __('Marquee'),
      'render_template'   => 'views/components/marquee.php',
      'category'          => 'widgets',
      'icon'              => 'align-pull-left',
      'keywords'          => array( 'marquee', 'form' ),
      'mode'              => 'edit',
      'icon' => array(
        'background' => '#572AF8',
        'foreground' => '#FF8000',
        'src' => 'columns',
      ),
      'supports'          => array(
        'align' => false
      )
    ));

    acf_register_block_type(array(
      'name'              => 'simple-marquee',
      'title'             => __('Simple Marquee Component'),
      'description'       => __('SimpleMarquee'),
      'render_template'   => 'views/components/marquee-simple.php',
      'category'          => 'widgets',
      'icon'              => 'align-pull-left',
      'keywords'          => array( 'marquee', 'headline', 'button' ),
      'mode'              => 'edit',
      'icon' => array(
        'background' => '#572AF8',
        'foreground' => '#FF8000',
        'src' => 'columns',
      ),
      'supports'          => array(
        'align' => false
      )
    ));

    acf_register_block_type(array(
      'name'              => 'grid-cards',
      'title'             => __('Grid Cards Component'),
      'description'       => __('Grid Cards'),
      'render_template'   => 'views/components/grid-cards.php',
      'category'          => 'widgets',
      'icon'              => 'align-pull-left',
      'keywords'          => array( 'grid', 'cards' ),
      'mode'              => 'edit',
      'icon' => array(
        'background' => '#572AF8',
        'foreground' => '#FF8000',
        'src' => 'columns',
      ),
      'supports'          => array(
        'align' => false
      )
    ));

    acf_register_block_type(array(
      'name'              => 'feed-cards',
      'title'             => __('Feed Cards Component'),
      'description'       => __('Feed Cards'),
      'render_template'   => 'views/components/feed-cards.php',
      'category'          => 'widgets',
      'icon'              => 'align-pull-left',
      'keywords'          => array( 'feed', 'cards' ),
      'mode'              => 'edit',
      'icon' => array(
        'background' => '#572AF8',
        'foreground' => '#FF8000',
        'src' => 'columns',
      ),
      'supports'          => array(
        'align' => false
      )
    ));

    acf_register_block_type(array(
      'name'              => 'large-cards',
      'title'             => __('Large Cards Component'),
      'description'       => __('Large Cards'),
      'render_template'   => 'views/components/large-cards.php',
      'category'          => 'widgets',
      'icon'              => 'align-pull-left',
      'keywords'          => array( 'grid', 'cards' ),
      'mode'              => 'edit',
      'icon' => array(
        'background' => '#572AF8',
        'foreground' => '#FF8000',
        'src' => 'columns',
      ),
      'supports'          => array(
        'align' => false
      )
    ));

    acf_register_block_type(array(
      'name'              => 'tile-stack-links',
      'title'             => __('Tile with Stacked Links Component'),
      'description'       => __('Tile with Stacked Links'),
      'render_template'   => 'views/components/tile-stack-links.php',
      'category'          => 'widgets',
      'icon'              => 'align-pull-left',
      'keywords'          => array( 'tile', 'links' ),
      'mode'              => 'edit',
      'icon' => array(
        'background' => '#572AF8',
        'foreground' => '#FF8000',
        'src' => 'columns',
      ),
      'supports'          => array(
        'align' => false
      )
    ));

    acf_register_block_type(array(
      'name'              => 'gated-content-form',
      'title'             => __('Gated Content Form Component'),
      'description'       => __('Gated Content Form'),
      'render_template'   => 'views/components/gated-content-form.php',
      'category'          => 'widgets',
      'icon'              => 'align-pull-left',
      'keywords'          => array( 'tile', 'links' ),
      'mode'              => 'edit',
      'icon' => array(
        'background' => '#572AF8',
        'foreground' => '#FF8000',
        'src' => 'columns',
      ),
      'supports'          => array(
        'align' => false
      )
    ));

    acf_register_block_type(array(
      'name'              => 'colored-stats',
      'title'             => __('Colored Stats Group Component'),
      'description'       => __('Colored Stats'),
      'render_template'   => 'views/components/colored-stats.php',
      'category'          => 'widgets',
      'icon'              => 'align-pull-left',
      'keywords'          => array( 'stats' ),
      'mode'              => 'edit',
      'icon' => array(
        'background' => '#572AF8',
        'foreground' => '#FF8000',
        'src' => 'columns',
      ),
      'supports'          => array(
        'align' => false
      )
    ));

    acf_register_block_type(array(
      'name'              => 'pull-quote',
      'title'             => __('Pull Quote Component'),
      'description'       => __('Pull Quote'),
      'render_template'   => 'views/components/pull-quote.php',
      'category'          => 'widgets',
      'icon'              => 'align-pull-left',
      'keywords'          => array( 'pull quote' ),
      'mode'              => 'edit',
      'icon' => array(
        'background' => '#572AF8',
        'foreground' => '#FF8000',
        'src' => 'columns',
      ),
      'supports'          => array(
        'align' => false
      )
    ));

    acf_register_block_type(array(
      'name'              => 'centered-asset-text-cta',
      'title'             => __('Centered Asset + Text with CTA Component'),
      'description'       => __('Centered Asset + Text with CTA'),
      'render_template'   => 'views/components/centered-asset-text-cta.php',
      'category'          => 'widgets',
      'icon'              => 'align-pull-left',
      'keywords'          => array( 'asset', 'cta', 'centered', 'text' ),
      'mode'              => 'edit',
      'icon' => array(
        'background' => '#572AF8',
        'foreground' => '#FF8000',
        'src' => 'columns',
      ),
      'supports'          => array(
        'align' => false
      )
    ));

    acf_register_block_type(array(
      'name'              => 'subscription-form-component',
      'title'             => __('Subscription Form Component'),
      'description'       => __('Subscription Form Component, with visual variation options'),
      'render_template'   => 'views/components/form-subscription.php',
      'category'          => 'widgets',
      'icon'              => 'align-pull-left',
      'keywords'          => array( 'asset', 'cta', 'centered', 'text' ),
      'mode'              => 'edit',
      'icon' => array(
        'background' => '#572AF8',
        'foreground' => '#FF8000',
        'src' => 'columns',
      ),
      'supports'          => array(
        'align' => false
      )
    ));

    acf_register_block_type(array(
    'name'              => 'feature-component',
    'title'             => __('Feature Components (Split, Half, Contained, Unique)'),
    'description'       => __('Supports Heading and Text content along with a featured image.
    Component can be oriented with Image on left or right side, with Heading and Text on the other.'),
    'render_template'   => 'views/components/feature-components.php',
    'category'          => 'widgets',
    'icon'              => 'align-pull-left',
    'keywords'          => array( 'feature', 'half', 'split', 'unique', 'contained' ),
    'mode'              => 'edit',
    'icon' => array(
      'background' => '#572AF8',
      'foreground' => '#FF8000',
      'src' => 'columns',
    ),
    'supports'          => array(
      'align' => false
    )
    ));

    acf_register_block_type(array(
    'name'              => 'multiview',
    'title'             => __('Multi View Half & Half'),
    'description'       => __('Supports Heading, Text, and CTA content along with a featured image.
      Component is interactive. Plus sign hover/click will reveal a secondary state to replace image.
      Component can be oriented with Image on left or right side, with Heading and Text on the other.'),
    'render_template'   => 'views/components/multiview.php',
    'category'          => 'widgets',
    'icon'              => 'align-pull-left',
    'keywords'          => array( 'multi-view', 'multiview', 'multi view' ),
    'mode'              => 'edit',
    'icon' => array(
      'background' => '#572AF8',
      'foreground' => '#FF8000',
      'src' => 'columns',
    ),
    'supports'          => array(
      'align' => false
    )
    ));

    acf_register_block_type(array(
      'name'              => 'feature-image-title',
      'title'             => __('Feature Image and Title'),
      'description'       => __('Supports Title and Text content along with a featured image.'),
      'render_template'   => 'views/components/feature-image-title.php',
      'category'          => 'widgets',
      'icon'              => 'align-pull-left',
      'keywords'          => array( 'feature', 'image', 'title', 'text' ),
      'mode'              => 'edit',
      'icon' => array(
        'background' => '#572AF8',
        'foreground' => '#FF8000',
        'src' => 'columns',
      ),
      'supports'          => array(
        'align' => false
      )
    ));

    acf_register_block_type(array(
      'name'              => 'table-component',
      'title'             => __('Table Component'),
      'description'       => __('Content organized in a table format to present comparative info'),
      'render_template'   => 'views/components/table-component.php',
      'category'          => 'widgets',
      'icon'              => 'align-pull-left',
      'keywords'          => array( 'table', 'compare', 'comparative', 'pricing' ),
      'mode'              => 'edit',
      'icon' => array(
          'background' => '#572AF8',
          'foreground' => '#FF8000',
          'src' => 'columns',
      ),
      'supports'          => array(
          'align' => false
      )
    ));
    acf_register_block_type(array(
      'name'              => 'general-content',
      'title'             => __('General Content'),
      'description'       => __('Field for general content (long form text) that is set within the width of the main content bed (does not expand 100% width of browser'),
      'render_template'   => 'views/components/general-content.php',
      'category'          => 'widgets',
      'icon'              => 'align-pull-left',
      'keywords'          => array( 'general' ),
      'mode'              => 'edit',
      'icon' => array(
          'background' => '#572AF8',
          'foreground' => '#FF8000',
          'src' => 'columns',
      ),
      'supports'          => array(
          'align' => false
      )
    ));
    acf_register_block_type(array(
      'name'              => 'tab-component',
      'title'             => __('Tab Component'),
      'description'       => __('Content organized in a tab format to present info'),
      'render_template'   => 'views/components/tab-component.php',
      'category'          => 'widgets',
      'icon'              => 'align-pull-left',
      'keywords'          => array( 'tabs', 'tab' ),
      'mode'              => 'edit',
      'icon' => array(
          'background' => '#572AF8',
          'foreground' => '#FF8000',
          'src' => 'columns',
      ),
      'supports'          => array(
          'align' => false
      )
    ));

    acf_register_block_type(array(
      'name'              => 'dual-cta-component',
      'title'             => __('Dual CTA Component'),
      'description'       => __('Content organized in a cards to present two CTAs'),
      'render_template'   => 'views/components/dual-cta.php',
      'category'          => 'widgets',
      'icon'              => 'align-pull-left',
      'keywords'          => array( 'cta', 'cards' ),
      'mode'              => 'edit',
      'icon' => array(
          'background' => '#572AF8',
          'foreground' => '#FF8000',
          'src' => 'columns',
      ),
      'supports'          => array(
          'align' => false
      )
    ));

    acf_register_block_type(array(
      'name'              => 'fw-video-only',
      'title'             => __('Single full-width Video Component'),
      'description'       => __('Used on the Success Story article page'),
      'render_template'   => 'views/components/fw-video-only.php',
      'category'          => 'widgets',
      'icon'              => 'align-pull-left',
      'keywords'          => array( 'fw', 'video' ),
      'mode'              => 'edit',
      'icon' => array(
          'background' => '#572AF8',
          'foreground' => '#FF8000',
          'src' => 'columns',
      ),
      'supports'          => array(
          'align' => false
      )
    ));

      acf_register_block_type(array(
          'name'              => 'subfooter',
          'title'             => __('Subfooter test'),
          'description'       => __('Used on the Success Story article page'),
          'render_template'   => 'views/components/subfooter.php',
          'category'          => 'widgets',
          'icon'              => 'align-pull-left',
          'keywords'          => array( 'fw', 'video' ),
          'mode'              => 'edit',
          'icon' => array(
              'background' => '#572AF8',
              'foreground' => '#FF8000',
              'src' => 'columns',
          ),
          'supports'          => array(
              'align' => false
          )
      ));

      acf_register_block_type(array(
          'name'              => 'halfimage',
          'title'             => __('Half Image'),
          'description'       => __('Used on the Success Story article page'),
          'render_template'   => 'views/components/halfimage.php',
          'category'          => 'widgets',
          'icon'              => 'align-pull-left',
          'keywords'          => array( 'fw', 'video' ),
          'mode'              => 'edit',
          'icon' => array(
              'background' => '#572AF8',
              'foreground' => '#FF8000',
              'src' => 'columns',
          ),
          'supports'          => array(
              'align' => false
          )
      ));

      acf_register_block_type(array(
          'name'              => 'profit-calculator',
          'title'             => __('Profit Calculator'),
          'description'       => __('Add the profit calculator. Requires usage of the Profit Calculator page template'),
          'render_template'   => 'views/components/profit-calculator.php',
          'category'          => 'widgets',
          'icon'              => 'align-pull-left',
          'keywords'          => array( 'calc' ),
          'mode'              => 'edit',
          'icon' => array(
              'background' => '#572AF8',
              'foreground' => '#FF8000',
              'src' => 'columns',
          ),
          'supports'          => array(
              'align' => false
          )
      ));










































      









      acf_register_block_type(array(
          'name'              => 'featured-icons',
          'title'             => __('Featured Icons Wordcamp'),
          'description'       => __('Featured Icons'),
          'render_template'   => 'views/components/featured-icons.php',
          'category'          => 'widgets',
          'icon'              => 'align-pull-left',
          'keywords'          => array( 'calc' ),
          'mode'              => 'edit',
          'icon' => array(
              'background' => '#f00',
              'foreground' => '#fff',
              'src' => 'columns',
          ),
          'supports'          => array(
              'align' => false
          )
      ));


  }
}

?>