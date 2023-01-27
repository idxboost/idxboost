<?php
  defined('ABSPATH') || die();
  
  global $wp_post_types;
  $post_ID = 999999990;
  $args = ['public' => true,];
  
  $post_types = get_post_types($args, 'objects');
  
  $post_types_filtered = Array();
  $post_types_includes = array('flex-idx-building','flex-landing-pages','flex-filter-pages','idx-sub-area','idx-off-market','post','page','flex-idx-pages');
  
      foreach ($post_types as $post_type_obj) :        
          if(in_array($post_type_obj->name, $post_types_includes)){
              $post_types_filtered[] = $post_type_obj;
          }
      endforeach;
  
  $store = [];
  
  if (isset($_POST)) {
      
      if(isset($_POST['name_data'])){
       
          $store += array(
              'name_data' => $_POST['name_data']
          );  
          
      }
      if(isset($_POST['description_data'])){
          $store += array(
              'description_data' => $_POST['description_data']
          );  
      }
  
      if(isset($_POST['img_data'])){
          $store += array(
              'img_data' => $_POST['img_data']
          );  
      }
  
  
      // Form Data for Agent
  
      if(isset($_POST['name_agent'])){
          $store += array(
              'name_agent' => $_POST['name_agent']
          );  
      }
      if(isset($_POST['description_agent'])){
          $store += array(
              'description_agent' => $_POST['description_agent']
          );  
      }
      if(isset($_POST['url_img_agent'])){
          $store += array(
              'url_img_agent' => $_POST['url_img_agent']
          );  
      }
      if(isset($_POST['price_range_agent'])){
          $store += array(
              'price_range_agent' => $_POST['price_range_agent']
          );  
      }
      if(isset($_POST['email_agent'])){
          $store += array(
              'email_agent' => $_POST['email_agent']
          );  
      }
      if(isset($_POST['tele_phone_agent'])){
          $store += array(
              'tele_phone_agent' => $_POST['tele_phone_agent']
          );  
      }
      if(isset($_POST['url_agent'])){
          $store += array(
              'url_agent' => $_POST['url_agent']
          );  
      }
      if(isset($_POST['opening_hours_agent'])){
          $store += array(
              'opening_hours_agent' => $_POST['opening_hours_agent']
          );  
      }
      if(isset($_POST['street_address_agent'])){
          $store += array(
              'street_address_agent' => $_POST['street_address_agent']
          );  
      }
      if(isset($_POST['address_locality_agent'])){
          $store += array(
              'address_locality_agent' => $_POST['address_locality_agent']
          );  
      }
      if(isset($_POST['address_region_agent'])){
          $store += array(
              'address_region_agent' => $_POST['address_region_agent']
          );  
      }
      if(isset($_POST['postal_code_agent'])){
          $store += array(
              'postal_code_agent' => $_POST['postal_code_agent']
          );  
      }
      if(isset($_POST['address_country_agent'])){
          $store += array(
              'address_country_agent' => $_POST['address_country_agent']
          );  
      }    
      if(isset($_POST['latitude_agent'])){
          $store += array(
              'latitude_agent' => $_POST['latitude_agent']
          );  
      }
      if(isset($_POST['longitud_agent'])){
          $store += array(
              'longitud_agent' => $_POST['longitud_agent']
          );  
      }
  
  
      foreach ($post_types_filtered as $post_type_obj) :
          $labels = get_post_type_labels($post_type_obj);
          $index = utf8_decode(strtolower(esc_html($post_type_obj->name)));
          if (isset($_POST[$index])) {
              $store += array(
                  $index => $index
              );
          }
      endforeach;
      if (!empty($store)) {
        update_post_meta($post_ID, '_schema_seo', $store);
      }
  }
  $schema_data = get_post_meta($post_ID, '_schema_seo', true);
  
  wp_enqueue_style('flex-idx-admin');

  ?>
