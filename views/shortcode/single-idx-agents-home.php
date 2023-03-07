<?php
  get_header('agents');  

  global $post;

  $agent_registration_key = get_post_meta($post->ID, '_flex_agent_registration_key', true);
  $agent_slugname = $post->post_name;
  $agent_permalink = implode('/' , [ site_url(), $agent_slugname ]);

  // Agent Information
  $agent_info = wp_remote_get(sprintf('%s/crm/agents/info/%s', FLEX_IDX_BASE_URL, $agent_registration_key), ['timeout' => 60]);
  $agent_info = (is_wp_error($agent_info)) ? [] : wp_remote_retrieve_body($agent_info);

  if ( ! empty($agent_info) ) {
    $agent_info = json_decode($agent_info, true);
  }

  // Homepage Banner

  # values: [2 = video, 1 = gallery]
  $agent_home_page_banner_type = $agent_info['info']['agent_home_page_banner_type'];
  $agent_home_page_banner_title = $agent_info['info']['agent_home_page_banner_title'];
  $agent_home_page_banner_sub_title = $agent_info['info']['agent_home_page_banner_sub_title'];
  $agent_home_page_banner_path_video = $agent_info['info']['agent_home_page_banner_path_video'];
  $agent_home_page_banner_gallery = $agent_info['info']['agent_home_page_banner_gallery'];

  /* DECLARAMOS LA VARIABLE GENERAL PARA LAS IMAGENES TEMPORALES */
  $temporalImage = 'https://idxboost-spw-assets.idxboost.us/photos/blank.png';
  
  /**
  * Aqui podemos declarar variables que nos ayuden a mejorar el performance al momento de cargar el site en un dispositivo mobil
  * lo que debemos hacer es usar la validacion interna de wordpress "wp_is_mobile" y asignamos nuestras condiciones, podemos generar
  * todas las variables que necesitemos segun nuestro proyecto Ejemplo:
  * if (wp_is_mobile()) {
  *   $videoWelcome = "url de mi video principal en una resolución ideal para ser vista en celualres/tablets";
  *   $imagenWelcome = "url de mi imagen principal en una resolución ideal para ser vista en celualres/tablets";
  * }else{
  *   $videoWelcome = "url de mi video principal en una buena resolución para ser visto en PC";
  *   $imagenWelcome = "url de mi imagen principal en una buena resolución para ser vista en PC";
  * }
  **/

  // if (wp_is_mobile()) {
  //   $imagenWelcome = get_template_directory_uri()."/images/home/slide1min.png";
  // }else{
  //   $imagenWelcome = get_template_directory_uri()."/images/home/slide1.png";
  // }

  $imagenWelcome = 'https://idxboost-spw-assets.idxboost.us/photos/slide.png';

?>

<style>
  body { padding-top: 0 !important; }
</style>

<main class="ms-agent-pg">
  <section class="ms-section ms-animate" id="welcome">

    <?php 
      if ( 
        ! empty($agent_home_page_banner_gallery) && 
        $agent_home_page_banner_type == 1 
      ) { 
    ?>

      <div class="ms-slider">
        <div class="ms-slider-home" id="sliderHome">
          <?php 
            foreach ($agent_home_page_banner_gallery as $item) {
              echo "<img class='img-slider gs-lazy' data-lazy=".$item['url']." alt=".$item['altag']." title=".$item['title'].">";
            }
          ?>
        </div>
      </div>

    <?php
      } elseif (
        ! empty($agent_home_page_banner_path_video) &&
        $agent_home_page_banner_type == 2
      ) {
    ?>

      <div class="ms-slider" data-real-type="agentVideo"
        data-title="<?php echo $agent_home_page_banner_title; ?>"
        data-img="<?php echo $agent_home_page_banner_path_video; ?>" 
        data-video-autoplay="true" data-video-mute="true">
      </div>

    <?php } else { ?>

      <div class="ms-slider">
        <img class="ms-layer ms-lazy" alt="BRG" 
          data-real-type="image" 
          data-img="<?php echo $imagenWelcome; ?>" 
          src="<?php echo $temporalImage; ?>">
      </div>
      
    <?php } ?>
    
    <h1 class="ms-title"><?php echo $agent_info['info']['agent_home_page_banner_title']; ?></h1>
    <h2 class="ms-subtitle"><?php echo $agent_info['info']['agent_home_page_banner_sub_title']; ?></h2>
    <?php echo do_shortcode('[flex_autocomplete]'); ?>
    
    <ul class="ms-wrap-btn" id="cbtn2">
      <li>
        <a href="<?php echo $agent_permalink; ?>/services/i-want-to-buy" 
          title="I need assistance buying">
          I need assistance buying
        </a>
      </li>
      <li>
        <a href="<?php echo $agent_permalink; ?>/services/i-want-to-sell" 
          title="I’m looking to sell my property">
          I’m looking to sell my property
        </a>
      </li>
    </ul>

    <button class="ms-next-step" data-step="#featured-properties" aria-label="Skip to main content">
      <span>Skip to content</span>
    </button>

  </section>
