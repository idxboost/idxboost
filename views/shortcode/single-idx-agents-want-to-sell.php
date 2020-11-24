<?php
get_header('idx-agents');

global $post;

$agent_registration_key = get_post_meta($post->ID, "_flex_agent_registration_key", true);

?>

<?php if (isset($agent_registration_key) && !empty($agent_registration_key)) : ?>
  <script>
    var IB_AGENT_REGISTRATION_KEY = "<?php echo $agent_registration_key; ?>";
    //console.log(IB_AGENT_REGISTRATION_KEY);
  </script>
<?php endif; ?>


<?php
$thumb_id = get_post_thumbnail_id();
$thumb_url = wp_get_attachment_image_src($thumb_id, 'full', true);
$url_imagen = $thumb_url[0];
// overwrite
$url_imagen = 'https://testlgv2.staging.wpengine.com/wp-content/uploads/2018/09/slider.jpg';
while (have_posts()) : the_post(); ?>

  <section id="main-wrap" data-url="<?php echo $url_imagen; ?>">
    <?php echo do_shortcode('[idxboost_sellers_form registration_key="' . $agent_registration_key . '"]'); ?>
  </section>

<?php endwhile; ?>
<?php get_footer('idx-agents'); ?>
<script type="text/javascript">
  var $dataUrl = jQuery('#main-wrap').attr('data-url');
  jQuery('.ib-form-bg').attr('src', $dataUrl);
</script>