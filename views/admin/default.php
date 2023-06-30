<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
<style>
  /*NEW ADMIN STYLE*/
  @media screen and (max-width: 782px){
    .auto-fold #wpcontent {
      padding-right: 15px;
      padding-left: 15px;
    }
  }

  #wpbody-content{
    width: 100%;
    padding: 40px 0;
  }

  .wrap{
    margin: 0 auto;
    width: 100%;
    max-width: 490px;
    text-align: center;
  }

  #wpwrap{
    background: rgb(239,61,78);
    background: linear-gradient(90deg, rgba(239,61,78,1) 0%, rgba(204,50,90,1) 60%, rgba(174,40,101,1) 100%);
    overflow-x: hidden;
  }

  .logo-idx{
    width: 250px;
    margin: 0 auto;
  }

  .logo-idx img{
    width: auto;
    max-width: 100%;
  }

  .flex-ms-wrapper h1{
    font-family: 'Montserrat', sans-serif;
    font-size: 35px;
    line-height: 1.1;
    margin: 15px 0;
    font-weight: bold;
    color: #FFF
  }

  .flex-update-version{
    color: #FFF;
    font-size: 15px;
    font-family: 'Open Sans', sans-serif;
  }

  .flex-update-version a{
    color: #FFF;
  }

  .flex-update-version strong{
    font-weight: 600
  }

  #flex_idx_client_form .form-table{
    margin-top: 15px
  }

  #flex_idx_client_form .form-table label{
    display: none
  }

  #flex_idx_client_form .form-table #flex-idx-settings-client-id{
    background: transparent;
    font-size: 15px;
    font-family: 'Open Sans', sans-serif;
    border-color: rgba(255,255,255,0.45);
    color: #FFF;
    padding: 10px 15px 10px 50px;
    position: relative;
    z-index: 2;
    border-radius: 8px;
  }

  #flex_idx_client_form .form-table .flex-wrapper-text{
    position: relative;
  }

  #flex_idx_client_form .form-table .flex-wrapper-text:before{
    content: "";
    background: url('<?php echo FLEX_IDX_URI; ?>images/new-admin-icons.png') no-repeat -1px -34px;
    width: 26px;
    height: 26px;
    position: absolute;
    top: 50%;
    margin-top: -13px;
    left: 15px;
    z-index: 0;
  }

  .submit .btn-content-idx{
    position: relative;
    width: 100%;
    height: 52px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
    background-color: #2b3547;
    transition: all .3s
  }

  .submit .btn-content-idx:hover{
    background-color: #333;
  }

  .submit .btn-content-idx:before{
    content: "";
    background: url('<?php echo FLEX_IDX_URI; ?>images/new-admin-icons.png') no-repeat -37px -35px;
    width: 24px;
	  height: 24px;
    position: absolute;
    top: 50%;
    margin-top: -12px;
    left: 20px;
    z-index: 0;
  }

  .submit .btn-content-idx .btn-site{
    position: absolute;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    background: transparent;
    border: 0;
    color: #FFF;
    font-size: 14px;
    font-weight: 600;
    font-family: 'Open Sans', sans-serif;
    margin: 0;
    cursor: pointer;
  }

  .flex-info-synchronize p{
    font-family: 'Open Sans', sans-serif;
    font-size: 15px;
    line-height: 1.4;
    color: #FFF;
  }

  #wpfooter{
    display: none
  }

  .flex-ms-by{
    display: inline-block;
    font-size: 15px;
    color: rgba(255,255,255,0.5);
    margin: 50px auto 0 auto;
  }

  .flex-ms-by a{
    display: inline-block;
    position: relative;
    width: 120px;
    text-indent: -999999px;
    background: url('<?php echo FLEX_IDX_URI; ?>images/new-admin-icons.png') no-repeat -1px -2px;
    width: 120px;
    height: 23px;
  }

  @media screen and (min-width: 782px){
    #wpbody-content{
      padding-top: 0 !important;
    }

    #wpbody{
      position: fixed;
      bottom: 0;
      right: 0;
      width: calc(100% - 180px);
      height: calc(100vh - 50px);
      background-image: url('<?php echo FLEX_IDX_URI; ?>images/new-admin-rocket.png');
      background-position: 78px 78px;
      background-repeat: no-repeat;
    }

    #wpcontent{
      /*background-image: url('<?php echo FLEX_IDX_URI; ?>images/new-admin-rocket.png');
      background-position: 78px 78px;
      background-repeat: no-repeat;
      position: fixed;*/
      top: 0;
      left: 0;
      width: 100%;
      height: 100vh;
    }

    .wrap {
      text-align: left;
      margin: 0;
      max-width: 89%
    }

    .logo-idx {
      width: 100%;
      margin: 0;
      margin-top: 50px
    }

    #wpbody-content{
      padding-top: 70px
    }

    .flex-ms-wrapper{
      padding-left: 60px;
      max-width: 460px
    }

    .flex-ms-wrapper h1{
      font-size: 50px;
      letter-spacing: -1px;
    }

    .form-table td{
      padding-left: 0;
      padding-right: 0
    }

    #flex_idx_client_form .form-table #flex-idx-settings-client-id{
      padding: 15px 15px 15px 75px
    }

    #flex_idx_client_form .form-table .flex-wrapper-text:before{
      left: 28px; 
    }

    .submit .btn-content-idx {
      width: 330px;
      height: 65px;
      border-radius: 13px;
    }

    .submit .btn-content-idx .btn-site{
      padding-left: 60px;
      font-size: 15px
    }

    .submit .btn-content-idx:before {
      left: 30px;
    }

    .flex-info-synchronize p{
      margin-bottom: 20px;
    }

    .flex-ms-by{
      position: fixed;
      right: 25px;
      bottom: 25px
    }
  }
