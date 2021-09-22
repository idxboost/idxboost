<?php
get_header();
while ( have_posts() ) : the_post();

$flex_building_page_id = get_post_meta(get_the_ID(), '_flex_building_page_id', true);
$post_thumbnail_id = get_post_thumbnail_id(get_the_ID());
$post_thumbnail_url = wp_get_attachment_url($post_thumbnail_id);

echo do_shortcode('[flex_idx_building building_id="'.$flex_building_page_id.'"]');

// [track building view]
/*
$building_title = get_the_title(get_the_ID());
$building_event_track_endpoint = IDX_BOOST_TRACK_COLLECTION_VIEWS;

echo <<<HTML
<script>
if ("no" === __flex_g_settings.anonymous) {
setTimeout(() => {
    jQuery(function() {
        jQuery.ajax({
            type: "POST",
            url: "{$building_event_track_endpoint}",
            data: {
                "type": "lead_building_view",
                "name": "{$building_title}",
                "access_token": __flex_g_settings.accessToken,
                "lead_token": Cookies.get("ib_lead_token")
            },
            success: function(response) {
                console.dir(response);
            }
        });
    });
}, 1000 * 5);
}
</script>
HTML;
*/
// [track building view]

endwhile;
get_footer();
?>
