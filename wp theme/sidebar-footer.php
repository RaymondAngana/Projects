<?php
/**
 * Footer widgets area template
 *
 * @package    Polyclinic
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0
 * @version  1.7.0
 */





/**
 * Requirements check
 */

  if ( ! is_active_sidebar( 'footer' ) ) {
    return;
  }



/**
 * Helper variables
 */

  $widgets_columns = absint( Polyclinic_Theme_Framework::get_theme_mod( 'layout_footer_columns' ) );

  if ( empty( $widgets_columns ) ) {
    $widgets_columns = absint( apply_filters( 'wmhook_polyclinic_widgets_columns', 4, 'footer' ) );
  }



/**
 * Output
 */

  ?>

  <div class="site-footer-area footer-area-footer-widgets">

    <div class="footer-widgets-inner site-footer-area-inner">

      <aside id="footer-widgets" class="widget-area footer-widgets columns-<?php echo esc_attr( $widgets_columns ); ?>" aria-labelledby="sidebar-footer-label">

        <?php dynamic_sidebar( 'footer' ); ?>

      </aside>

    </div>

  </div>

