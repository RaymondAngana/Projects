<?php
if(have_posts()){
	while (have_posts()) {
the_post();
$url = get_the_content();
if(empty($url)){
 $url=get_site_url();
}
if( get_field('announcement_pdf_download_link') ) {
	$url = get_field('announcement_pdf_download_link')['url'];
}
echo $url;
wp_redirect( $url );
die();
}
}