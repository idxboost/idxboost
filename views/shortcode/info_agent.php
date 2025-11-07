<?php
 if (is_array($response) && array_key_exists("success", $response) && $response["success"] &&
 	array_key_exists("data", $response) && count($response["data"]) > 0
  ) { 

  $view = !empty($_GET["view"]) ? $_GET["view"]:"listing";

 	$complete_name = $response["data"]["firstName"]." <span>".$response["data"]["lastName"]."</span>";
 	$biography = $response["data"]["biography"];
 	$avatar = $response["data"]["avatar"];
 	$email = $response["data"]["email"];
 	$phone = $response["data"]["phone"];
 	$phone_call = str_replace(str_split( '\\/:*?"<>|+-() '), '', $phone); 

 	$facebook = $response["data"]["facebook"];
 	$instagram = $response["data"]["instagram"];
 	$pinterest = $response["data"]["pinterest"];
 	$youtube = $response["data"]["youtube"];
 	$twitter = $response["data"]["twitter"];
 	$linkedin = $response["data"]["linkedin"];

  $agentMLSId = $response["data"]["agentMLSId"];
  $agentIdSold = $response["data"]["agentIdSold"];

  $officeIdListing = $response["data"]["officeIdListing"];
  $officeIdSold = $response["data"]["officeIdSold"];
?>

  <input id="agent_fname" value="<?php echo $response["data"]["firstName"]; ?>" type="hidden">
  <input id="agent_lname" value="<?php echo $response["data"]["lastName"]; ?>" type="hidden">
  <input id="agent_email" value="<?php echo $response["data"]["email"]; ?>" type="hidden">

    <section class="ms-nw-agent-detail">
      <div class="ms-nw-wrapper-section">
        <div class="ms-nw-agent-info">
          <div class="ms-nw-agent-picture">
            <img src="<?php echo $avatar; ?>" alt="<?php echo $response["data"]["firstName"].' '.$response["data"]["lastName"]; ?>">
          </div>
          <article class="ms-nw-agent-basic-info">
            <h1 class="ms-wr-name"><?php echo $complete_name; ?></h1>
            <h2 class="ms-wr-position"><?php echo $response["data"]["title"]; ?></h2>
            <ul class="ms-wr-contact-info">
              <li><a href="tel:+<?php echo $phone_call; ?>" class="ms-nw-phone"><i class="idx-icon-phone"></i> <?php echo $phone; ?></a></li>
              <li><a href="mailto:<?php echo $email; ?>" class="ms-nw-email"><i class="idx-icon-mail-envelope-closed"></i> <?php echo $email; ?></a></li>
            </ul>
            <ul class="ms-nw-social-media-list">
            	<?php if( !empty($instagram) ) { ?>
			<li><a href="<?php echo $instagram; ?>" class="ms-nw-social-media-item" title="Instagram"><i class="idx-icon-instagram"></i></a></li>
		<?php } ?>
          		
		<?php if( !empty($linkedin) ) { ?>
              		<li><a href="<?php echo $linkedin; ?>" class="ms-nw-social-media-item" title="Linkedin"><i class="idx-icon-linkedin2"></i></a></li>
              	<?php } ?>

              	<?php if( !empty($facebook) ) { ?>
              		<li><a href="<?php echo $facebook; ?>" class="ms-nw-social-media-item" title="Facebook"><i class="idx-icon-facebook"></i></a></li>
              	<?php } ?>

              	<?php if( !empty($twitter) ) { ?>
              		<li><a href="<?php echo $twitter; ?>" class="ms-nw-social-media-item" title="Twitter"><i class="idx-icon-twitter"></i></a></li>
              	<?php } ?>

              	<?php if( !empty($youtube) ) { ?>
              		<li><a href="<?php echo $youtube; ?>" class="ms-nw-social-media-item" title="Youtube"><i class="idx-icon-youtube"></i></a></li>
              	<?php } ?>

              	<?php if( !empty($pinterest) ) { ?>
              		<li><a href="<?php echo $pinterest; ?>" class="ms-nw-social-media-item" title="Pinterest"><i class="idx-icon-pinterest-p"></i></a></li>
              	<?php } ?>

            </ul>
            <?php if( !empty($biography) ) { ?>
	            <div class="ms-nw-paragraph">
	              <?php echo $biography; ?>
	            </div>
	          <?php } ?>
          </article>
        </div>
        <div class="ms-nw-contact-form">
          <div class="ms-nw-wrapper-contact-form">
            <h2 class="ms-title"><?php echo __("Connect With", IDXBOOST_DOMAIN_THEME_LANG); ?> <?php echo $response["data"]["firstName"]; ?></h2>
            <?php
              if (shortcode_exists('flex_idx_contact_form'))
                echo do_shortcode('[flex_idx_contact_form]'); 
            ?>
            <script type="text/javascript">
              jQuery(".flex-content-form .pt-name .medium").attr('placeholder','<?php echo __("Name", IDXBOOST_DOMAIN_THEME_LANG); ?>*');
              jQuery(".flex-content-form .pt-lname .medium").attr('placeholder','<?php echo __("Last Name", IDXBOOST_DOMAIN_THEME_LANG); ?>*');
              jQuery(".flex-content-form .pt-email .medium").attr('placeholder','<?php echo __("Email", IDXBOOST_DOMAIN_THEME_LANG); ?>*');
              jQuery(".flex-content-form .pt-phone .medium").attr('placeholder','<?php echo __("Phone", IDXBOOST_DOMAIN_THEME_LANG); ?>');
              jQuery(".flex-content-form .textarea").attr('placeholder','<?php echo __("Comment", IDXBOOST_DOMAIN_THEME_LANG); ?>');

              var fname = jQuery("#agent_fname").val();
              var lname = jQuery("#agent_lname").val();
              var agent_email = jQuery("#agent_email").val();
              var fname_result = fname.replace(" ", "_");
              var lname_result = lname.replace(" ", "_");

              window.filter_view = "agent";

              jQuery(".form-search input[name='ib_tags']").val("agent_"+fname_result+"_"+lname_result);
              jQuery(".form-search input[name='ib_agent_email']").val(agent_email);
            </script>
          </div>
        </div>
      </div>
    </section>

    <section class="ms-nw-agent-shortcode-prop">
      <ul class="ms-nw-btn-prop-nav">
        <?php if ( !empty($agentMLSId) ) { ?>
        <li>
          <a href="?view=listing" <?php if($view == "listing"): echo "class='active'"; endif ?>>Featured Listings</a>
        </li>
        <?php } ?>
        <?php if ( !empty($agentIdSold) ) { ?>
        <li>
          <a href="?view=sold" <?php if($view == "sold"): echo "class='active'"; endif ?>>Recently Sold</a>
        </li>
        <?php } ?>
      </ul>
      <?php
        if ( !empty($agentMLSId) && $view == "listing" ) {
          if(shortcode_exists('flex_idx_contact_form'))
              echo do_shortcode('[idx_boost_agent_office agent_id="'.$agentMLSId.'"]');             
            //[idx_boost_agent_office office_id="(.+?)"\]
        }

        if ( !empty($agentIdSold) && $view == "sold" ) {
          if(shortcode_exists('flex_idx_contact_form'))
              echo do_shortcode('[idx_boost_agent_office_sold agent_id="'.$agentIdSold.'" months_back="36"]');             
            //[idx_boost_agent_office_sold office_id="(.+?)" months_back="(.+?)"\]
        }          
      ?>
    </section>

<?php } ?>
