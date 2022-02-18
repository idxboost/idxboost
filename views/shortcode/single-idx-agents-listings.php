<?php
get_header('agents');

global $post;

$agent_registration_key = get_post_meta($post->ID, '_flex_agent_registration_key', true);
$agent_slugname = $post->post_name;
$agent_permalink = implode('/' , [ site_url(), $agent_slugname ]);

// Agent Information
$agent_info = wp_remote_get(sprintf('%s/crm/agents/info/%s', FLEX_IDX_BASE_URL, $agent_registration_key), ['timeout' => 10]);
$agent_info = (is_wp_error($agent_info)) ? [] : wp_remote_retrieve_body($agent_info);

if (!empty($agent_info)) {
    $agent_info = json_decode($agent_info, true);
}

if (!empty($agent_info['info']['agent_avatar_image'])) {
?>
<script>
var IB_AGENT_AVATAR_IMAGE = '<?php echo (string) trim($agent_info['info']['agent_avatar_image']); ?>';
</script>
<?php
}
?>
<script>
var IB_AGENT_FULL_NAME = '<?php echo implode(' ', [ $agent_info['info']['contact_first_name'], $agent_info['info']['contact_last_name'] ]) ?>';
var IB_AGENT_PHONE_NUMBER = '<?php echo $agent_info['info']['contact_phone']; ?>';
</script>
<?php

while (have_posts()) : the_post();

// _flex_filter_page_fl => 2 (Exclusive Listings)
// _flex_filter_page_fl => 1 (Recent Sales)

// $filter_listing_type = get_post_meta($post->ID, '_flex_filter_page_fl', true);
// $filter_token_id = get_post_meta($post->ID, '_flex_filter_page_id', true);
?>
    <main id="flex-filters-theme">
      <?php echo do_shortcode(sprintf('[flex_idx_filter id="" type="%d" registration_key="%s"]', 2, $agent_registration_key)); ?>
    </main>
<?php
endwhile;
get_footer('agents');
?>