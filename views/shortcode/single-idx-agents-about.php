<?php
get_header('agents');

// $custom_fields = get_post_custom(); $txtsubtitle=$custom_fields['txtsubtitle'][0];
// $post_thumbnail_id = get_post_thumbnail_id(get_the_id());
// $post_thumbnail_url = wp_get_attachment_url($post_thumbnail_id);  
// if (empty( get_theme_mod( 'idx_txt_text_welcome_about_first' ) ))  $idx_txt_text_welcome_about_first  = ''; else  $idx_txt_text_welcome_about_first  = get_theme_mod( 'idx_txt_text_welcome_about_first' );
// if (empty( get_theme_mod( 'idx_txt_link_welcome_about_firts' ) ))  $idx_txt_link_welcome_about_firts  = ''; else  $idx_txt_link_welcome_about_firts  = get_theme_mod( 'idx_txt_link_welcome_about_firts' );

// if (empty( get_theme_mod( 'idx_txt_text_welcome_about_second' ) ))  $idx_txt_text_welcome_about_second  = ''; else  $idx_txt_text_welcome_about_second  = get_theme_mod( 'idx_txt_text_welcome_about_second' );
// if (empty( get_theme_mod( 'idx_txt_link_welcome_about_second' ) ))  $idx_txt_link_welcome_about_second  = ''; else  $idx_txt_link_welcome_about_second  = get_theme_mod( 'idx_txt_link_welcome_about_second' );

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

while ( have_posts() ) : the_post(); ?>

  <style>
    body { padding-top: 80px; }
    
    @media screen and (min-width: 1024px) {
      body { padding-top: 90px; }
    }
  </style>

  <main id="flex-about-theme">
    <?php /*
      <div class="gwr gwr-breadcrumb">
        <nav class="flex-breadcrumb" aria-label="breadcrumb">
          <ol>
            <li><a href="<?php echo site_url(); ?>" title="Home">Home</a></li>
            <li aria-current="page"><?php the_title() ?></li>
          </ol>
        </nav>
      </div> */ ?>

      <div class="gwr c-flex intro-about">
        <article class="flex-block-description">
          <h2 class="title-block">
            <?php echo implode(' ', [ $agent_info['info']['first_name'], $agent_info['info']['last_name'] ]); ?>
          </h2>
          <div><?php echo nl2br(strip_tags($agent_info['info']['bio'])); ?></div>
        </article>

        <?php if (!empty($agent_info['info']['agent_photo_file'])): ?>
          <img src="<?php echo $agent_info['info']['agent_photo_file']; ?>" title="<?php the_title(); ?>" alt="<?php echo implode(' ', [ $agent_info['info']['first_name'], $agent_info['info']['last_name'] ]); ?>">
        <?php else: ?>
          <img src="https://idxboost-spw-assets.idxboost.us/photos/avatar.jpg" title="<?php echo implode(' ', [ $agent_info['info']['first_name'], $agent_info['info']['last_name'] ]); ?>" alt="<?php the_title(); ?>">
        <?php endif; ?>
      </div>

    </main>

<?php endwhile; get_footer('agents'); ?> 