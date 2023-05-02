<div id="ib-wrapper-rentals" class="ib-wrapper-rentals" 
data-hiddenPhone="<?php if ($Phone_office) {
    echo '1';
} else {
    echo '0';
} ?>" 

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
    echo '';
} else {
    echo $atts['board_id'];
} ?>" 
data-multicity="<?php if (empty($atts['multicity'])) {
    echo '';
 } else {
    echo $atts['multicity'];
} ?>" 
data-multicitycheck="<?php if (empty($atts['multicity_check'])) {
    echo '';
} else {
    echo $atts['multicity_check'];
} ?>" 
 data-switchmap="<?php if (empty($atts['switch_map'])) {
    echo '';
} else {
    echo $atts['switch_map'];
} ?>"
data-removemap="<?php if (empty($atts['remove_map'])) {
    echo '';
} else {
    echo $atts['remove_map'];
} ?>"
data-autocompletetoolbar="<?php if (empty($atts['autocomplete_tool_bar'])) {
    echo '';
} else {
    echo $atts['autocomplete_tool_bar'];
} ?>"
data-autocompletemorefilter="<?php if (empty($atts['autocomplete_more_filter'])) {
    echo '';
} else {
    echo $atts['autocomplete_more_filter'];
} ?>"
data-citiestoolbar="<?php if (empty($atts['cities_tool_bar'])) {
    echo '';
} else {
    echo $atts['cities_tool_bar'];
} ?>"
data-citiesmorefilter="<?php if (empty($atts['cities_more_filter'])) {
    echo '';
} else {
    echo $atts['cities_more_filter'];
} 
?>"
data-autocompletetabstoolbar="<?php if (empty($atts['autocomplete_tabs_tool_bar'])) {
    echo '';
} else {
    echo $atts['autocomplete_tabs_tool_bar'];
} ?>"
>

</div>