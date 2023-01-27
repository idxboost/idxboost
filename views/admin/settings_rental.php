<?php
defined('ABSPATH') || die();

$post_ID = 999999991;
$args = ['public' => true,];

$store = [];

if (isset($_POST)) {

  if (isset($_POST['board_id'])) {
    $store += array(
      'board_id' => $_POST['board_id']
    );
  }
  if (isset($_POST['multicity'])) {
    $store += array(
      'multicity' => $_POST['multicity']
    );
  }
  if (isset($_POST['multicity_check'])) {
    $store += array(
      'multicity_check' => $_POST['multicity_check']
    );
  }
  if (isset($_POST['office_code'])) {
    $store += array(
      'office_code' => $_POST['office_code']
    );
  }
  if (isset($_POST['latitude'])) {
    $store += array(
      'latitude' => $_POST['latitude']
    );
  }
  if (isset($_POST['longitud'])) {
    $store += array(
      'longitud' => $_POST['longitud']
    );
  }
  if (isset($_POST['zoom'])) {
    $store += array(
      'zoom' => $_POST['zoom']
    );
  }

  if (isset($_POST['switch_map'])) {
    $store += array(
      'switch_map' => $_POST['switch_map']
    );
  }

  if (isset($_POST['remove_map'])) {
    $store += array(
      'remove_map' => $_POST['remove_map']
    );
  }

  if (isset($_POST['autocomplete_tool_bar'])) {
    $store += array(
      'autocomplete_tool_bar' => $_POST['autocomplete_tool_bar']
    );
  }
  if (isset($_POST['autocomplete_more_filter'])) {
    $store += array(
      'autocomplete_more_filter' => $_POST['autocomplete_more_filter']
    );
  }
  if (isset($_POST['cities_tool_bar'])) {
    $store += array(
      'cities_tool_bar' => $_POST['cities_tool_bar']
    );
  }
  if (isset($_POST['cities_more_filter'])) {
    $store += array(
      'cities_more_filter' => $_POST['cities_more_filter']
    );
  }

  if (!empty($store)) {
    update_post_meta($post_ID, '_settings_rental', $store);
  }
}
$settings_rental_data = get_post_meta($post_ID, '_settings_rental', true);

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

  #id-agent-style input[type=text] {
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

    #id-agent-style input[type=text] {
      width: 100% !important;
    }

    .idx_map_style {
      height: 200px !important;
      width: 100% !important;
    }
  }

  .gallery {
    display: flex;
    flex-direction: column;
  }

  .btn_gallery {
    align-items: left;
    align-self: left;
    margin-top: .4rem;
  }

  input.btn_gallery,
  input.sendbtn {
    width: 120px !important;
    display: inline-block;
    padding: 0.2em .45em !important;
    margin: 0.1em !important;
    border: 0.15em solid #CCCCCC;
    box-sizing: border-box;
    text-decoration: none;
    font-family: 'Segoe UI', 'Roboto', sans-serif;
    font-weight: 400;
    color: #000000;
    background-color: #CCCCCC;
    text-align: center;
    position: relative;
  }

  input.btn_gallery:hover,
  input.sendbtn:hover {
    border-color: #7a7a7a;
    cursor: pointer;
  }

  input.btn_gallery:active,
  input.sendbtn:active {
    background-color: #999999;
  }

  @media all and (max-width:30em) {

    input.btn_gallery,
    input.sendbtn {
      display: block;
      margin: 0.2em auto;
    }
  }

  .ms-schema-wrapper .schema-form-h2 {
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

  .ms-schema-wrapper .ms-input-file {
    display: flex;
    flex-direction: row;
  }

  .ms-schema-wrapper .ms-input-file .ms-file {
    max-width: calc(100% - 130px) !important;
    border-radius: 0;
    border-top-left-radius: 4px;
    border-bottom-left-radius: 4px;
    background-color: #FFF;
    flex-grow: 1;
  }

  .ms-schema-wrapper .ms-input-file .ms-file-btn {
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

  .ms-schema-wrapper .ms-input-file .ms-file-btn:hover {
    background-color: #707070;
  }

  .ms-schema-wrapper .ms-block-msg {
    max-width: 100%;
    padding: 15px;
    border-radius: 6px;
    color: #004085;
    background-color: #cce5ff;
    border-color: #b8daff;
    margin: 15px 0;
  }

  .ms-schema-wrapper .sendbtn {
    min-height: 45px;
    border: 0 !important;
    background: #333;
    color: #FFF;
    transition: all .3s;
    border-radius: 4px;
    width: 140px !important;
    transition: all .3s;
  }

  .ms-schema-wrapper .sendbtn:hover {
    background-image: linear-gradient(90deg, rgba(239, 61, 78, 1) 0%, rgba(204, 50, 90, 1) 60%, rgba(174, 40, 101, 1) 100%);
  }

  .ms-schema-wrapper input:checked+.slider {
    background-color: #333;
  }

  @media screen and (min-width: 768px) {
    .ms-schema-form-table tbody {
      display: flex;
      flex-wrap: wrap;
    }

    .ms-schema-form-table tbody tr {
      display: flex;
      flex-direction: column;
      width: 47%;
      padding: 0 10px;
    }

    .ms-schema-form-table tbody tr th {
      margin-bottom: 5px
    }

    .ms-schema-form-table tbody tr td,
    .ms-schema-form-table tbody tr th {
      padding: 0;
    }

    .ms-schema-form-table tbody tr.ms-full {
      width: 100%;
    }

    .ms-schema-wrapper .schema-form-h2 {
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

  @media screen and (min-width: 1024px) {
    .ms-schema-wrapper {
      max-width: 700px;
    }
  }

  .form-table th {
    width: auto !important;
  }
</style>
<div class="wrap">
  <div class="container_options ms-schema-wrapper">
    <form id="save_quick_search_options" class="schema-form" method="post" onsubmit="return validate();">
      <!-- For Agents -->
      <h2 class="schema-form-h2">Information general for Quick Search and Vacation Rental</h2>
      <table class="form-table ms-schema-form-table ms-xd" id="id-agent-style">
        <tbody>
          <tr class="ms-full">
            <th scope="row">
              <label for="board_id">Board ID</label>
            </th>
            <td>
              <input class="board_id" name="board_id" type="text" id="board_id" value="<?php
              if (!empty($settings_rental_data)) {
              echo esc_html($settings_rental_data['board_id']);
              }
              ?>">
            </td>
          </tr>
          <tr>
            <th scope="row">
              <label for="multicity">Multicity(IDs Cities)</label>
            </th>
            <td>
              <input class="multicity" name="multicity" type="text" id="multicity" value="<?php 
               if (!empty($settings_rental_data)) {echo esc_html($settings_rental_data['multicity']);} ?>">
            </td>
          </tr>
          <tr>
            <th scope="row">
              <label for="multicity_check">Multicity Check(IDs Cities Mark as Default)</label>
            </th>
            <td>
              <input class="multicity_check" name="multicity_check" type="text" id="multicity_check" value="<?php
               if (!empty($settings_rental_data)) { echo esc_html($settings_rental_data['multicity_check']);} ?>">
            </td>
          </tr>
        </tbody>
      </table>
      <h2 class="schema-form-h2">Information for Vacation Rental</h2>
      <table class="form-table ms-schema-form-table ms-xd" id="id-agent-style">
        <tbody>
          <tr class="ms-full">
            <th scope="row">
              <label for="office_code">Office Code</label>
            </th>
            <td>
              <input class="office_code" name="office_code" type="text" id="office_code" value="<?php
               if (!empty($settings_rental_data)) { echo esc_html($settings_rental_data['office_code']);} ?>">
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
              <label for="latitude">Latitude</label>
            </th>
            <td>
              <input class="latitude" name="latitude" type="text" id="latitude" value="<?php 
               if (!empty($settings_rental_data)) {echo esc_html($settings_rental_data['latitude']);} ?>">
            </td>
          </tr>
          <tr>
            <th scope="row">
              <label for="longitud">Longitud</label>
            </th>
            <td>
              <input class="longitud" name="longitud" type="text" id="longitud" value="<?php 
               if (!empty($settings_rental_data)) {echo esc_html($settings_rental_data['longitud']);} ?>">
            </td>
          </tr>
          <tr>
            <th scope="row">
              <label for="zoom">Zoom</label>
            </th>
            <td>
              <input class="zoom" name="zoom" type="text" id="zoom" value="<?php
               if (!empty($settings_rental_data)) { echo esc_html($settings_rental_data['zoom']);} ?>">
            </td>
          </tr>

        </tbody>
      </table>
      <h2 class="schema-form-h2">Settings for Autocomplete and Cities</h2>
      <table class="form-table ms-schema-form-table ms-xd" id="id-agent-style">
        <tbody>                   
          <tr>
            <th scope="row">
              <label for="">Show AutoComplete on</label>
            </th>
            <td>
            <div class="container-switch">
            <label class="switch">
            <input type="checkbox" <?php 
            if (!empty($settings_rental_data)) {
            if(esc_html($settings_rental_data['autocomplete_tool_bar'])!=="") echo 'checked'; else echo '';
            }
            ?> id="autocomplete_tool_bar" name="autocomplete_tool_bar" value="1">
            <span class="slider round"></span>
            </label>
            <span>Main Tool Bar </span>
          </div>
            </td>
          </tr>
          <tr>
            <th scope="row">
              <label for="">&nbsp;</label>
            </th>
            <td>
            <div class="container-switch">
            <label class="switch">
            <input type="checkbox" <?php 
            if (!empty($settings_rental_data)) {
            if(esc_html($settings_rental_data['autocomplete_more_filter'])!=="") echo 'checked'; else echo '';}
            ?> id="autocomplete_more_filter" name="autocomplete_more_filter" value="1">
            <span class="slider round"></span>
            </label>
            <span>More Filters</span>
          </div>
            </td>
          </tr>
          <tr>
            <th scope="row">
              <label for="">Show Cities on</label>
            </th>
            <td>
            <div class="container-switch">
            <label class="switch">
            <input type="checkbox" <?php 
            if (!empty($settings_rental_data)) {if(esc_html($settings_rental_data['cities_tool_bar'])!=="") echo 'checked'; else echo '';}
            ?> id="cities_tool_bar" name="cities_tool_bar" value="1">
            <span class="slider round"></span>
            </label>
            <span>Main Tool Bar </span>
          </div>
            </td>
          </tr>
          <tr>
            <th scope="row">
              <label for="">&nbsp;</label>
            </th>
            <td>
            <div class="container-switch">
            <label class="switch">
            <input type="checkbox" <?php 
            if (!empty($settings_rental_data)) {if(esc_html($settings_rental_data['cities_more_filter'])!=="") echo 'checked'; else echo '';}
            ?> id="cities_more_filter" name="cities_more_filter" value="1">
            <span class="slider round"></span>
            </label>
            <span>More Filters</span>
          </div>
            </td>
          </tr>    
        </tbody>
      </table>

      <h2 class="schema-form-h2">Options for Maps</h2>
      <ul class="ks-cboxtags">  
        <li>
          <div class="container-switch">
            <label class="switch">
            <input type="checkbox" <?php
            if (!empty($settings_rental_data)) { if(esc_html($settings_rental_data['remove_map'])!=="") echo 'checked'; else echo '';}
            ?> id="remove_map" name="remove_map" value="1">
            <span class="slider round"></span>
            </label>
            <span>Remove Map</span>
          </div>
        </li>

        <li>
          <div class="container-switch">
            <label class="switch">
            <input type="checkbox" <?php 
            if (!empty($settings_rental_data)) {if(esc_html($settings_rental_data['remove_map'])!=="") echo 'disabled'; else echo '';}
            ?> 
            <?php 
            if (!empty($settings_rental_data)) {if(esc_html($settings_rental_data['switch_map'])!=="") echo 'checked'; else echo '';}
            ?> id="switch_map" name="switch_map" value="1">
            <span class="slider round"></span>
            </label>
            <span>Hide Map</span>
          </div>
        </li>        
        
        
      </ul>

      <input id="sendbtn" class="sendbtn" value="Save Changes" type="submit">
    </form>
    <p id="error" style="display:none;" class="flex-idx-admin-message flex-idx-admin-message-error"></p>
  </div>
</div>

<script type='text/javascript'>
  function checkIfValidlatitude(latitude) {
    var regexLat = new RegExp('^(\\+|-)?(?:90(?:(?:\\.0{1,6})?)|(?:[0-9]|[1-8][0-9])(?:(?:\\.[0-9]{1,6})?))$');
    return regexLat.test(latitude)
  }

  function checkIfValidlongitude(longitud) {
    var regexLong = new RegExp('^(\\+|-)?(?:180(?:(?:\\.0{1,6})?)|(?:[0-9]|[1-9][0-9]|1[0-7][0-9])(?:(?:\\.[0-9]{1,6})?))$');
    return regexLong.test(longitud)
  }

  function validate() {
    const latitude = jQuery('#latitude').val()
    const longitud = jQuery('#longitud').val()
    if (longitud !== '' && latitude !== '') {
      if (!checkIfValidlatitude(latitude)) {
        jQuery("#error").html("Invalid Latitude").show();
        return false
      } else {
        jQuery("#error").hide();
      }

      if (!checkIfValidlongitude(longitud)) {
        jQuery("#error").html("Invalid Longitude").show();
        return false
      } else {
        jQuery("#error").hide();
      }
    }
  }
</script>