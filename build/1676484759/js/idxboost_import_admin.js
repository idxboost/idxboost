!function(i){i(function(){var s=0;i(".btn_import_building").on("click",function(a){a.preventDefault(),function e(a){i(".flex-idx-admin-message").show().text("Download register, please wait...!!").addClass("flex-idx-admin-message-error").removeClass("flex-idx-admin-message-success");i(".btn_import_building").hide();i.ajax({url:flex_idx_admin_import_js.ajaxUrl,method:"POST",data:{action:"idxboost_import_building",page:a},dataType:"json",success:function(a){s=parseFloat(s)+1,0==a.status_data?i.ajax({url:flex_idx_admin_import_js.ajaxUrl,method:"POST",data:{action:"idx_import_tgbuilding_update"},dataType:"json",success:function(a){alert("import data success"),console.log(a),i(".flex-idx-admin-message").text("import data success !!"),i(".flex-idx-admin-message").addClass("flex-idx-admin-message-success").removeClass("flex-idx-admin-message-error"),i(".btn_import_building").show()}}):e(s)}})}(s=0)})})}(jQuery);