<style>
  .container-switch {
    display: flex;
    flex-direction: row;
    align-items: center;
    align-content: center;
    margin: .2rem;
  }
  .container-switch span {
    padding: .5rem;
  }
  .switch {
    position: relative;
    display: inline-block;
    width: 40px;
    height: 24px;
  }
  /* Hide default HTML checkbox */
  .switch input {
    opacity: 0;
    width: 0;
    height: 0;
  }
  /* The slider */
  .slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    -webkit-transition: .4s;
    transition: .4s;
  }
  .slider:before {
    position: absolute;
    content: "";
    height: 16px;
    width: 16px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    -webkit-transition: .4s;
    transition: .4s;
  }
  input:checked+.slider {
    background-color: #2196F3;
  }
  input:focus+.slider {
    box-shadow: 0 0 1px #2196F3;
  }
  input:checked+.slider:before {
    -webkit-transform: translateX(16px);
    -ms-transform: translateX(16px);
    transform: translateX(16px);
  }
  /* Rounded sliders */
  .slider.round {
    border-radius: 34px;
  }
  .slider.round:before {
    border-radius: 50%;
  }
  .idx_map_style {
    height: 200px !important;
    width: 75% !important;
  }
  .name_agent,
  .name_data,
  .url_img_agent,
  .url_agent,
  .img_data {
    width: 75% !important;
  }
  #id-agent-style input[type=text]{
    width: 75% !important;
  }
  @media screen and (max-width: 967px) {
  .name_agent,
  .url_img_agent,
  .name_data,
  .url_agent,
  .img_data {
    width: 100% !important;
  }
  #id-agent-style input[type=text]{
    width: 100% !important;
  }
  .idx_map_style {
    height: 200px !important;
    width: 100% !important;
  }
  }
  .gallery{
    display: flex;
    flex-direction: column;
  }
  .btn_gallery{
    align-items: left;
    align-self: left;
    margin-top: .4rem;
  }
  input.btn_gallery,
  input.sendbtn{
    width: 120px !important;
    display:inline-block;
    padding:0.2em .45em !important;
    margin:0.1em !important;
    border:0.15em solid #CCCCCC;
    box-sizing: border-box;
    text-decoration:none;
    font-family:'Segoe UI','Roboto',sans-serif;
    font-weight:400;
    color:#000000;
    background-color:#CCCCCC;
    text-align:center;
    position:relative;
  }
  input.btn_gallery:hover,
  input.sendbtn:hover{
    border-color:#7a7a7a;
    cursor: pointer;
  }
  input.btn_gallery:active,
  input.sendbtn:active{
    background-color:#999999;
  }
  @media all and (max-width:30em){
    input.btn_gallery,
    input.sendbtn{
        display:block;
        margin:0.2em auto;    
    }
  }
  .ms-schema-wrapper .schema-form-h2{   
    font-weight: bold;
    padding-bottom: 15px;
    margin-bottom: 15px;
    border-bottom: 1px solid #d7d7d7;
    margin-top: 30px;
  }
  .ms-schema-wrapper textarea {
    padding: 15px;
    border-color: #dcdcde;
  }
  .ms-schema-wrapper input[type=date], 
  .ms-schema-wrapper input[type=datetime-local], 
  .ms-schema-wrapper input[type=datetime], 
  .ms-schema-wrapper input[type=email], 
  .ms-schema-wrapper input[type=month], 
  .ms-schema-wrapper input[type=number], 
  .ms-schema-wrapper input[type=password], 
  .ms-schema-wrapper input[type=search], 
  .ms-schema-wrapper input[type=tel], 
  .ms-schema-wrapper input[type=text], 
  .ms-schema-wrapper input[type=time], 
  .ms-schema-wrapper input[type=url], 
  .ms-schema-wrapper input[type=week] {
    padding: 0 15px;
    min-height: 40px;
    border-color: #dcdcde;
    margin: 0;
  }
  .ms-schema-wrapper .ms-input-file{
    display: flex;
    flex-direction: row;
  }
  .ms-schema-wrapper .ms-input-file .ms-file{
    max-width: calc(100% - 130px) !important;
    border-radius: 0;
    border-top-left-radius: 4px;
    border-bottom-left-radius: 4px;
    background-color: #FFF;
    flex-grow: 1;
  }
  .ms-schema-wrapper .ms-input-file .ms-file-btn{
    margin: 0 !important;
    min-height: 40px;
    border: 0 !important;
    border-top-right-radius: 4px;
    border-bottom-right-radius: 4px;
    background-color: #333;
    color: #FFF;
    transition: all .3s;
    width: 130px !important;
  }
  .ms-schema-wrapper .ms-input-file .ms-file-btn:hover{
    background-color: #707070;
  }
  .ms-schema-wrapper .ms-block-msg{
    max-width: 100%;
    padding: 15px;
    border-radius: 6px;
    color: #004085;
    background-color: #cce5ff;
    border-color: #b8daff;
    margin: 15px 0;
  }
  .ms-schema-wrapper .sendbtn{
    min-height: 45px;
    border: 0 !important;
    background: #333;
    color: #FFF;
    transition: all .3s;
    border-radius: 4px;
    width: 140px !important;
    transition: all .3s;
  }
  .ms-schema-wrapper .sendbtn:hover{
    background-image: linear-gradient(90deg, rgba(239,61,78,1) 0%, rgba(204,50,90,1) 60%, rgba(174,40,101,1) 100%);
  }
  .ms-schema-wrapper input:checked+.slider {
    background-color: #333;
  }
  @media screen and (min-width: 768px){
    .ms-schema-form-table tbody{
        display: flex;
        flex-wrap: wrap;
    }
    .ms-schema-form-table tbody tr {
        display: flex;
        flex-direction: column;
        width: 47%;
        padding: 0 10px;
    }
    .ms-schema-form-table tbody tr th{
        margin-bottom: 5px
    }
    .ms-schema-form-table tbody tr td,
    .ms-schema-form-table tbody tr th {
        padding: 0;
    }
    .ms-schema-form-table tbody tr.ms-full {
        width: 100%;
    }
    .ms-schema-wrapper .schema-form-h2{   
        width: calc(100% - 20px);
        margin-left: 10px;
    }
    .idx_map_style,
    .ms-schema-wrapper #id-agent-style input[type=text],
    .ms-schema-wrapper input[type=date], 
    .ms-schema-wrapper input[type=datetime-local], 
    .ms-schema-wrapper input[type=datetime], 
    .ms-schema-wrapper input[type=email], 
    .ms-schema-wrapper input[type=month], 
    .ms-schema-wrapper input[type=number], 
    .ms-schema-wrapper input[type=password], 
    .ms-schema-wrapper input[type=search], 
    .ms-schema-wrapper input[type=tel], 
    .ms-schema-wrapper input[type=text], 
    .ms-schema-wrapper input[type=time], 
    .ms-schema-wrapper input[type=url], 
    .ms-schema-wrapper input[type=week] {
        width: 100% !important;
    }
  }

  @media screen and (min-width: 1024px){
    .ms-schema-wrapper{
        max-width: 700px;
    }
  }
