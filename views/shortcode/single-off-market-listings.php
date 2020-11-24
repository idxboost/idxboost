<?php
get_header();
while ( have_posts() ) : the_post();

$flex_off_market_page_id = get_post_meta(get_the_ID(), '_flex_token_listing_page_id', true);
$post_thumbnail_id = get_post_thumbnail_id(get_the_ID());
$post_thumbnail_url = wp_get_attachment_url($post_thumbnail_id);

echo do_shortcode('[flex_idx_off_market_listing token_id="'.$flex_off_market_page_id.'"]');

endwhile;
get_footer();
?>
