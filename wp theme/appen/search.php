<?php
get_header();
global $wp_query;
$total_results = $wp_query->found_posts;
if (have_posts()) {
	?>
	<div class="x-row x-container max width search-result">
		<div class="x-row-inner">
			<div class="x-col">
				<div class="page-header">
		        	<h1 class="search-page-title">
		        		Search Results for: <span class="color_red"><?php echo get_search_query(); ?></span>
		        	</h1>
		        	<!--<form method="GET" action="">
		        		<input type="hidden" name="s" value="<?php echo get_search_query(); ?>">
		            	<div class="search-meta">
		            		Sort by 
		            		<select name="search_sort">
		            			<option<?php if(isset($_GET['search_sort']) && $_GET['search_sort'] == 'date_desc') { echo ' selected="selected"'; } ?> value="date_desc">Date (Descending)</option>
		            			<option<?php if(isset($_GET['search_sort']) && $_GET['search_sort'] == 'date_asc') { echo ' selected="selected"'; } ?> value="date_asc">Date (Ascending)</option>
		            			<option<?php if(isset($_GET['search_sort']) && $_GET['search_sort'] == 'title') { echo ' selected="selected"'; } ?> value="title">Name</option>
	            			</select>
		            		<span>Showing all <?php echo $total_results; ?> results</span>
		            	</div>
		            </form>-->
		        </div>
				<?php
					while (have_posts()) {
						the_post();
						?>
						<div class="single-search-result">
							<div class="search-breadcrumb">
								<?php
									if(get_post_type() == 'post') {
										$currentID = get_the_ID();
										$category = get_the_category();

										$category_display = '';
										$category_slug = '';

										if ( class_exists('WPSEO_Primary_Term') ) {

											$wpseo_primary_term = new WPSEO_Primary_Term( 'category', get_the_id() );
											$wpseo_primary_term = $wpseo_primary_term->get_primary_term();
											$term = get_term( $wpseo_primary_term );

									     	if ( is_wp_error( $term ) ) {

										          $category_display = $category[0]->name;
										          $category_link = get_term_link($category[0]->term_id);

									     	} else {

										          $category_id = $term->term_id;
										          $category_term = get_category($category_id);
										          $category_display = $term->name;
										          $category_link = get_term_link($term->term_id);

										     }

										} else {

										     $category_display = $category[0]->name;
										     $category_link = get_term_link($category[0]->term_id);

										}
										?><a href="<?php echo $category_link; ?>"><?php echo $category_display; ?></a><?php
									} else {
										$parent = array_reverse(get_post_ancestors(get_the_ID()));
										if(!empty($parent)) {
											foreach ($parent as $pa) {
												?><a href="<?php echo get_the_permalink( $pa ); ?>"><?php echo get_the_title( $pa ); ?></a><?php
											}
										}
									}
								?>
							</div>
							<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
							<?php the_excerpt(); ?>
						</div>
						<?php
					}
				?>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		jQuery('.search-meta select').on('change', function (e) {
		    jQuery('.page-header form').submit();
		});
	</script>
<?php
} else {
	?>
	<div class="x-row x-container max width search-result">
		<div class="x-row-inner">
			<div class="x-col">
				<div class="page-header">
		        	<h1 class="search-page-title">
		        		Search Results for: <span class="color_red"><?php echo get_search_query(); ?></span>
		        	</h1>
		        	<div class="single-search-result">
			        	<h3>No results matched your search</h3>
			        </div>
		        </div>
			</div>
		</div>
	</div>
	<?php
}

?>
<!-- <style>
	.search-result .page-header {
	    margin: 6em 0 4em 0;
	}
	.search-result .color_red {
	    color: #ef4126;
	}
	.search-result h1 {
		font-size: 43px;
		font-weight: 500;
	}
	.search-result .search-meta select {
	    border: none;
	    box-shadow: none;
	    padding: 0;
	    margin: 0;
	    height: auto;
	    font-weight: inherit;
	    color: #000;
	    outline: none;
	}
	.search-result .search-meta {
	    color: #4B4F54;
	    font-weight: 500;
	}
	.search-result .search-meta span {
		color: #A2AAAD;
	}
	.search-result .single-search-result {
		margin: 50px 0;
		max-width: 670px;
	}
	.search-result .single-search-result h3 {
		font-size: 21px;
		font-weight: 500;
		margin: 5px 0 10px 0;
	}
	.search-result .single-search-result p {
		font-size: 15px;
		color: #000000;
		margin-bottom: 10px;
	}
	.search-result .single-search-result .more-link {
	    font-size: 13px;
	    font-weight: 500;
	    color: #000000;
	}
	.search-result .single-search-result .more-link:after {
	    content: '';
	    display: inline-block;
	    width: 10px;
		height: 12px;
	    background-position: center;
	    background-repeat: no-repeat;
	    background-size: contain;
	    background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg width='8' height='14' viewBox='0 0 8 14' fill='none' xmlns='http://www.w3.org/2000/svg'%3e%3cmask id='path-1-inside-1' fill='white'%3e%3cpath fill-rule='evenodd' clip-rule='evenodd' d='M0.666829 13.3637L7.3335 7.00011L0.666829 0.636475'/%3e%3c/mask%3e%3cpath d='M7.3335 7.00011L8.71445 8.44682L10.23 7.00011L8.71445 5.5534L7.3335 7.00011ZM2.04778 14.8105L8.71445 8.44682L5.95254 5.5534L-0.714122 11.917L2.04778 14.8105ZM8.71445 5.5534L2.04778 -0.810237L-0.714122 2.08319L5.95254 8.44682L8.71445 5.5534Z' fill='%23EF4126' mask='url(%23path-1-inside-1)'/%3e%3c/svg%3e ");
	    margin-left: 5px;
		vertical-align: middle;
	}
	.search-result .search-breadcrumb {
	    font-weight: 500;
	    font-size: 14px;
	}
	.search-result .search-breadcrumb a {
	    color: #A2AAAD;
	    display: inline-block;
	    margin-right: 10px;
	}
	.search-result .search-breadcrumb a:not(:last-child):after {
	    content: '';
	    display: inline-block;
	    width: 10px;
	    height: 8px;
	    background-position: center;
	    background-repeat: no-repeat;
	    background-size: contain;
	    background-image: url("data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI1LjA2MSIgaGVpZ2h0PSI4LjcwNyIgdmlld0JveD0iMCAwIDUuMDYxIDguNzA3Ij4NCiAgPHBhdGggaWQ9IlBhdGhfM19Db3B5IiBkYXRhLW5hbWU9IlBhdGggMyBDb3B5IiBkPSJNMCwwLDQsNCwwLDgiIHRyYW5zZm9ybT0idHJhbnNsYXRlKDAuMzU0IDAuMzU0KSIgZmlsbD0ibm9uZSIgc3Ryb2tlPSIjYTdhZWIxIiBzdHJva2UtbWl0ZXJsaW1pdD0iMTAiIHN0cm9rZS13aWR0aD0iMSIvPg0KPC9zdmc+DQo=");
	    margin-left: 10px;
	    vertical-align: middle;
	}
	.search-result .search-breadcrumb a:last-child {
	    color: #EF4126;
	}
	@media screen and (max-width: 1200px) {
		.search-result {
		    padding: 0 15px;
		}
	}
	@media screen and (max-width: 992px) {
		.search-result .single-search-result {
		    margin: 20px 0;
		}
	}
</style> -->
<?php

get_footer();