!function(a){a(function(){a("#form-calculator").submit(function(t){t.preventDefault(),a(this).calculatemortgage()}),a(document).on("click","#calculator-mortgage",function(t){t.preventDefault();t=a("#calculator-mortgage").data("price");a(".purchase_price_txt").val(t),a(".mortgage_mount_txt").text("$0"),a(".down_paymentamount_txt").text("$0"),a(".mortgage_amount_txt").text("$0"),a("#form-calculator").trigger("submit")}),a(".purchase_price_txt").focusout(function(t){a(this).val(a(this).val().replace(/,/g,"").replace(/\./g,"")),a(this).val(a(".purchase_price_txt").val().toString().replace(/\B(?=(\d{3})+(?!\d))/g,","))})})}(jQuery);