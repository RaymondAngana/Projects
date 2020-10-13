<?php
/**
 * Primary menu template
 *
 * Accessibility markup applied (ARIA).
 *
 * @link  http://a11yproject.com/patterns/
 *
 * @package    Polyclinic
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.1
 * @version  1.8.0
 */





?>

<nav id="site-navigation" class="main-navigation" aria-labelledby="site-navigation-label">

	<h2 class="screen-reader-text" id="site-navigation-label"><?php esc_html_e( 'Primary Menu', 'polyclinic' ); ?></h2>

	<button id="menu-toggle" class="menu-toggle" aria-controls="menu-primary" aria-expanded="false" aria-label="Menu Toggle"></button>

	<?php get_template_part( 'template-parts/menu', 'mobile' ); ?>

	<div id="site-navigation-container" class="main-navigation-container">

		<?php

		wp_nav_menu( array(
			'theme_location'  => 'primary',
			'container'       => 'div',
			'container_class' => 'menu',
			'menu_class'      => 'menu', // Fallback for pagelist
			'items_wrap'      => '<ul role="menu" id="menu-primary">%3$s<li class="menu-toggle-skip-link-container"><a href="#menu-toggle" class="menu-toggle-skip-link">' . esc_html__( 'Skip to menu toggle button', 'polyclinic' ) . '</a></li></ul>',
			'fallback_cb'     => 'polyclinic_menu_primary_fallback',
		) );

		?>

	</div>

</nav>
