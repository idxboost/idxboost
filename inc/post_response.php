<?php
include $_SERVER['DOCUMENT_ROOT'].'/wp-config.php';
global $wp, $wpdb;

//add_action( 'wp_ajax_dgt_mortgage_calculator_fn', 'dgt_mortgage_calculator_fn' );


//function dgt_mortgage_calculator_fn() {
  $params = $_POST;

if ($params['action']=='idx_update_building') {
      $item_building_cod=$wpdb->get_row("SELECT ID,IF(thumb.meta_value is null,'0','1') as thumb,thumb.meta_value as thumb_post  from {$wpdb->posts} inner join {$wpdb->postmeta} as meta on meta.post_id={$wpdb->posts}.ID and meta.meta_key='dgt_tg_idxboost_building'  and meta.meta_value='".$params['codebuild']."' LEFT join {$wpdb->postmeta} as thumb on thumb.post_id={$wpdb->posts}.ID  and thumb.meta_key='dgt_extra_gallery' limit 1;",ARRAY_A);

if (!empty($item_building_cod)) {  
  $wpdb->query("UPDATE {$wpdb->postmeta} SET meta_value='".$params['year']."' WHERE  post_id='".$item_building_cod['ID']."' and meta_key='dgt_year_building';");
  $wpdb->query("UPDATE {$wpdb->postmeta} SET meta_value='".$params['units']."' WHERE  post_id='".$item_building_cod['ID']."' and meta_key='dgt_extra_unit';");
  $wpdb->query("UPDATE {$wpdb->postmeta} SET meta_value='".$params['photo']."' WHERE  post_id='".$item_building_cod['ID']."' and meta_key='dgt_tg_gallery';");

  $wpdb->query("UPDATE {$wpdb->postmeta} SET meta_value='".$params['lat']."' WHERE  post_id='".$item_building_cod['ID']."' and meta_key='dgt_extra_lat';");
  $wpdb->query("UPDATE {$wpdb->postmeta} SET meta_value='".$params['lng']."' WHERE  post_id='".$item_building_cod['ID']."' and meta_key='dgt_extra_lng';");

  $wpdb->query("UPDATE {$wpdb->postmeta} SET meta_value='".$params['floor']."' WHERE  post_id='".$item_building_cod['ID']."' and meta_key='dgt_extra_floor';");
  $wpdb->query("UPDATE {$wpdb->postmeta} SET meta_value='".$params['address']."' WHERE  post_id='".$item_building_cod['ID']."' and meta_key='dgt_extra_address';"); 
    
  /*IMAGEN_SINCRONIZAR*/
  if($item_building_cod['thumb']=='1'){
    $wpdb->query("UPDATE {$wpdb->posts} set guid='".$params['photo']."' WHERE ID='".$item_building_cod['thumb_post']."';");
  }else{
      $insert_image_post=wp_insert_post(array('post_title'=> '','post_status'  => 'inherit','post_name'=> '','post_content' => '','post_author'  => '2','post_type'=> 'attachment','post_type'=> 'tg_image','guid'=> $params['photo']));
      $result_insert_gallery=$wpdb->query("INSERT INTO {$wpdb->postmeta} (post_id,meta_key,meta_value) VALUES('".$item_building_cod['ID']."','dgt_extra_gallery','".$insert_image_post."') ");
      $result_insert_gallery=$wpdb->query("INSERT INTO {$wpdb->postmeta} (post_id,meta_key,meta_value) VALUES('".$item_building_cod['ID']."','dgt_tg_gallery','".$params['photo']."') ");
  }/*IMAGEN_SINCRONIZAR*/
}
file_put_contents($_SERVER['DOCUMENT_ROOT'].'/respuesta.txt', $item_building_cod);
die();
}else if ( isset($params['action'])) {  
  $sale_price   =  ($params['purchase_price']); 
  $down_percent = ($params['down_payment']);
  $year_term = ($params['year_term']);
  $annual_interest_percent = ($params['interest_rate']);
  if(!is_numeric($sale_price) || !is_numeric($down_percent) || !is_numeric($annual_interest_percent)) {
    header('HTTP/1.1 500 Invalid number!');
    exit();
  }
  $response = calculateMortgage($sale_price, $down_percent, $year_term, $annual_interest_percent);   
  echo ( $response );
  exit();
}
//}

function calculateMortgage($sale_price, $down_percent, $year_term, $annual_interest_percent) {
  $monthly_factor      = 0;
  $month_term              = $year_term * 12;
  $down_payment            = $sale_price * ($down_percent / 100);
  $annual_interest_rate    = $annual_interest_percent / 100;
  $monthly_interest_rate   = $annual_interest_rate / 12;
  $financing_price         = $sale_price - $down_payment;
  $base_rate   = 1 + $monthly_interest_rate;
  $denominator = $base_rate;
  for ($i=0; $i < ($year_term * 12); $i++) {
    $monthly_factor += (1 / $denominator);
    $denominator *= $base_rate;
  }
  $monthly_payment = $financing_price / $monthly_factor;
  $pmi_per_month = 0;
  if ($down_percent < 20) {
    $pmi_per_month = 55 * ($financing_price / 100000);
  }
  $total_monthly = $monthly_payment + $pmi_per_month; // + $residential_monthly_tax;
  $output = array( 'mortgage' => number_format($financing_price, 0), 'down_payment' => number_format($down_payment, 0), 'monthly' => number_format($monthly_payment, 2), 'total_monthly' => number_format($total_monthly, 2)); 
  return $output;
}

?>
