<?php
global $flex_idx_info;

$idxboost_cms_menu = idxboost_cms_get_menu();
	
$htmlmenu = [];
$slug = explode("/", trim( $_SERVER["REQUEST_URI"] , '/' ));

if (is_array($idxboost_cms_menu) && count($idxboost_cms_menu) > 0) {
	$htmlmenu[] = '<ul class="ip-menu">';

	foreach ($idxboost_cms_menu as $key => $value) {
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
	}
	
	$htmlmenu[] = '</ul>';
}

if (is_array($htmlmenu) && count($htmlmenu) > 0) {
	echo implode('', $htmlmenu);
}
?>
