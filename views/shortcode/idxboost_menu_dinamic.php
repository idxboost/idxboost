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
		if (is_array($value['child']) && count($value['child']) > 0) {
			foreach ($value['child'] as $key => $menu) {
				$active = '';

				$has_class = '';
				if (array_key_exists('subItems', $menu) && is_array($menu['subItems']) && count($menu['subItems'])>0) {
					$has_class = 'ip-menu-item-has-children';
				}

				$is_external_link = '';
				if (array_key_exists('target', $menu) && $menu['target'] != '') {
					$is_external_link = 'target="'. $menu['target'] .'"';
				}

				$htmlmenu[] = '<li class="ip-menu-item '. $active .' '. $has_class .'">';
				$htmlmenu[] = '<a class="ip-menu-link" href="'.$menu['link'].'" '. $is_external_link .'>'.$menu['label'].'</a>';
				if (array_key_exists('subItems', $menu) && is_array($menu['subItems']) && count($menu['subItems'])>0) {
					$htmlmenu[] = '<ul class="ip-submenu">';
					foreach ($menu['subItems'] as $key => $submenu) {
						$htmlmenu[] = '<li class="ip-menu-item">';
						$is_external_link_two = '';
						if (array_key_exists('target', $submenu) && $submenu['target'] != '') {
							$is_external_link_two = 'target="'. $submenu['target'] .'"';
						}
						$htmlmenu[] = '<a class="ip-menu-link" href="'.$submenu['link'].'" '. $is_external_link_two .'>'.$submenu['label'].'</a>';
						$htmlmenu[] = '</li>';
					}
					$htmlmenu[] = "</ul>";
				}
				$htmlmenu[] = '</li>';				
			}
		}

		if (array_key_exists("cta", $value) && is_array($value['cta']) && count($value['cta'] ) > 0) {
			$htmlmenu[] = $value["cta"]["content"];
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
