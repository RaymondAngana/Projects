<?php
/**
 * Careersource Custom Theme Functionality.
 *
 * Contains custom hooks, actions, filters,
 * widgets, sidebars and shortcodes.
 */

require_once('includes/rsvp_fields_markup.php');
require_once('includes/accessibility_fixes.php');
require_once('includes/break_series_events_to_single.php');
require_once('includes/forums.php');
require_once('widgets/init.php');
require_once('shortcodes/init.php');


class CareerSource {
  /**
   * Constructor.
   */
  function __construct() {
    // Register action/filter callbacks.
    add_action('wp_enqueue_scripts', array($this, 'init'), PHP_INT_MAX);
    add_action('init', array($this, 'allow_author_editing'));
    add_action('admin_menu', array($this, 'show_settings_only_to_admin'));
    add_action('admin_bar_menu', array($this, 'break_event_series'), 999);
    add_action('admin_enqueue_scripts', array($this, 'enqueue_custom_scripts_in_admin'));
    add_action('careersource_process_testimonials', array($this, 'process_submitted_testimonials'));
    add_action('tribe_events_community_section_before_submit', array($this, 'create_custom_rsvp_fields'));
    add_action('tribe_community_event_created', array($this, 'process_rsvp_fields'));
    add_action('tribe_events_single_event_before_the_content', array($this, 'add_rsvp_message_placeholder'));
    add_action('tha_body_top', array($this, 'show_emergency_message'));
    add_action('tha_footer_before', array($this, 'append_before_footer'), 101);

    add_filter('body_class', array($this, 'custom_classnames_in_body_tag'), 20, 2);
    add_filter('tribe_rsvp_email_headers', array($this, 'rsvp_bcc_admin_ticket'));
    add_filter('get_the_archive_title', array($this, 'modify_archive_title'), 10, 1);
    add_filter('wp_nav_menu_objects', array($this, 'convert_nav_menu_to_dropdown'), 10, 2);
    add_filter('wmhook_fn_polyclinic_excerpt_continue_reading', array($this, 'new_excerpt_more'), 11);
    add_filter('wmhook_fn_polyclinic_post_meta_bottom_post_type', array($this, 'custom_post_type_entry_meta'));
    add_filter('the_category', array($this, 'filter_the_category_for_industry_news'), 10, 1);
    add_filter('searchwp_indexed_post_types', array($this, 'my_searchwp_indexed_post_types'));
  }

  /**
   * Enqueue global stylesheet and scripts in here.
   */
  function init() {
    // Enqueue our child theme's CSS, FontAwesome, Typekit and custom JS.
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
    wp_enqueue_style('custom-fa', 'https://use.fontawesome.com/releases/v5.0.6/css/all.css');
    wp_enqueue_style('typekit-font', 'https://use.typekit.net/hft6ijd.css');
    wp_enqueue_script('careersource_custom_scripts', get_stylesheet_directory_uri() . '/js/custom.js');

    // CWR-132: IE 11 and below is freezing. Remove culprit.
    $ua = htmlentities($_SERVER['HTTP_USER_AGENT'], ENT_QUOTES, 'UTF-8');
    if (preg_match('~MSIE|Internet Explorer~i', $ua) || (strpos($ua, 'Trident/7.0') !== false && strpos($ua, 'rv:11.0') !== false)) {
      wp_dequeue_script('css-vars-ponyfill');
    }
  }

  /**
   * Ensure that Tools link is only shown to admin and not any other users.
   */
  function show_settings_only_to_admin() {
    if (!current_user_can('administrator')) {
      remove_menu_page('tools.php');
    }
  }

  /**
   * A custom workaround to ensure submitted fields populate into respective admin UI.
   * Currently being used in Testimonials and Events admin page.
   */
  function enqueue_custom_scripts_in_admin($hook) {
    $screen = get_current_screen();
    if ($screen->base == 'post' && $_GET['action'] == 'edit') {

      // Enqueue only when in the Testimonials post type admin area.
      if ($screen->post_type == 'wm_testimonials') {
        wp_enqueue_script('wm-testimonials', get_stylesheet_directory_uri() . '/js/wm_testimonials.js');
      }

      // Enqueue only when in the Add Events admin area.
      if ($screen->post_type == 'tribe_events') {
        wp_enqueue_script('tribe-community-tickets', get_stylesheet_directory_uri() . '/js/event_ticket_rsvp.js');
      }
    }
  }

