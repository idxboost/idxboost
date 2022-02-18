<?php
get_header('agents');

global $flex_idx_info;

$flex_theme_options = get_option('theme_mods_flexidx');
$post_thumbnail_id = get_post_thumbnail_id(get_the_id());
$post_thumbnail_url = wp_get_attachment_url($post_thumbnail_id);
$idx_contact_phone = isset($flex_idx_info['agent']['agent_contact_phone_number']) ? sanitize_text_field($flex_idx_info['agent']['agent_contact_phone_number']) : '';
$idx_contact_email = isset($flex_idx_info['agent']['agent_contact_email_address']) ? sanitize_text_field($flex_idx_info['agent']['agent_contact_email_address']) : '';
$idx_contact_address = isset($flex_idx_info['agent']['agent_address']) ? sanitize_text_field($flex_idx_info['agent']['agent_address']) : '';
$idx_contact_address2 = isset($flex_idx_info['agent']['agent_address2']) ? sanitize_text_field($flex_idx_info['agent']['agent_address2']) : '';
$idx_contact_zip_code = isset($flex_idx_info['agent']['agent_zip_code']) ? sanitize_text_field($flex_idx_info['agent']['agent_zip_code']) : '';
$idx_contact_state = isset($flex_idx_info['agent']['agent_state']) ? sanitize_text_field($flex_idx_info['agent']['agent_state']) : '';
$idx_contact_city = isset($flex_idx_info['agent']['agent_city']) ? sanitize_text_field($flex_idx_info['agent']['agent_city']) : '';
$agent_first_name = isset($flex_idx_info['agent']['agent_first_name']) ? sanitize_text_field($flex_idx_info['agent']['agent_first_name']) : '';
$agent_last_name = isset($flex_idx_info['agent']['agent_last_name']) ? sanitize_text_field($flex_idx_info['agent']['agent_last_name']) : '';
$idx_contact_lat = isset($flex_idx_info['agent']['agent_address_lat']) ? sanitize_text_field($flex_idx_info['agent']['agent_address_lat']) : '';
$idx_contact_lng = isset($flex_idx_info['agent']['agent_address_lng']) ? sanitize_text_field($flex_idx_info['agent']['agent_address_lng']) : '';

$idx_contact_address = $idx_contact_address.' '.$idx_contact_address2.', '.$idx_contact_city.', '.$idx_contact_state.' '.$idx_contact_zip_code;

if ((empty($idx_contact_lat )) && (empty($idx_contact_lng ))){
$chlatlong = curl_init();
curl_setopt($chlatlong, CURLOPT_URL, 'https://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($idx_contact_address).'&key='.$flex_idx_info["agent"]["google_maps_api_key"]);
curl_setopt($chlatlong, CURLOPT_RETURNTRANSFER, true);
curl_setopt($chlatlong, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($chlatlong, CURLOPT_FRESH_CONNECT, true);
curl_setopt($chlatlong, CURLOPT_VERBOSE, true);
$outputlatlong = curl_exec($chlatlong);
curl_close($chlatlong);

  $outtemporali=json_decode($outputlatlong,true);
  if ($outtemporali['status']=='OK') {
   foreach ($outtemporali['results'] as $keygeom => $valuegeome) {
     $idx_contact_lat=$valuegeome['geometry']['location']['lat'];
     $idx_contact_lng=$valuegeome['geometry']['location']['lng'];
   }
  }
}

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

?>
<style>
body {padding-top:0 !important;}

@media screen and (min-width: 1024px){
  .flex-wrap-contact {
    min-height: calc(100vh - 90px) !important;
  }
}
</style>
<?php 

while ( have_posts() ) : the_post(); ?>

<main id="flex-contact-theme" class="ms-agent-pg">

<?php /*
  <!-- Breadcrumb -->
  <div class="gwr gwr-breadcrumb">
    <nav class="flex-breadcrumb" aria-label="breadcrumb">
      <ol>
        <li><a href="<?php echo site_url(); ?>" title="Home">Home</a></li>
        <li aria-current="page">Contact Us</li>
      </ol>
    </nav>
  </div>
*/ ?>
  <!-- Wrap contact -->
  <div class="flex-wrap-contact">
    
    <!-- CONPANY -->
    <div class="flex-wrap-company">
      <div class="flex-wrap-company-information">
        <h2><?php the_title(); ?></h2>
        <ul>
          <li>
            <a class="phone" href="tel:<?php echo preg_replace('/[^\d+]/', '', $agent_info['info']['contact_phone']); ?>"><?php echo $agent_info['info']['contact_phone']; ?></a>
          </li>
          <li>
            <a class="email" href="mailto:<?php echo $agent_info['info']['contact_email']; ?>"><?php echo $agent_info['info']['contact_email']; ?></a>
          </li>
          <li>
            <a href="javascript:void(0)" class="mapa"><?php echo $idx_contact_address; ?></a>
          </li>
        </ul>
      </div>
      <div id="flex-wrap-contact-map">
        <div id="map" data-lat="<?php echo $idx_contact_lat; ?>" data-lng="<?php echo $idx_contact_lng; ?>"></div>
      </div>
    </div>
    <!-- FORM CONTACT -->
    <div class="flex-wrap-contact-form">
      <?php echo do_shortcode(sprintf('[flex_idx_contact_form registration_key="%s"]', $agent_registration_key)); ?>
      <input type="hidden" name="idx_contact_email_temp" class="idx_contact_email_temp" value="<?php echo $idx_contact_email; ?>">
    </div>
  </div>
</main>

<?php endwhile; ?> 
<?php get_footer('agents'); ?> 