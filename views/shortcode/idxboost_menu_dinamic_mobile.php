<?php
global $flex_idx_info;

$idxboost_cms_menu = idxboost_cms_get_menu();
    
$htmlmenu = [];

if (is_array($idxboost_cms_menu) && count($idxboost_cms_menu) > 0) {
    $htmlmenu[] = '<ul>';

    foreach ($idxboost_cms_menu as $key => $value) {
        if (is_array($value['child']) && count($value['child']) > 0) {
            foreach ($value['child'] as $key => $menu) {

                $has_class = '';
                $submenu_toggle = '';
                if (array_key_exists('subItems', $menu) && is_array($menu['subItems']) && count($menu['subItems']) > 0) {
                    $has_class = ' ip-menu-item-has-children';
                    $submenu_toggle = '<button class="ip-submenu-toggle js-submenu-toggle"></button>';
                }

                $is_external_link = '';
                if (array_key_exists('target', $menu) && $menu['target'] != '') {
                    $is_external_link = 'target="'. $menu['target'] .'"';
                }

                $htmlmenu[] = '<li class="ip-menu-item'. $has_class .'">';
                $htmlmenu[] = '<div class="ip-menu-item-wrapper">';
                $htmlmenu[] = '<a class="ip-menu-link" href="'.$menu['link'].'" '. $is_external_link .'>'.$menu['label'].'</a>';
                $htmlmenu[] = $submenu_toggle;
                $htmlmenu[] = '</div>';
                if (array_key_exists('subItems', $menu) && is_array($menu['subItems']) && count($menu['subItems'])>0) {
                    $htmlmenu[] = '<ul class="ip-submenu js-submenu">';
                    foreach ($menu['subItems'] as $key => $submenu) {
                        $is_external_link_two = '';
                        if (array_key_exists('target', $submenu) && $submenu['target'] != '') {
                            $is_external_link_two = 'target="'. $submenu['target'] .'"';
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

if (is_array($htmlmenu) && count($htmlmenu) > 0) {
    echo implode('', $htmlmenu);
}
?>