  /**
   * Set custom classnames to body tag if blog page, interior pages, blog-related and browser.
   */
  function custom_classnames_in_body_tag($wp_classes) {
    // CWR-133: Remove the "paged" classname in body to stop masonry from messing layout.
    // Should only affect the Blog archive.
    if (is_home()) {
      foreach ($wp_classes as $key => $value) {
        if ($value == 'paged') {
          unset($wp_classes[$key]);
        }
      }
    }

    // CWR-150: Add page-template-with-sidebar class to Interior Pages templates.
    if (basename(get_page_template()) == 'interior-pages.php') {
      $wp_classes[] = 'page-template-with-sidebar';
    }

    // CWR-261: Add blog-related class to industry news.
    if (get_post_type() == 'industry-news' && basename(get_page_template()) == 'page.php') {
      $wp_classes[] = 'single-post';
      $wp_classes[] = 'fl-builder';
    }

    // CWR-237: Add browser detection into body as class name.
    // https://codex.wordpress.org/Global_Variables#Browser_Detection_Booleans.
    $browsers = ['is_iphone', 'is_chrome', 'is_safari', 'is_NS4', 'is_opera', 'is_macIE', 'is_winIE', 'is_gecko', 'is_lynx', 'is_IE', 'is_edge'];

    $wp_classes[] = join(' ', array_filter($browsers, function ($browser) {
      return $GLOBALS[$browser];
    }));

    return $wp_classes;
  }

  /**
   * Modify the title on Events archive page.
   */
  function modify_archive_title( $title ) {
    if (is_post_type_archive('tribe_events')) {
      return 'Events';
    }
  }

  /**
   * Replaces the excerpt "Continue Reading" link to "Read More".
   */
  function new_excerpt_more($more) {
    global $post;
    return '<div class="link-more">
      <a aria-label="Read more about ' . get_the_title() . '" href="' . esc_url(get_permalink($post->ID)) . '" class="more-link">' .
      sprintf(
        esc_html_x('Read More%s&hellip;', '%s: Name of current post.', 'polyclinic'),
        the_title('<span class="screen-reader-text"> &ldquo;', '&rdquo;</span>', false)
      ) . '</a>
    </div>';
  }

  /**
   * CWR-263: Show entry-meta content to post and industry-news post types.
   */
  function custom_post_type_entry_meta($post_type) {
    // Return blank if archive of blog home.
    if (is_archive() || is_home()) return '';

    // Only show meta info if URL contains industry-news/.
    if (strpos($_SERVER['REQUEST_URI'], 'industry-news')) {
      $post_type[] = 'industry-news';
    }

    return $post_type;
  }

  /**
   * Convert Job Seekers menu from a list to a dropdown.
   */
  function convert_nav_menu_to_dropdown($items, $args) {
    $menus_to_dropdown = array(
      'more-in-employers',
      'more-in-jobseekers',
      'more-in-young-job-seekers',
      'more-in-partners-vendors',
      'more-in-business-services',
      'more-in-research',
      'categories-in-blog-subpages',
      'workers-w-disabilities-menu',
    );

    if (in_array($args->menu->slug, $menus_to_dropdown)) {
      $menu = '<form role="form" method="get" action="' . get_site_url() . '/">';
      $menu .= '<select class="more-in-dropdown"><option value="#">Select Options</option>';
      $menu_options = '';

      foreach ($items as $key => $menu_obj) {
        $menu_options .= '<option value="' . $menu_obj->url . '">' . $menu_obj->title . '</option>';
      }
      $menu .= $menu_options . '</select>';
      $menu .= '<input style="margin-top: 5px;" type="submit" class="more-in-dropdown-submit" aria-label="Find ' . $args->menu->name . '" value="Go!">';
      $menu .= '</form>';

      print $menu;

      // Force empty list.
      return '';
    }

    // Always return so other menu won't be affected.
    return $items;
  }

  /**
   * BCC site admin email on all Event Tickets' RSVP ticket emails so they get a copy of it too.
   *
   * From https://gist.github.com/cliffordp/4f06f95dbff364242cf54a3b5271b182
   * Reference: https://developer.wordpress.org/reference/functions/wp_mail/#using-headers-to-set-from-cc-and-bcc-parameters
   */
  function rsvp_bcc_admin_ticket() {
    $organizers = tribe_get_organizers(false, -1, true, array('event' => get_the_ID()));
    $organizers_email = [];

    foreach ($organizers as $organizer) {
      $email = tribe_get_organizer_email($organizer->ID, false);
      if (isset($email)) {
        $organizers_email[] = sanitize_email($email);
      }
    }

    // Set Headers to Event Tickets' default.
    $headers = array('Content-type: text/html');
    $bcc = implode(', ', $organizers_email);
    $headers[] = 'Bcc: ' . $bcc;

    return $headers;
  }

  /**
   * This is a custom filter that is being called in Testimonials form processor.
   * This wouldn't work without RunAction plugin: https://calderaforms.com/downloads/caldera-forms-run-action/
   * Configured in Processors tab in: /wp-admin/admin.php?edit=CF5c5ceaa16e805&page=caldera-forms
   * The custom script enqueued in enqueue_wm_testimonial_cheat_js() is essential to copy ACF's author info
   *   into the WM-Testimonials metabox. It's a dirty fix. I admit.
   *
   * Additional "cheat" is needed in ACF field of author_name to ensure it's hidden in admin UI.
   */
  function process_submitted_testimonials($data) {
    $args = array(
      'post_type' => 'wm_testimonials',
      'posts_per_page' => 1,
      'post_status' => 'pending',
    );
    $query_posts = new WP_Query($args);

    // Get the inserted ID of the testimonials.
    $entry_id = $query_posts->posts[0]->ID;

    // Grab the author info from the submitted form passed by $data variable.
    $author_info = array('name' => $data['author'], 'work' => $data['author_work_title']);

    // Set our ACF fields based on submitted form. The update_field() is an ACF function.
    update_field('author', $author_info['name'], $entry_id);
    update_field('work_title', $author_info['work'], $entry_id);

    // Always reset query as a best practice.
    wp_reset_query();
  }

