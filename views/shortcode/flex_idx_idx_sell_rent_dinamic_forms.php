<?php

get_header();

$api_idx_access_token = flex_idx_get_access_token();

?>
<script>
	const ibLeadToken = document.cookie.split('; ').find(row => row.startsWith('ib_lead_token'))?.split('=')[1];

	const first_name_lead = document.cookie.split('; ').find(row => row.startsWith('_ib_user_firstname'))?.split('=')[1];
	const last_name_lead = document.cookie.split('; ').find(row => row.startsWith('_ib_user_lastname'))?.split('=')[1];
	const email_lead = document.cookie.split('; ').find(row => row.startsWith('_ib_user_email'))?.split('=')[1];
	const phone_lead = document.cookie.split('; ').find(row => row.startsWith('_ib_user_phone'))?.split('=')[1];
	const new_phone_number_lead = document.cookie.split('; ').find(row => row.startsWith('_ib_user_new_phone_number'))?.split('=')[1];
	const last_logged_in_username_lead = document.cookie.split('; ').find(row => row.startsWith('_ib_last_logged_in_username'))?.split('=')[1];


  const lead_detail = {
  	"name": first_name_lead,
  	"lastname" : last_name_lead,
  	"email" : email_lead,
  	"phone" : phone_lead,
  	"new_phone" : new_phone_number_lead,
  	"last_username" : last_logged_in_username_lead
  };

	window.idx_buy_sell_rent_forms = {
		form_type  : "<?php echo $atts["type"]; ?>",
		access_token: "<?php echo $api_idx_access_token; ?>",
		lead_token: ibLeadToken,
		lead : lead_detail,
		paths: '<?php echo FLEX_IDX_URI . "react/sell_rent_dinamic_forms/"; ?>'
	};

</script>

<div id="root-dinamic-forms"></div>

<?php wp_footer(); ?>

