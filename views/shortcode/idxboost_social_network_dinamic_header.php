<?php
global $flex_idx_info;
$facebook_social_url = isset($flex_idx_info["social"]["facebook_social_url"]) ? $flex_idx_info["social"]["facebook_social_url"] : null;
$twitter_social_url = isset($flex_idx_info["social"]["twitter_social_url"]) ? $flex_idx_info["social"]["twitter_social_url"] : null;
$youtube_social_url = isset($flex_idx_info["social"]["youtube_social_url"]) ? $flex_idx_info["social"]["youtube_social_url"] : null;
$instagram_social_url = isset($flex_idx_info["social"]["instagram_social_url"]) ? $flex_idx_info["social"]["instagram_social_url"] : null;
$linkedin_social_url = isset($flex_idx_info["social"]["linkedin_social_url"]) ? $flex_idx_info["social"]["linkedin_social_url"] : null;
$pinterest_social_url = isset($flex_idx_info["social"]["pinterest_social_url"]) ? $flex_idx_info["social"]["pinterest_social_url"] : null;


echo '<div class="ip-header-social">';
if ($facebook_social_url) {
    echo '<a class="ip-header-social-link idx-icon-facebook" 
									title="Facebook" aria-label="Find us on Facebook"
									href="' . $facebook_social_url . '" target="_blank" rel="nofollow noopener"></a>';

}
if ($twitter_social_url) {
    echo '<a class="ip-header-social-link idx-icon-twitter" 
									title="Twitter" aria-label="Follow us on Twitter"
									href="' . $twitter_social_url . '" target="_blank" rel="nofollow noopener"></a>';
}

if ($youtube_social_url) {
    echo '<a class="ip-header-social-link idx-icon-youtube" 
									title="Youtube" aria-label="Follow us on Youtube"
									href="' . $youtube_social_url . '" target="_blank" rel="nofollow noopener"></a>';
}
if ($instagram_social_url) {
    echo '	<a class="ip-header-social-link idx-icon-instagram" 
									title="Instagram" aria-label="Follow us on Instagram"
									href="' . $instagram_social_url . '" target="_blank" rel="nofollow noopener"></a>';
}
if ($linkedin_social_url) {
    echo '<a class="ip-header-social-link idx-icon-linkedin2" 
									title="Linked In" aria-label="Follow us on Linked In"
									href="' . $linkedin_social_url . '" target="_blank" rel="nofollow noopener"></a>';
}

if ($pinterest_social_url) {
    echo '<a class="ip-header-social-link idx-icon-pinterest" 
									title="Pinterest" aria-label="Follow us on Pinterest"
									href="' . $pinterest_social_url . '" target="_blank" rel="nofollow noopener"></a>';
}


echo '</div>';