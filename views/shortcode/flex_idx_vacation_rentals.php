<div id="ib-wrapper-rentals" class="ib-wrapper-rentals"
     data-lat="<?php if (empty($atts['lat'])) {
         echo '';
     } else {
         echo $atts['lat'];
     } ?>"
     data-lng="<?php if (empty($atts['lng'])) {
         echo '';
     } else {
         echo $atts['lng'];
     } ?>"
     data-zoom="<?php if (empty($atts['zoom'])) {
         echo '';
     } else {
         echo $atts['zoom'];
     } ?>"
     data-officecode="<?php if (isset($atts['office_code'])) {
         echo $atts['office_code'];
     } else {
         echo '';
     } ?>"
     data-boardid="<?php if (empty($atts['board_id'])) {
         if ( get_option('idxboost_registration_key') == "2c7a818c-a92f-42a1-a591-c9b5849749f3" ) {
             echo '101';
         } else {
             echo '100';
         }
     } else {
         echo $atts['board_id'];
     } ?>">
</div>