  /**
   * Custom Action that adds custom RSVP fields to community events.
   */
  function create_custom_rsvp_fields() {
    $rsvp_name = isset($_POST['RSVPname']) ? $_POST['RSVPname'] : '';
    $rsvp_capacity = isset($_POST['RSVPcapacity']) ? $_POST['RSVPcapacity'] : '';

    print custom_rsvp_fields($rsvp_name, $rsvp_capacity);
  }

  /**
   * Hooks into tribe_community_event_created action.
   * This processes the RSVP fields after the community tickets has been submitted.
   */
  function process_rsvp_fields($event_id) {
    $current_post = get_post($event_id, 'ARRAY_A');
    $post_id = $current_post['ID'];

    // Custom ACF functions - update_field().
    update_field('rsvp_name', $_POST['RSVPname'], $post_id);
    update_field('rsvp_capacity', $_POST['RSVPcapacity'], $post_id);
  }

  /**
   * Prepend custom HTML before <footer> starts.
   */
  function append_before_footer() {
    // Ensure this only appends in Interior Pages Template.
    if (basename(get_page_template()) == 'interior-pages.php' && is_active_sidebar('interior-bottom')) {
      ob_start();
      dynamic_sidebar('interior-bottom');
      $bottom_interior = ob_get_contents();
      ob_end_clean();

      $bottom_html = '
        <div class="fl-row fl-row-full-width footer_interior fl-row-bg-none orange banner fl-row-layout-full-fixed">
          <div class="fl-row-content-wrap">
            <div class="fl-row-content fl-row-fixed-width fl-node-content">
              <div class="fl-col-group">
                <div class="fl-col fl-col-has-cols fl-col-width-1-1">
                  <div class="fl-col-content fl-node-content">
                    <div class="fl-col-group fl-col-group-nested">' . $bottom_interior . '
                    </div>
                  </div>
                </div>
              </div>
            </div>
        </div>';

      // Start output.
      echo $bottom_html;
      echo "\r\n\r\n\t\t" . '</main><!-- /#main -->';
      echo "\r\n\t"       . '</div><!-- /#primary -->';
      echo "\r\n"         . '</div><!-- /#content -->' . "\r\n\r\n";
    }
  }

  /**
   * CWR-66: Show emergency message on top.
   */
  function show_emergency_message() {
    if (is_active_sidebar('emergency-message')) {
      dynamic_sidebar('emergency-message');
    }
  }

  /**
   * CWR-263: Add author editing support to industry news.
   */
  function allow_author_editing() {
    global $wpdb;
    add_post_type_support('industry-news', array('author', 'comments'));

    // Switch comments on automatically.
    $wpdb->query(
      $wpdb->prepare(
        "UPDATE $wpdb->posts SET comment_status = %s WHERE post_type = %s",
        array('open', 'industry-news')
      )
    );
  }

  /**
   * CWR-82: Add "Break Event" button on admin topbar.
   */
  function break_event_series($wp_admin_bar) {
    $args = array(
        'id' => 'break_event_series',
        'title' => '&laquo; Break Event Series &raquo;',
        'href' => get_site_url() . '/?break_event_series=1',
        'meta' => array(
          'class' => 'break_event_series',
          'title' => 'Break Event Series',
        )
    );
    $wp_admin_bar->add_node($args);
  }

  /**
   * CWR-263: Filter category output for industry-news.
   */
  function filter_the_category_for_industry_news($category) {
    $page_template = basename(get_page_template());
    return ( !is_admin() && (get_post_type() == 'industry-news' && $page_template == 'page.php') ?
      get_the_term_list( $post->ID, 'industry') :
      $category );
  }

  /**
   * CWR-311: Reduce the size of the SearchWP index by only indexing Posts and
   * and ignoring all other post types according to pages calling the search.
   */
  function my_searchwp_indexed_post_types($post_types) {
    $all_post = array('post', 'page', 'industry-news');

    if (isset($_GET['post_types'])) {
      switch ($_GET['post_types']) {
        case "post":
        case "industry-news":
          return array('post', 'industry-news');
          break;
        default:
          return $all_post;
          break;
      }
    }
    return $all_post;
  }

  /**
   * CWR-321: Create RSVP message placeholder for clone.
   */
  function add_rsvp_message_placeholder() {
    echo '<div id="tribe-rsvp-message-display-top" class="tribe-rsvp-message-display"></div>';
  }


// DO NOT DELETE.
}

// Instantiate theme.
$careersource = new CareerSource();
