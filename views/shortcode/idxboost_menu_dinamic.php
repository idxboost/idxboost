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
$slug = explode("/", trim( $_SERVER["REQUEST_URI"] , '/' ));

if (is_array($result) && count($result)> 0) {
	$htmlmenu[] = '<ul class="ip-menu">';
	foreach ($result as $key => $value) {

		if (is_array($value['child']) && count($value['child'])>0) {
			foreach ($value['child'] as $key => $menu) {
				$active = '';
				$aria_current = '';
				// if( strpos($menu['link'], $slug[0]) !== false ) {
				// 	$active = 'active';
				// 	$aria_current = 'aria-current="page"';
				// }

				$has_class = '';
				if (array_key_exists('subItems', $menu) && is_array($menu['subItems']) && count($menu['subItems'])>0) {
					$has_class = 'ip-menu-item-has-children';
				}

				$is_external_link = '';
				if (array_key_exists('type', $menu) && $menu['type'] === 'property-site') {
					$is_external_link = 'target="_blank"';
				}

				$htmlmenu[] = '<li class="ip-menu-item '. $active .' '. $has_class .'">';
				$htmlmenu[] = '<a class="ip-menu-link" href="'.$menu['link'].'" '. $aria_current .' '. $is_external_link .'>'.$menu['label'].'</a>';
				if (array_key_exists('subItems', $menu) && is_array($menu['subItems']) && count($menu['subItems'])>0) {
					$htmlmenu[] = '<ul class="ip-submenu">';
					foreach ($menu['subItems'] as $key => $submenu) {
						$htmlmenu[] = '<li class="ip-menu-item">';
						$is_external_link_two = '';
						if (array_key_exists('type', $submenu) && $submenu['type'] === 'property-site') {
							$is_external_link_two = 'target="_blank"';
						}
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