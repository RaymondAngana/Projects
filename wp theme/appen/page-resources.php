<?php get_header();?>
    <div class="x-main full" role="main">
        <article id="post-<?php the_ID();?>" <?php post_class();?>>

				<?php while (have_posts()): the_post();?>
					<?php
					$sub_heading = get_field('sub_heading');
					$featured_section = get_field('featured_section');
					$posts_section = get_field('posts_section');
					?>
                    <section class="appen-hero resourses-hero">
                        <div class="appen-wrap">
	                        <?php get_blog_breadcrumbs();?>
                            <h1><?php the_title();?></h1>
	                        <?php
							if ($sub_heading) {
								echo '<p class="sub-heading">' . $sub_heading . '</p>';
							}
							?>
                        </div>
                        <div class="appen-hero__decor">
                            <span class="appen-hero__decor-wrap"><img src="<?php echo get_stylesheet_directory_uri() . '/static/dist/images/red-dots.png' ?>" alt=""></span>
                        </div>
                        <?php get_template_part( 'templates/resources_filter_menu' ); ?>
                    </section>
                	<?php
                		$args = array(
                			'post_type' => 'post',
                			'posts_per_page' => 12,
                			'post_status' => 'publish'
                		);
                		$the_query = new WP_Query( $args );
						if ( $the_query->have_posts() ) :
                	?>
                    <div class="resourses__cards-wrap search-result data_scroll_ajax"  data-limit="12" data-offset="1">
	                    <section class="resourses__cards">
		                    <div class="appen-wrap">
		                        <h2 class="filtered-title"><span>Explore All</span> Resources</h2>
		                        <!-- <div class="search-meta">
				            		Sort by 
				            		<div class="search-meta-wrap">
				            			<select name="search_sort">
					            			<option>Select</option>
					            			<option value="roles">Role</option>
					            			<option value="industries">Industries</option>
					            			<option value="content-types">Content Types</option>
				            			</select>
				            		</div>
				            		<span>Showing all <span class="result-count"><?php echo $the_query->found_posts; ?></span> results</span>
				            	</div> -->
		                        <div class="swiper-container js-resourse-slider">
		                            <div class="resourses__featured-list resourses__featured-list--not-slider">
		                                <?php 
										/*
										while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
		                                	<?php
		                                		$category = get_the_category();

												if ( class_exists('WPSEO_Primary_Term') ) {

													$wpseo_primary_term = new WPSEO_Primary_Term( 'category', get_the_id() );
													$wpseo_primary_term = $wpseo_primary_term->get_primary_term();
													$term = get_term( $wpseo_primary_term );

											     	if ( is_wp_error( $term ) ) {

												          $category = $category[0]->slug;

											     	} else {

												          $category_id = $term->term_id;
												          $category_term = get_category($category_id);
												          $category = $term->slug;

												     }

												} else {

												     $category = $category[0]->slug;

												}

		                                		$is_webinars = false;
		                                		if ( $category == 'webinars' ) {
								                    $cards_classes = ' resourses__cards--big resourses__cards--not-slider';
								                    $is_webinars = true;
								                }
								                global $post;
								                if ( $is_webinars ) {
								                	get_the_webinar_cards_html( $post, true );
								                } else { 
								                	get_the_post_cards_html( $post, true );
								                }
		                                	?>
	                                	<?php endwhile; 
										*/ ?>
		                            </div>
		                        </div>
		                    </div>
		                </section>
                    </div>
					<div class="ajax_load_posts">
						<div class="default_load_posts">
							<div class="loader"></div>
						</div>
					</div>
                <?php 
                	else:
                		_e( 'Sorry, nothing found.', 'appen' );
            		endif; 
            		wp_reset_postdata();
        		?>
				<?php endwhile;?>
        </article>
    </div>
<?php get_footer();?>