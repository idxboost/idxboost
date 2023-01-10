<?php
  defined('ABSPATH') || die();

  $post_ID = 999999991;
  $args = ['public' => true,];
   
  $store = [];
  
  if (isset($_POST)) {
                  
      if(isset($_POST['board_id'])){
          $store += array(
              'board_id' => $_POST['board_id']
          );  
      }
      if(isset($_POST['multicity'])){
          $store += array(
              'multicity' => $_POST['multicity']
          );  
      }
      if(isset($_POST['multicity_check'])){
          $store += array(
              'multicity_check' => $_POST['multicity_check']
          );  
      }
      
      if (!empty($store)) {
        update_post_meta($post_ID, '_quick_search', $store);
      }
  }
  $quick_search_data = get_post_meta($post_ID, '_quick_search', true);
  
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
  .form-table th{
    width: auto !important;
  }
</style>
<div class="wrap">
  <div class="container_options ms-schema-wrapper">
    <form id="save_quick_search_options" class="schema-form" method="post">   
      <!-- For Agents -->
      <h2 class="schema-form-h2">Information for Quick Search Rental</h2>
      <table class="form-table ms-schema-form-table ms-xd" id="id-agent-style">
        <tbody>
          <tr class="ms-full">
            <th scope="row">
              <label for="board_id">Board ID</label>
            </th>
            <td>
              <input class="board_id" name="board_id" type="text" id="board_id" value="<?php echo esc_html($quick_search_data['board_id']) ?>">
            </td>
          </tr>         
          <tr>
            <th scope="row">
              <label for="multicity">Multicity(IDs Cities)</label>
            </th>
            <td>
              <input class="multicity" name="multicity" type="text" id="multicity" value="<?php echo esc_html($quick_search_data['multicity']) ?>">                            
            </td>
          </tr>
          <tr>
            <th scope="row">
              <label for="multicity_check">Multicity Check(IDs Cities Mark as Default)</label>
            </th>
            <td>
              <input class="multicity_check" name="multicity_check" type="text" id="multicity_check" value="<?php echo esc_html($quick_search_data['multicity_check']) ?>">                            
            </td>
          </tr>   
        </tbody>
      </table>          
      <input id="sendbtn" class="sendbtn" value="Save Changes" type="submit">
    </form>
    <p id="error" style="display:none;" class="flex-idx-admin-message flex-idx-admin-message-error"></p>
  </div> 
</div>