</style>
<div class="wrap">
  <div class="container_options ms-schema-wrapper">
    <form id="save_schema_options" class="schema-form" method="post" onsubmit="return validate();">
      <h2 class="schema-form-h2">Information General for Organization</h2>
      <table class="form-table ms-schema-form-table">
        <tbody>
          <tr class="ms-full">
            <th scope="row">
              <label for="name_data">Name Organization</label>
            </th>
            <td>
              <input class="name_data" name="name_data" type="text" id="name_data" value="<?php
               if (!empty($schema_data)){ echo esc_html($schema_data['name_data']);} ?>">
            </td>
          </tr>
          <tr class="ms-full">
            <th scope="row">
              <label for="description_data">Description</label>
            </th>
            <td>
              <textarea class="idx_map_style" name="description_data" id="description_data" style="margin-top: 0px;margin-bottom: 0px;width: 100%;"><?php
              if (!empty($schema_data)){ echo esc_html($schema_data['description_data']);} ?></textarea>
            </td>
          </tr>
          <tr class="ms-full">
            <th scope="row">
              <label for="img_data">Imagen URL</label>
            </th>
            <td class="gallery ms-input-file">
              <input class="img_data ms-file" readonly name="img_data" type="text" id="img_data" value="<?php 
              if (!empty($schema_data)){echo esc_html($schema_data['img_data']);} ?>">
              <input class="btn_gallery ms-file-btn" id="boton_crear_galeria" value="Select Imagen" type="button">
            </td>
          </tr>
        </tbody>
      </table>
      <!-- For Agents -->
      <h2 class="schema-form-h2">Information for Real Estate Agent</h2>
      <table class="form-table ms-schema-form-table ms-xd" id="id-agent-style">
        <tbody>
          <tr class="ms-full">
            <th scope="row">
              <label for="name_agent">Name</label>
            </th>
            <td>
              <input class="name_agent" name="name_agent" type="text" id="name_agent" value="<?php
              if (!empty($schema_data)){ echo esc_html($schema_data['name_agent']);} ?>">
            </td>
          </tr>
          <tr class="ms-full">
            <th scope="row">
              <label for="description_agent">Description</label>
            </th>
            <td>
              <textarea class="idx_map_style" name="description_agent" id="description_agent" style="margin-top: 0px;margin-bottom: 0px;width: 100%;"><?php
              if (!empty($schema_data)){ echo esc_html($schema_data['description_agent']);} ?></textarea>
            </td>
          </tr>
          <tr>
            <th scope="row">
              <label for="tele_phone_agent">Phone</label>
            </th>
            <td>
              <input class="tele_phone_agent" name="tele_phone_agent" type="text" id="tele_phone_agent" value="<?php 
              if (!empty($schema_data)){echo esc_html($schema_data['tele_phone_agent']);} ?>">                            
            </td>
          </tr>
          <tr>
            <th scope="row">
              <label for="email_agent">Email</label>
            </th>
            <td>
              <input class="email_agent" name="email_agent" type="text" id="email_agent" value="<?php 
              if (!empty($schema_data)){echo esc_html($schema_data['email_agent']);} ?>">                            
            </td>
          </tr>
          <tr>
            <th scope="row">
              <label for="price_range_agent">Price Range</label>
            </th>
            <td>
              <input class="price_range_agent" name="price_range_agent" type="text" id="price_range_agent" value="<?php
              if (!empty($schema_data)){ echo esc_html($schema_data['price_range_agent']);} ?>">                            
            </td>
          </tr>
          <tr>
            <th scope="row">
              <label for="opening_hours_agent">Opening Hours</label>
            </th>
            <td>
              <input class="opening_hours_agent" name="opening_hours_agent" type="text" id="opening_hours_agent" value="<?php if(!empty($schema_data['opening_hours_agent'])) {echo esc_html($schema_data['opening_hours_agent']);}else{ echo "Mo,Tu,We,Th,Fr,Sa,Su 09:00-18:00";} ?>">                            
            </td>
          </tr>
          <tr>
            <th scope="row">
              <label for="street_address_agent">Street Address</label>
            </th>
            <td>
              <input class="street_address_agent" name="street_address_agent" type="text" id="street_address_agent" value="<?php
              if (!empty($schema_data)){ echo esc_html($schema_data['street_address_agent']);} ?>">                            
            </td>
          </tr>
          <tr>
            <th scope="row">
              <label for="address_locality_agent">Address Locality</label>
            </th>
            <td>
              <input class="address_locality_agent" name="address_locality_agent" type="text" id="address_locality_agent" value="<?php
              if (!empty($schema_data)){ echo esc_html($schema_data['address_locality_agent']);} ?>">                            
            </td>
          </tr>
          <tr>
            <th scope="row">
              <label for="address_region_agent">Address Region</label>
            </th>
            <td>
              <input class="address_region_agent" name="address_region_agent" type="text" id="address_region_agent" value="<?php
              if (!empty($schema_data)){ echo esc_html($schema_data['address_region_agent']);} ?>">                            
            </td>
          </tr>
          <tr>
            <th scope="row">
              <label for="postal_code_agent">Postal Code</label>
            </th>
            <td>
              <input class="postal_code_agent" name="postal_code_agent" type="text" id="postal_code_agent" value="<?php 
              if (!empty($schema_data)){echo esc_html($schema_data['postal_code_agent']);} ?>">                            
            </td>
          </tr>
          <tr>
            <th scope="row">
              <label for="address_country_agent">Country</label>
            </th>
            <td>
              <input class="address_country_agent" name="address_country_agent" type="text" id="address_country_agent" value="<?php 
              if (!empty($schema_data)){echo esc_html($schema_data['address_country_agent']);} ?>">                            
            </td>
          </tr>
          <tr>
            <th scope="row">
              <label for="url_agent">URL Site</label>
            </th>
            <td>
              <input class="url_agent" name="url_agent" type="text" id="url_agent" value="<?php 
              if (!empty($schema_data)){echo esc_html($schema_data['url_agent']);} ?>">                            
            </td>
          </tr>
          <tr class="ms-full">
            <th scope="row">
              <label for="url_img_agent">Imagen URL</label>
            </th>
            <td class="gallery ms-input-file">
              <input class="url_img_agent ms-file" readonly name="url_img_agent" type="text" id="url_img_agent" value="<?php 
              if (!empty($schema_data)){echo esc_html($schema_data['url_img_agent']);} ?>">
              <input class="btn_gallery ms-file-btn" id="boton_gallery_agent" value="Select Imagen" type="button">
            </td>
          </tr>
          <tr class="ms-full">
            <th scope="row">                            
            </th>
            <td>
              <div class="ms-block-msg">
                <ol>
                  <li>
                    <p>To obtain the coordinates of the address, please go to the following link <a href="https://www.latlong.net/convert-address-to-lat-long.html" target="_blank">get coordinates</a></p>
                  </li>
                  <li>
                    <p>The coordinates obtained copy and paste in the respective input fields.</p>
                  </li>
                </ol>
              </div>
            </td>
          </tr>
          <tr>
            <th scope="row">
              <label for="latitude_agent">Latitude</label>
            </th>
            <td>
              <input class="latitude_agent" name="latitude_agent"  type="text" id="latitude_agent" value="<?php
              if (!empty($schema_data)){ echo esc_html($schema_data['latitude_agent']);} ?>">                            
            </td>
          </tr>
          <tr>
            <th scope="row">
              <label for="longitud_agent">Longitud</label>
            </th>
            <td>
              <input class="longitud_agent" name="longitud_agent" type="text" id="longitud_agent" value="<?php
              if (!empty($schema_data)){ echo esc_html($schema_data['longitud_agent']);} ?>">                            
            </td>
          </tr>
        </tbody>
      </table>
      <!-- For Agents -->
      <h2 class="schema-form-h2">Mark the types of post where the Schema will be visible</h2>
      <ul class="ks-cboxtags">
        <?php foreach ($post_types_filtered as $post_type_obj) :
          $labels = get_post_type_labels($post_type_obj);                    
          if (!empty($schema_data) && array_key_exists($post_type_obj->name, $schema_data)) {
          ?>
        <li>
          <div class="container-switch">
            <label class="switch">
            <input type="checkbox" checked id="<?php echo utf8_decode(strtolower(esc_html($post_type_obj->name))); ?>" name="<?php echo strtolower(esc_html($post_type_obj->name)); ?>" value="1">
            <span class="slider round"></span>
            </label>
            <span><?php echo esc_html($labels->name); ?></span>
          </div>
        </li>
        <?php
          } else {
          ?>
        <li>
          <div class="container-switch">
            <label class="switch">
            <input type="checkbox" id="<?php echo utf8_decode(strtolower(esc_html($post_type_obj->name))); ?>" name="<?php echo strtolower(esc_html($post_type_obj->name)); ?>" value="1">
            <span class="slider round"></span>
            </label>
            <span><?php echo esc_html($labels->name); ?></span>
          </div>
        </li>
        <?php
          }
          endforeach; ?>
      </ul>
      <input id="sendbtn" class="sendbtn" value="Save Changes" type="submit">
    </form>
    <p id="error" style="display:none;" class="flex-idx-admin-message flex-idx-admin-message-error"></p>
  </div>
  <?php wp_enqueue_media(); ?>
