<?php
global $flex_idx_info;


$data = array(
    'registration_key' => get_option('idxboost_registration_key')
);

$payload = json_encode($data);
// Prepare new cURL resource
$ch = curl_init(IDX_BOOST_SPW_BUILDER_SERVICE . '/api/dinamic-menu');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLINFO_HEADER_OUT, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

// Set HTTP Header for POST request
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($payload))
);

$result = @json_decode(curl_exec($ch),true);


$htmlmenu =[];

if (is_array($result) && count($result)> 0) {
    $htmlmenu[] = '<ul>';
    foreach ($result as $key => $value) {

        if (is_array($value['child']) && count($value['child'])>0) {
            foreach ($value['child'] as $key => $menu) {
                $has_class = '';
                $submenu_toggle = '';
                if (array_key_exists('subItems', $menu) && is_array($menu['subItems']) && count($menu['subItems']) > 0) {
                    $has_class = ' ip-menu-item-has-children';
                    $submenu_toggle = '<button class="ip-submenu-toggle js-submenu-toggle"></button>';
                }

                $is_external_link = '';
				if (array_key_exists('type', $menu) && $menu['type'] === 'property-site') {
					$is_external_link = 'target="_blank"';
				}

                $htmlmenu[] = '<li class="ip-menu-item'. $has_class .'">';
                $htmlmenu[] = '<div class="ip-menu-item-wrapper">';
                $htmlmenu[] = '<a class="ip-menu-link" href="'.$menu['link'].'" '. $aria_current .' '. $is_external_link .'>'.$menu['label'].'</a>';
                $htmlmenu[] = $submenu_toggle;
                $htmlmenu[] = '</div>';
                if (array_key_exists('subItems', $menu) && is_array($menu['subItems']) && count($menu['subItems'])>0) {
                    $htmlmenu[] = '<ul class="ip-submenu js-submenu">';
                    foreach ($menu['subItems'] as $key => $submenu) {
                        $is_external_link_two = '';
						if (array_key_exists('type', $submenu) && $submenu['type'] === 'property-site') {
							$is_external_link_two = 'target="_blank"';
                        }
                        
                        $htmlmenu[] = '<li class="ip-menu-item">';
                        $htmlmenu[] = '<a class="ip-menu-link" href="'.$submenu['link'].'" '. $is_external_link_two .'>'.$submenu['label'].'</a>';
                        $htmlmenu[] = '</li>';
                    }
                    $htmlmenu[] = "</ul>";
                }
                $htmlmenu[] = '</li>';
            }
        }
    }
    $htmlmenu[] = '</ul>';
}

$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

// Close cURL session handle
curl_close($ch);

if (is_array($htmlmenu) && count($htmlmenu) > 0) {
    echo implode('', $htmlmenu);
}
?>
