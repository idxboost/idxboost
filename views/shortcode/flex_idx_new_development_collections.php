<?php
	$idxboost_search_settings = get_option('idxboost_search_settings');
	$idxboost_search_filter_settings = get_option('idxboost_search_filter_settings');
	$idxboost_agent_info = get_option('idxboost_agent_info');
	$api_idx_access_token = flex_idx_get_access_token();
	$ia_search = ( array_key_exists("ia_search", $flex_idx_info["agent"] ) && !empty($flex_idx_info["agent"]["ia_search"]) ) ? $flex_idx_info["agent"]["ia_search"] : '0';

	$search_new_developmet = $wpdb->get_var("
                      select t1.post_name
                      from {$wpdb->posts} t1
                      inner join {$wpdb->postmeta} t2
                      on t1.ID = t2.post_id
                      where t1.post_type = 'flex-idx-pages'
                      and t1.post_status = 'publish'
                      and t2.meta_key = '_flex_id_page'
                      and t2.meta_value = 'flex_idx_new_development_detail'
                      limit 1
                    ");

	$search_new_developmet_collection = $wpdb->get_var("
                      select t1.post_name
                      from {$wpdb->posts} t1
                      inner join {$wpdb->postmeta} t2
                      on t1.ID = t2.post_id
                      where t1.post_type = 'flex-idx-pages'
                      and t1.post_status = 'publish'
                      and t2.meta_key = '_flex_id_page'
                      and t2.meta_value = 'flex_idx_new_development_collections'
                      limit 1
                    ");

?>
<script>
	var __flex_g_settings = {
		propertyDetailPermalink: '<?php echo get_site_url(); ?>/property'
	}

	<?php 
		$force_registration = isset($flex_idx_info["agent"]["force_registration"]) ? $flex_idx_info["agent"]["force_registration"] : 0;
	 	$force_registration_forced =  ($force_registration == "1") ?  $idxboost_agent_info['force_registration_forced'] : null;
		$signup_left_clicks = ( $force_registration == "1" &&  isset($flex_idx_info["agent"]["signup_left_clicks"]) && !empty($flex_idx_info["agent"]["signup_left_clicks"]) ? (int)$flex_idx_info["agent"]["signup_left_clicks"] : 0); 
	
	//var_dump($force_registration_forced);
	?>

	window.developments_settings = {
	    folder_path: '<?php echo FLEX_IDX_URI .  'react' . DIRECTORY_SEPARATOR . 'new-developments'. DIRECTORY_SEPARATOR; ?>', // ruta donde se aloja el bundle
	    default_params: { // objeto de params por defecto
	        sort: '<?php echo $atts["sort"]; ?>'
	    },
	    collections_path: '<?php echo $search_new_developmet_collection; ?>', // slug para colecciones
	    detail_path: '<?php echo $search_new_developmet; ?>' // slug para detalle
	}


	window.idx_main_settings = {
		active_ai : '<?php echo $ia_search; ?>',
		force_registration: Boolean(<?php echo $force_registration; ?>),
		force_registration_forced: <?php echo  $force_registration == "1" ? json_encode($force_registration_forced) : "undefined"; ?>,
		signup_left_clicks: <?php echo  $force_registration == "1" ? $signup_left_clicks : "undefined"; ?>,
		search_settings: <?php echo json_encode($idxboost_search_settings); ?>,
		agent_info:<?php echo json_encode($idxboost_agent_info); ?>,
		access_token:"<?php echo $api_idx_access_token; ?>",
		board_info : <?php echo @json_encode($idxboost_search_settings['board_info']); ?>
	}	
	window.idxtoken="<?php echo $access_token_service; ?>";

</script>  

<div id="root-new-developments"></div>
<div id="nd-contact-modal"></div>

