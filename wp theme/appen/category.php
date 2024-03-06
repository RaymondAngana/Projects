<?php
$term                  = get_queried_object();
// $type_featured_section = get_field( 'type_featured_section', $term );
if ( in_array( $term->slug, [
	'content-types',
	'industries',
	'roles',
	'topics',
	'ai-machine-learning',
	'annual',
	'industry-insights',
	'life-at-appen',
	'machine-learning',
	'presentations',
] ) ) {
	wp_redirect( site_url( '/resources/' ) );
	exit();
}

get_header(); ?>

    <div class="x-main full" role="main">
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

        	<?php
        		$resources_page = get_page_by_path( 'resources' );

				$sub_heading      = get_field( 'sub_heading', $resources_page->ID );
				$featured_section = get_field( 'featured_section', $resources_page->ID );
                $posts_section    = get_field('posts_section', $resources_page->ID );
			?>

			<section class="appen-hero resourses-hero">
                <div class="appen-wrap">
                    <?php get_blog_breadcrumbs();?>
                    <h1><?php echo get_the_title( $resources_page->ID ); ?></h1>
                    <?php
                    if ( $sub_heading ) {
                        echo '<p class="sub-heading">' . $sub_heading . '</p>';
                    }
                    ?>
                </div>
                <div class="appen-hero__decor">
                    <span class="appen-hero__decor-wrap"><img src="<?php echo get_stylesheet_directory_uri() . '/static/dist/images/red-dots.png' ?>" alt=""></span>
                </div>
                <?php get_template_part( 'templates/resources_filter_menu' ); ?>
            </section>

            <?php $featured_posts_html = return_featured_posts_html( [ $term->slug ] ); ?>
            <?php if ( !empty( $featured_posts_html ) ) : ?>
	            <section class="resourses__featured">
					<div class="appen-wrap">
	            		<?php echo $featured_posts_html; ?>
	            	</div>
	            </section>
	        <?php endif; ?>

            <?php echo return_all_resources_html( [ [ $term->slug ] ] ); ?>

        </article>
    </div>
<?php get_footer(); ?>