</main>

<section class="ms-section ms-animate exclusive_listings" id="featured-properties">
  <div class="titles">
    <h2>Featured Listings</h2>
  </div>

  <?php echo do_shortcode(sprintf('[flex_idx_filter id="%s" type="2" slider_item="4" limit="16" mode="slider" registration_key="%s"]', '', $agent_registration_key)); ?>
  
  <div class="text_center">
    <a class="clidxboost-btn-link" href="<?php echo $agent_permalink; ?>/featured-properties" title="View All Listings">
      <span>View All Listings</span>
    </a>
  </div>
</section>

<section class="agent_info ms-animate" id="agentInfo">
  <div class="container">

    <div class="col left">
      <?php if ( ! empty($agent_info['info']['agent_photo_file']) ): ?>
        <img alt="<?php echo implode(' ', [ $agent_info['info']['first_name'], $agent_info['info']['last_name'] ]); ?>"
          data-real-type="image" 
          data-img="<?php echo $agent_info['info']['agent_photo_file']; ?>" 
          src="<?php echo $agent_info['info']['agent_photo_file']; ?>">
      <?php else: ?>
        <img alt="<?php echo implode(' ', [ $agent_info['info']['first_name'], $agent_info['info']['last_name'] ]); ?>"
          data-real-type="image" 
          data-img="<?php echo get_template_directory_uri(); ?>/images/agent/agent.jpg" 
          src="<?php echo $temporalImage; ?>">
      <?php endif; ?>
    </div>

    <div class="col right">
      <h2><?php echo implode(' ', [ $agent_info['info']['first_name'], $agent_info['info']['last_name'] ]); ?></h2>
      <small><?php echo $agent_info['info']['agent_title']; ?></small>
      
      <ul class="infs">
        <?php 
          if ( 
            isset($agent_info['info']['office_info']) && 
            ! empty($agent_info['info']['office_info']['phone']) 
          ): 
        ?>
        <li>Office: <?php echo $agent_info['info']['office_info']['phone']; ?></li>
        <?php endif; ?>
        <li>Cell: <?php echo $agent_info['info']['contact_phone']; ?></li>
        <li>Email: <?php echo $agent_info['info']['contact_email']; ?></li>
      </ul>

      <div><?php echo nl2br(strip_tags($agent_info['info']['bio'])); ?></div>

      <a class="clidxboost-btn-link" href="<?php echo $agent_permalink; ?>/about" title="Learn More">
        <span>Learn More</span>
      </a>
    </div>

  </div>
</section>

<section class="need_help ms-animate" id="agentForm">
  <div class="container">

    <div class="titles">
      <h2>Need help? We are here for you.</h2>
      <p>Please complete the form below</p>
    </div>

    <?php echo do_shortcode(sprintf('[flex_idx_contact_form id_form="need_help" map="hide" registration_key="%s"]', $agent_registration_key)); ?>

  </div>
</section>

<?php get_footer('agents');?>

<script>
  (function($) {
    $(document).on("ready",function() {
      $("#need_help input[name='ib_tags']").val("Need help? - Agent Form");
    }); 
    $(".flex-content-form .pt-name .medium").attr('placeholder', 'Name*');
    $(".flex-content-form .pt-lname .medium").attr('placeholder', 'Last Name*');
    $(".flex-content-form .pt-email .medium").attr('placeholder', 'Email*');
    $(".flex-content-form .pt-phone .medium").attr('placeholder', 'Phone');
    $(".flex-content-form .textarea").attr('placeholder', 'Comment');

    // Slider for Home section
    var $sliderHome = $('#sliderHome');

    if ($sliderHome.length) {
      $sliderHome.greatSlider({
        type: 'fade',
        nav: false,
        bullets: false,
        lazyLoad: true,
        autoplay: true,
        autoplaySpeed: 3000
      });
    }
  })(jQuery);
</script>