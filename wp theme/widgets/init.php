<?php

/**
 * All custom built widgets are defined in this file.
 */
class CareerSource_widgets {
  /**
   * Constructor.
   */
  function __construct() {
    add_action('widgets_init', array($this, 'register_sidebars'));

  	// CWR-261: Register Industry News categories widget.
		wp_register_sidebar_widget(
		  'industry_news_categories',
		  'Careersource: Industry News Categories',
		  array(&$this, 'industry_news_categories_display')
		);

		// CWR-261: Register Industry News categories widget.
		wp_register_sidebar_widget(
		  'industry_news_archive',
		  'Careersource: Industry News Archive',
		  array(&$this, 'industry_news_archive_display')
		);
  }

  /**
   * Create Custom sidebars accessible in Admin -> Appearance -> Widgets.
   */
  function register_sidebars() {
    $before_html = '<div class="fl-col fl-col-small fl-col-width-1-3 interior-bottom">
      <div class="fl-col-content fl-node-content">
      <div class="fl-module fl-module-rich-text boxed-boxes" data-type="rich-text">
      <div class="fl-module-content fl-node-content">';

    // CWR-150: Create custom sidebar widgets for Interior Pages template.
    register_sidebar(array(
      'id'            => 'sidebar-interior',
      'name'          => 'Sidebar for Interior Pages',
      'description'   => '',
      'before_widget' => '<section id="%1$s" class="widget %2$s">',
      'after_widget'  => '</section>',
      'before_title'  => '<h3 class="widget-title">',
      'after_title'   => '</h3>',
      )
    );
    register_sidebar(array(
      'id'            => 'interior-bottom',
      'name'          => 'Interior Pages bottom widgets',
      'description'   => '',
      'before_widget' => $before_html,
      'after_widget'  => '</div></div></div></div>',
      'before_title'  => '',
      'after_title'   => '',
      )
    );

    // CWR-66: Add sidebar for emergency message on header.
    register_sidebar(array(
      'id'            => 'emergency-message',
      'name'          => 'Emergency Message',
      'description'   => '',
      'before_widget' => '<section id="%1$s" class="emergency-message widget %2$s">',
      'after_widget'  => '</section>',
      'before_title'  => '<h3 class="widget-title emergency-message">',
      'after_title'   => '</h3>',
      )
    );

  }

  /**
   * CWR-261: Add Industry-news category widget.
   */
  function industry_news_categories_display() {
    if (get_post_type() == 'industry-news' && !is_search()) {
      $html = '<section id="industry-news-category-dropdown" class="widget"><h3 class="widget-title">Select a category</h3>';
      $html .= wp_dropdown_categories('taxonomy=industry&echo=0&value_field=slug&show_option_none=Select Options');
      $html .= '</section>';

      echo $html;
    }
  }

  /**
   * CWR-261: Add industry-news archive dropdown widget.
   */
  function industry_news_archive_display() {
    if (get_post_type() == 'industry-news') {
      $html = '<section id="industry-news-archive-dropdown" class="widget"><h3 class="widget-title">Archives</h3>';

      $html .= '<select name="archive-dropdown" onchange="document.location.href=this.options[this.selectedIndex].value;">
      <option value="">' . esc_attr( __( 'Select Month' ) ) . '</option>';

      $html .= wp_get_archives(
        array(
          'type' => 'monthly',
          'format' => 'option',
          'post_type' => 'industry-news',
          'echo' => 0
        )
      );
      $html .= '</select></section>';

      echo $html;
    }
  }
}

// Instantiate widget call.
$careersource_widgets = new CareerSource_widgets();
