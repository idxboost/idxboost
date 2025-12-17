<?php

get_header();

$api_idx_access_token = flex_idx_get_access_token();

?>
<script>
	window.idx_buy_sell_rent_forms  = {
		fom_type : "<?php echo $atts["type"]; ?>",
		access_token: "<?php echo $api_idx_access_token; ?>",
		lead_token: Cookies.get('ib_lead_token'),
		anonymous: __flex_g_settings.anonymous,
		paths: '<?php echo FLEX_IDX_URI . "react/sell_rent_dinamic_forms/"; ?>',
	}

</script>

<div id="root-dinamic-forms"></div>

<?php wp_footer(); ?>

