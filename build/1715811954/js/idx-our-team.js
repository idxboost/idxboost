$=jQuery

$(document).ready(function() {
	fc_list_collection(idx_idxboost_our_team.category);
});

function fc_list_collection(vcategory){
	
	var CollectionEndpoint = idx_idxboost_our_team.ajaxUrl.replace(/{{registrationKey}}/g, idx_idxboost_our_team.reg_key );
	let arrItem = [];
	$.ajax({
		url: CollectionEndpoint,
		method: "POST",
		data: JSON.stringify({
			category: vcategory
		})
		,
		dataType: "json",
		success: function(response) {

			
			if (response.hasOwnProperty("success") && response.success) {

				response.data.forEach(function(item){

					let phoneMailto = item.phone.replace(/\D/gm,"");
					let slugAgent = idx_idxboost_our_team.agentDetailPermalink+"/"+item.agentSlug;

		            arrItem.push('<div class="ms-nw-result-item">');
		              arrItem.push('<div class="ms-nw-result-card">');
		                arrItem.push('<a href="'+slugAgent+'" class="ms-nw-card-media">');
		                  arrItem.push('<img src="'+item.avatar+'" alt="'+item.firstName+" "+item.lastName+'">');
		                  arrItem.push('<span>Contact</span>');
		                arrItem.push('</a>');
		                arrItem.push('<div class="ms-nw-card-info">');
		                  arrItem.push('<h3 class="ms-nw-card-title">');
		                    arrItem.push('<a href="'+slugAgent+'">'+item.firstName+" "+item.lastName+'</a>');
		                  arrItem.push('</h3>');
		                  arrItem.push('<span class="ms-nw-card-status">'+item.title+'</span>');
		                  arrItem.push('<a href="tel:+'+phoneMailto+'" class="ms-nw-card-phone-number">'+item.phone+'</a>');
		                  arrItem.push('<a href="mailto:'+item.email+'" class="ms-nw-card-email">'+item.email+'</a>');
		                  arrItem.push('<ul class="ms-nw-social-media-list">');
		                    if (item.instagram != "") {
		                    arrItem.push('<li><a href="'+item.instagram+'" class="ms-nw-social-media-item" title="Instagram"><i class="idx-icon-instagram"></i></a></li>');
		                    }

		                    if (item.linkedin != "") {
		                    arrItem.push('<li><a href="'+item.linkedin+'" class="ms-nw-social-media-item" title="Linkeding"><i class="idx-icon-linkedin2"></i></a></li>');
		                    }
		                    
		                    if (item.facebook !="") {
		                    arrItem.push('<li><a href="'+item.facebook+'" class="ms-nw-social-media-item" title="Facebook"><i class="idx-icon-facebook"></i></a></li>');
		                    }
		                    
		                    if (item.twitter !="") {
		                    arrItem.push('<li><a href="'+item.twitter+'" class="ms-nw-social-media-item" title="Twitter"><i class="idx-icon-twitter"></i></a></li>');
		                    }

		                    if (item.youtube != "") {
		                    arrItem.push('<li><a href="'+item.youtube+'" class="ms-nw-social-media-item" title="Youtube"><i class="idx-icon-youtube"></i></a></li>');
		                    }
		                    if (item.pinterest != "") {
		                    arrItem.push('<li><a href="'+item.pinterest+'" class="ms-nw-social-media-item" title="Pinterest"><i class="idx-icon-pinterest-p"></i></a></li>');

		                    }
		                  arrItem.push('</ul>');
		                arrItem.push('</div>');
		              arrItem.push('</div>');
		            arrItem.push('</div>');






				})				


			}

            $(".js-list-collection-agent").html(arrItem.join(""));


		}
	});	

}

		$(document).on("click", ".flex-slider-prev", function(event) {
			event.stopPropagation();
			var node = $(this).prev().find('li.flex-slider-current');
			var index = node.index();
			var total = $(this).prev().find('li').length;
			index = (index === 0) ? (total - 1) : (index - 1);
			$(this).prev().find('li').removeClass('flex-slider-current');
			$(this).prev().find('li').addClass('flex-slider-item-hidden');
			$(this).prev().find('li').eq(index).removeClass('flex-slider-item-hidden').addClass('flex-slider-current');
			myLazyLoad.update();


			// Open Registration popup after 3 property pictures are showed [force registration]
			if ("yes" === __flex_g_settings.anonymous) {
				if ( (__flex_g_settings.hasOwnProperty("force_registration")) && (1 == __flex_g_settings.force_registration) ) {
					countClickAnonymous++;
			
					if (countClickAnonymous >= 3) {
						$("#modal_login").addClass("active_modal")
						.find('[data-tab]').removeClass('active');
					
						$("#modal_login").addClass("active_modal")
							.find('[data-tab]:eq(1)')
							.addClass('active');
						
						$("#modal_login")
							.find(".item_tab")
							.removeClass("active");
						
						$("#tabRegister")
						.addClass("active");

						$("#modal_login #msRst").empty().html($("#mstextRst").html());
						$("button.close-modal").addClass("ib-close-mproperty");
						//$(".overlay_modal").css("background-color", "rgba(0,0,0,0.8);");

						/*TEXTO LOGIN*/
						var titleText = $(".header-tab a[data-tab='tabRegister']").attr('data-text')
						$("#modal_login .modal_cm .content_md .heder_md .ms-title-modal").html(titleText);
						countClickAnonymous = 0;
					}
				}
			}

		});

