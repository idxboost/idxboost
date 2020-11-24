<?php if ($response['status']) { ?>
<?php $companyName=$response['data']['companyName']; 
$websiteDomain=$response['data']['websiteDomain']; 
$countryState=$response['data']['countryState']; 
$state=$response['data']['state']; 

$idx_contact_phone = isset($flex_idx_info['agent']['agent_contact_phone_number']) ? sanitize_text_field($flex_idx_info['agent']['agent_contact_phone_number']) : '';
$idx_contact_email = isset($flex_idx_info['agent']['agent_contact_email_address']) ? sanitize_text_field($flex_idx_info['agent']['agent_contact_email_address']) : '';

?>


<div class="ms-access-content-terms">
    <h1><?php echo __('Accesibility', IDXBOOST_DOMAIN_THEME_LANG); ?></h1>
    <p>
      <strong><?php echo $companyName; ?></strong><?php echo __(' is committed to providing an accessible website. If you have difficulty accessing content, have difficulty viewing a file on the website, or notice any accessibility problems, please contact us to ', IDXBOOST_DOMAIN_THEME_LANG); ?><strong>( <a href="mailto:<?php echo $idx_contact_email; ?>"><?php echo $idx_contact_email; ?></a> <a href="tel:<?php echo $idx_contact_phone; ?>"><?php echo $idx_contact_phone; ?></a> )</strong>
        <?php echo __('to specify the nature of the accessibility issue and any assistive technology you use. NAR will strive to provide the content you need in the format you require.', IDXBOOST_DOMAIN_THEME_LANG); ?>
    </p>
    <p>
      <strong><?php echo $companyName; ?></strong> <?php echo __('welcomes your suggestions and comments about improving ongoing efforts to increase the accessibility of this website.', IDXBOOST_DOMAIN_THEME_LANG); ?>
    </p>

    <h2><?php echo __('Web Accessibility Help', IDXBOOST_DOMAIN_THEME_LANG); ?></h2>
    <p>
        <?php echo __('There are actions you can take to adjust your web browser to make your web experience more accessible.', IDXBOOST_DOMAIN_THEME_LANG); ?>
    </p>

    <div class="ms-access-accordion">

      <div class="accordion-item">
        <a class="accordion-title"><?php echo __('I am blind or can\'t see very well', IDXBOOST_DOMAIN_THEME_LANG); ?></a>
        <div class="ms-access-content">
          <p><?php echo __('If you have trouble seeing web pages, the US Social Security Administration offers these tips (link is external) for optimizing your computer and browser to improve your online experience.', IDXBOOST_DOMAIN_THEME_LANG); ?></p>
          <ul>
          <li><a href="https://www.ssa.gov/accessibility/browseAloud.html" target="_blank"><?php echo __('Use your computer to read web pages out loud', IDXBOOST_DOMAIN_THEME_LANG); ?></a></li>
          <li><a href="https://www.ssa.gov/accessibility/keyboard_nav.html" target="_blank"><?php echo __('Use the keyboard to navigate screens', IDXBOOST_DOMAIN_THEME_LANG); ?></a></li>
          <li><a href="https://www.ssa.gov/accessibility/textsize.html" target="_blank"><?php echo __('Increase text size', IDXBOOST_DOMAIN_THEME_LANG); ?></a></li>
          <li><a href="https://www.ssa.gov/accessibility/magnifyscreen.html" target="_blank"><?php echo __('Magnify your screen', IDXBOOST_DOMAIN_THEME_LANG); ?></a></li>
          <li><a href="https://www.ssa.gov/accessibility/changecolors.html" target="_blank"><?php echo __('Change background and text colors', IDXBOOST_DOMAIN_THEME_LANG); ?></a></li>
          <li><a href="https://www.ssa.gov/accessibility/mousepointer.html" target="_blank"><?php echo __('Make your mouse pointer more visible', IDXBOOST_DOMAIN_THEME_LANG); ?></a></li>
          </ul>
        </div>
      </div>

      <div class="accordion-item">
        <a class="accordion-title"><?php echo __('I find a keyboard or mouse hard to use', IDXBOOST_DOMAIN_THEME_LANG); ?></a>
        <div class="ms-access-content">
          <p><?php echo __('If you find a keyboard or mouse difficult to use, speech recognition software such as', IDXBOOST_DOMAIN_THEME_LANG); ?> <a href="<?php echo $websiteDomain; ?>" target="_blank"><?php echo $websiteDomain; ?></a> <?php echo __('may help you navigate web pages and online services. This software allows the user to move focus around a web page or application screen through voice controls.', IDXBOOST_DOMAIN_THEME_LANG); ?></p>
        </div>
      </div>

      <div class="accordion-item">
        <a class="accordion-title"><?php echo __('I am deaf or hard of hearing', IDXBOOST_DOMAIN_THEME_LANG); ?></a>
        <div class="ms-access-content">
          <p><?php echo __('If you are deaf or hard of hearing, there are several accessibility features available to you.', IDXBOOST_DOMAIN_THEME_LANG); ?></p>
          <h4><?php echo __('Transcripts', IDXBOOST_DOMAIN_THEME_LANG); ?></h4>
          <p><?php echo __('A text transcript is a text equivalent of audio information that includes spoken words and non-spoken sounds such as sound effects. NAR is working on adding transcripts to all scripted video and audio content.', IDXBOOST_DOMAIN_THEME_LANG); ?></p>
          <h4><?php echo __('Captioning', IDXBOOST_DOMAIN_THEME_LANG); ?></h4>
          <p><?php echo __('A caption is transcript for the audio track of a video presentation that is synchronized with the video and audio tracks. Captions are generally rendered visually by being superimposed over the video, which benefits people who are deaf and hard-of-hearing, and anyone who cannot hear the audio (e.g., when in a crowded room). Most of NAR\'s video content includes captions.', IDXBOOST_DOMAIN_THEME_LANG); ?> <a href="https://support.google.com/youtube/answer/100078?hl=en" target="_blank"><?php echo __('Learn how to turn captioning on and off in YouTube.', IDXBOOST_DOMAIN_THEME_LANG); ?></a></p>
          <h4><?php echo __('Volume controls', IDXBOOST_DOMAIN_THEME_LANG); ?></h4>
          <p><?php echo __('Your computer, tablet, or mobile device has volume control features. Each video and audio service has its own additional volume controls. Try adjusting both your device\'s volume controls and your media players\' volume controls to optimize your listening experience.', IDXBOOST_DOMAIN_THEME_LANG); ?></p>
        </div>
      </div>

    </div>
</div>

<script type="text/javascript">
  jQuery(document).on('click', '.accordion-title', function() {
    var $item = jQuery(this);

    if ($item.hasClass('active')) {
      $item.removeClass('active');
      $item.next().removeClass('active');
    } else {
      $item.addClass('active');
      $item.next().addClass('active');
    }
  })
</script>


<?php } ?>