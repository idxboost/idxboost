!function(e){var n;e(function(){(n=e("#flex_idx_pages_form")).length&&n.on("submit",function(a){a.preventDefault(),e.ajax({url:flex_idx_admin_pages_js.ajaxUrl,method:"POST",data:n.serialize(),dataType:"json",success:function(a){alert(a.message),window.location.reload(!1)}})})})}(jQuery);