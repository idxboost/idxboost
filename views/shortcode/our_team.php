    <div class="ms-nw-agent-list">
      <div class="ms-nw-wrapper-agent-list">
        
        <div class="ms-nw-agents-list-results">
          <div class="ms-nw-results js-list-collection-agent">
          	<?php 
          	if ( array_key_exists("success", $response) && $response["success"] && count($response["data"] ) > 0 ) { 
          		foreach ($response["data"] as $key => $item) {
					$phoneMailto = str_replace(str_split( '\\/:*?"<>|+-()'), '', $item["phone"]); 
					$slugAgent = rtrim($flex_idx_info["pages"]["flex_idx_agent_detail"]["guid"], "/")."/".$item["agentSlug"];
					$avatarAgent = $item["avatar"];
					?>

		            <div class="ms-nw-result-item">
		              <div class="ms-nw-result-card">
		                <a href="<?php echo $slugAgent; ?>" class="ms-nw-card-media">
		                  <img src="<?php echo $avatarAgent; ?>" alt="<?php echo $item["firstName"]." ".$item["lastName"]; ?>">
		                  <span>Contact</span>
		                </a>
		                <div class="ms-nw-card-info">
		                  <h3 class="ms-nw-card-title">
		                    <a href="<?php echo $slugAgent; ?>"><?php echo $item["firstName"]." ".$item["lastName"]; ?></a>
		                  </h3>
		                  <span class="ms-nw-card-status"><?php echo $item["title"]; ?></span>
		                  <a href="tel:<?php echo $phoneMailto; ?>" class="ms-nw-card-phone-number"><?php echo $item["phone"]; ?></a>
		                  <a href="mailto:<?php echo $item["email"]; ?>" class="ms-nw-card-email"><?php echo $item["email"]; ?></a>
		                  <ul class="ms-nw-social-media-list">
		                    <?php if( !empty($item["instagram"]) ){  ?>
		                    	<li><a href="<?php echo $item["instagram"]; ?>" class="ms-nw-social-media-item" title="Instagram"><i class="idx-icon-instagram"></i></a></li>
		                    <?php }  ?> 

		                    <?php if( !empty($item["linkedin"]) ){  ?>
		                    	<li><a href="<?php echo $item["linkedin"]; ?>" class="ms-nw-social-media-item" title="Linkeding"><i class="idx-icon-linkedin2"></i></a></li>
		                    <?php }  ?> 

		                    <?php if( !empty($item["facebook"]) ){  ?>
		                    	<li><a href="<?php echo $item["facebook"]; ?>" class="ms-nw-social-media-item" title="Facebook"><i class="idx-icon-facebook"></i></a></li>
		                    <?php }  ?> 

		                    <?php if( !empty($item["twitter"]) ){  ?>
		                    	<li><a href="<?php echo $item["twitter"]; ?>" class="ms-nw-social-media-item" title="Twitter"><i class="idx-icon-twitter"></i></a></li>
		                    <?php }  ?> 

		                    <?php if( !empty($item["youtube"]) ){  ?>
		                    	<li><a href="<?php echo $item["youtube"]; ?>" class="ms-nw-social-media-item" title="Youtube"><i class="idx-icon-youtube"></i></a></li>
		                    <?php }  ?> 

		                    <?php if( !empty($item["pinterest"]) ){  ?>
		                    	<li><a href="<?php echo $item["pinterest"]; ?>" class="ms-nw-social-media-item" title="Pinterest"><i class="idx-icon-pinterest-p"></i></a></li>
		                    <?php }  ?> 
	                   
		                  </ul>
		                </div>
		              </div>
		            </div>

          		<?php }
          	} ?>

          </div>
        </div>
      </div>
    </div>