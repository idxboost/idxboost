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

$agent_avatar_image = (string) trim($agent_info['info']['agent_avatar_image']);

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
?>

    <main id="flex-filters-theme">
        <?php /*
        <div class="gwr gwr-breadcrumb">
            <div class="flex-breadcrumb">
                <ol>
                    // <?php <li><a href="<?php echo $flex_idx_info["website_url"]; ?>" title="Home"><?php echo __("Home", IDXBOOST_DOMAIN_THEME_LANG); ?></a></li> ?>
                    <li><a href="<?php echo get_permalink(get_the_ID()); ?>" title="Home"><?php echo __("Home", IDXBOOST_DOMAIN_THEME_LANG); ?></a></li>
                    <li><?php echo __(the_title(), IDXBOOST_DOMAIN_THEME_LANG); ?></li>
                </ol>
            </div>
        </div> */ ?>

        <?php echo do_shortcode(sprintf('[flex_idx_property_detail registration_key="%s"]', $agent_registration_key)); ?>
    </main>
<?php
endwhile;
get_footer('agents');
?>