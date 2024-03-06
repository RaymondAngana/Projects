<!-- <?php
if ( wp_get_nav_menu_object( 'resources-filter' ) ) : ?>
	<div class="resourses-filter">
		<div class="resourses-filter__top">
			<button class="resourses-filter__drop js-filter-drop"><?php _e( 'Filter By Category', 'appen' ); ?></button>
			<?php if ( is_category() ) : ?>
                <div class="resourses-filter__active" style="display: block;">
                	<span data-category="<?php echo get_queried_object()->slug; ?>" class=""><?php single_cat_title(); ?></span>
                </div>
			<?php else : ?>
				<div class="resourses-filter__active"></div>
			<?php endif; ?>
		</div>
		<?php
		/*echo wp_nav_menu( [
			'menu'            => 'resources-filter',
			'container_class' => 'menu-resources-filter-container js-filter-content',
			'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s<a class="js-reset-filter">' . __( 'Reset Filter', 'appen' ) . '</a></ul>',
			'walker' 	   	  => new Filter_Nav_Menu()
		] );*/
		?>
	</div>
<?php endif; ?> -->

<?php if ( wp_get_nav_menu_object( 'resources-filter' ) ) : ?>
	<div class="resourses-filter">
		<div class="resourses-filter__top">
			<button class="resourses-filter__drop js-filter-drop"><?php _e( 'Filter By:', 'appen' ); ?></button>
			<!-- <div class="resourses-filter__active" style="display: block;"></div> -->
      		<div class="resourses-filter__search_bar"><?php if ( is_category() ) { ?><span class="category" data-category="<?php echo get_queried_object()->slug; ?>" data-name="<?php single_cat_title(); ?>"><?php single_cat_title(); ?></span><?php } ?></div>
			<div class="custom_search_outer">
	          <form class="custom_searc_section" method="get" action="">
              		<input type="text" class="frm_search" name="s" placeholder="Search" style="outline: none;" autocomplete="off" value="">
              		<input type="hidden" class="frm_search_holder" name="frm_search_holder" value="">
              		<button type="submit" class="btn btn-success">
                  		<i class="la la-search"></i>
              		</button>
	          </form>
	        </div>
		</div>
		<?php
		echo wp_nav_menu( [
			'menu'            => 'resources-filter',
			'container_class' => 'menu-resources-filter-container js-filter-content',
			'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s<a class="js-reset-filter">' . __( 'Reset Filter', 'appen' ) . '</a></ul>',
			'walker' 	   	  => new Filter_Nav_Menu()
		] );
		?>
	</div>
<?php endif; ?>