</style>
<div class="wrap" id="idx-upload-form">
  <div id="flex-idx-status"></div>
  <div class="logo-idx">
    <img src="<?php echo FLEX_IDX_URI; ?>images/new-admin-logo.png">
  </div>
  <div class="flex-ms-wrapper">
    <h1>IDXBoost <br>Wordpress Plugin</h1>
    <span class="flex-update-version">You are using version <strong>4.6.7</strong> <a href="#">Click here for plugin updates</a></span>
    <form method="post" id="flex_idx_client_form">
      <input type="hidden" name="action" value="flex_connect">
      <table class="form-table">
        <tbody>
          <tr>
            <td>
              <label for="flex-idx-settings-client-id">Registration Key</label>
              <div class="flex-wrapper-text">
                <input type="text" id="flex-idx-settings-client-id" name="idxboost_registration_key" value="<?php echo $idxboost_registration_key; ?>" class="widefat" required>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
      <p class="submit">
        <span class="btn-content-idx">
          <input type="submit" value="Save Control Panel Changes" id="flex_idx_verify_credentials" class="btn-site">
        </span>
      </p>
      <?php
      if (('active' == get_option('idxboost_client_status')) && (false === get_option('idxboost_import_initial_data'))):
        $c_search_settings = get_option("idxboost_search_settings");
        if (isset($c_search_settings["board_id"]) && ("1" == $c_search_settings["board_id"])):
      ?>
      <?php /*
      <p>
        <button id="flex_idx_import_data" type="button" style="padding:10px 30px;font-size:15px;background:#31a01e;border:0;color:#fff;cursor:pointer;font-weight:normal;">Import Data?</button>
        <a href="#" id="flex_idx_omit_import_data" class="flex_idx_omit_import_data"> No, Thanks.</a>
      </p> */ ?>
      <?php endif; endif; ?>
      <div class="flex-info-synchronize">
        <p>Important! Some edits from the Control Panel need to synchronized with your Wordpress dashboard to reflect in your website; All edits of personal information from My Account (Phone, email, etc...)</p>
        <p>New Filter Pages & Building Pages (Only the first time your create them,  edits do not require synchronization.</p>
      </div>
    </form>
    <span class="flex-ms-by">
      create by <a href="https://www.tremgroup.com/" target="_blank">TREMGROUP</a>
    </span>
  </div>
</div>
