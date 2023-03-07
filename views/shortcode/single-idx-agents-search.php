<?php
get_header('agents');

global $post;

$agent_registration_key = get_post_meta($post->ID, '_flex_agent_registration_key', true);
$agent_slugname = $post->post_name;
$agent_permalink = implode('/' , [ site_url(), $agent_slugname ]);

// Agent Information
$agent_info = wp_remote_get(sprintf('%s/crm/agents/info/%s', FLEX_IDX_BASE_URL, $agent_registration_key), ['timeout' => 60]);
$agent_info = (is_wp_error($agent_info)) ? [] : wp_remote_retrieve_body($agent_info);

if (!empty($agent_info)) {
    $agent_info = json_decode($agent_info, true);
}

$agent_avatar_image = (string) trim($agent_info['info']['agent_avatar_image']);

// var_dump($agent_info);
// exit;

if (!empty($agent_info['info']['agent_avatar_image'])) {
?>
<style>
  body {
    padding-top: 80px;
  }
  
  .fixed-active .fixed-box.ib-filter-container {
    top: 80px;
  }

  @media screen and (min-width: 1024px) {
    body {
      padding-top: 90px;
    }

    .fixed-active .fixed-box.ib-filter-container {
      top: 90px;
    }
  }
</style>
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

// $custom_fields = get_post_custom(); $txtsubtitle=$custom_fields['txtsubtitle'][0];
// $post_thumbnail_id = get_post_thumbnail_id(get_the_id());
// $post_thumbnail_url = wp_get_attachment_url($post_thumbnail_id);  
// if (empty( get_theme_mod( 'idx_txt_text_welcome_about_first' ) ))  $idx_txt_text_welcome_about_first  = ''; else  $idx_txt_text_welcome_about_first  = get_theme_mod( 'idx_txt_text_welcome_about_first' );
// if (empty( get_theme_mod( 'idx_txt_link_welcome_about_firts' ) ))  $idx_txt_link_welcome_about_firts  = ''; else  $idx_txt_link_welcome_about_firts  = get_theme_mod( 'idx_txt_link_welcome_about_firts' );

// if (empty( get_theme_mod( 'idx_txt_text_welcome_about_second' ) ))  $idx_txt_text_welcome_about_second  = ''; else  $idx_txt_text_welcome_about_second  = get_theme_mod( 'idx_txt_text_welcome_about_second' );
// if (empty( get_theme_mod( 'idx_txt_link_welcome_about_second' ) ))  $idx_txt_link_welcome_about_second  = ''; else  $idx_txt_link_welcome_about_second  = get_theme_mod( 'idx_txt_link_welcome_about_second' );

while ( have_posts() ) : the_post();
  echo do_shortcode(sprintf('[ib_search registration_key="%s"]', $agent_registration_key));
?>
    <main id="flex-about-theme">
      <?php /*
      <div class="gwr gwr-breadcrumb">
        <nav class="flex-breadcrumb" aria-label="breadcrumb">
          <ol>
            <li><a href="<?php echo site_url(); ?>" title="Home">Home</a></li>
            <li aria-current="page"><?php the_title() ?></li>
          </ol>
        </nav>
      </div>
      */ ?>

      <?php /*
      <div class="gwr c-flex intro-about">
        <article class="flex-block-description">
          <h2 class="title-block"><?php the_title(); ?> </h2>
          <?php the_content(); ?>
        </article>
        <img src="<?php echo $post_thumbnail_url; ?>" title="<?php the_title(); ?>" alt="<?php the_title(); ?>">
      </div> */ ?>
    </main>
<?php endwhile; get_footer('agents'); ?> 