</div>
<script type='text/javascript'>
  jQuery(document).ready(function($){
  	var meta_gallery_frame;
  
  	jQuery('#boton_crear_galeria').click(function(e) {
  		e.preventDefault();
  		// Si el frame existe abre la modal.
          if ( meta_gallery_frame ) {
              meta_gallery_frame.open();
              return;
  		}		
          // Crea un nuevo frame de tipo galería
  		meta_gallery_frame = wp.media.frames.wp_media_frame = wp.media( {
  			title: 'Select a image to upload',
              button: {
                      text: 'Use this image',
                      },					
  			multiple: false
  		} );
  			// Abre la modal con el frame
  		meta_gallery_frame.open();
  
  		
          meta_gallery_frame.on('select', function() {
              attachment = meta_gallery_frame.state().get('selection').first().toJSON();
              $('#img_data').val(attachment.url).trigger('change');
          });
  
  	});
  
  
      var meta_gallery_frame_agent;
      jQuery('#boton_gallery_agent').click(function(e) {
  		e.preventDefault();
  		// Si el frame existe abre la modal.
          if ( meta_gallery_frame_agent ) {
              meta_gallery_frame_agent.open();
              return;
  		}		
          // Crea un nuevo frame de tipo galería
  		meta_gallery_frame_agent = wp.media.frames.wp_media_frame = wp.media( {
  			title: 'Select a image to upload',
              button: {
                      text: 'Use this image',
                      },					
  			multiple: false
  		} );
  			// Abre la modal con el frame
              meta_gallery_frame_agent.open();		
              meta_gallery_frame_agent.on('select', function() {
              attachment = meta_gallery_frame_agent.state().get('selection').first().toJSON();
              $('#url_img_agent').val(attachment.url).trigger('change');
          });
  
  	});
  
  });
  
  function checkIfValidlatitude(latitude_agent) {  
    var regexLat = new RegExp('^(\\+|-)?(?:90(?:(?:\\.0{1,6})?)|(?:[0-9]|[1-8][0-9])(?:(?:\\.[0-9]{1,6})?))$');  
    return regexLat.test(latitude_agent)
  }
  
  
  function checkIfValidlongitude(longitud_agent) {    
    var regexLong = new RegExp('^(\\+|-)?(?:180(?:(?:\\.0{1,6})?)|(?:[0-9]|[1-9][0-9]|1[0-7][0-9])(?:(?:\\.[0-9]{1,6})?))$');
    return regexLong.test(longitud_agent)
  }
  
  function validate() {   
      const latitude_agent = jQuery('#latitude_agent').val()
      const longitud_agent = jQuery('#longitud_agent').val()
      if(longitud_agent!==''&& latitude_agent!==''){      
        if(!checkIfValidlatitude(latitude_agent)){
            jQuery("#error").html("Invalid Latitude").show();
            return false
        }else{
            jQuery("#error").hide();
        }
    
        if(!checkIfValidlongitude(longitud_agent)){
            jQuery("#error").html("Invalid Longitude").show();
            return false
        }else{
            jQuery("#error").hide();
        }
    }
  }
  
</script>