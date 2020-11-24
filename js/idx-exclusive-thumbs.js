var flex_filter_form=$('#idx_thumb_exclusive_listing');

$('.propertie').on('click',function(event){
    event.preventDefault();
});

    function fc_idx_exclusive() {

        if (flex_filter_form.length) {
            var flex_form_data = flex_filter_form.serialize();

            $.ajax({
                url: flex_idx_filter_params.ajaxUrl,
                type: "POST",
                data: flex_form_data,
                dataType: "json",
                success: function(response) {

                    var items = response.items;
                    var listingHTML = [];
                    listingHTML.push('<div class="clidxboost-properties-slider gs-container-slider tab-slider" id="slider-rent"><ul class="result-search slider-generator">');
                    for (var i = 0, l = items.length; i < l; i++) {
	                        var item = response.items[i];
	                        item.address_short = item.address_short.replace(/# /, "#");
	                        item.address_large = item.address_large.replace(/ , /, ", ");

	                        var al = item.address_large.split(", ");
	                        var st = al[1].replace(/[\d\s]/g, "");
	                        var final_address = item.address_short + " " + al[0] + ", " + st;
	                        var final_address_parceada = item.address_short + " <span>" + al[0] + ", " + al[1] + "</span>";

	                        var final_address_parceada_new = " <span>"+ item.address_short.replace(/# /, "#") +", " + al[0] + ", " + al[1] + "</span>";

	                        listingHTML.push('<li data-geocode="' + item.lat + ':' + item.lng + '" data-class-id="' + item.class_id + '" data-mls="' + item.mls_num + '" data-address="'+item.address_short+'" class="propertie">');
	                        if (item.hasOwnProperty("status")) {
	                            if (item.status == "5") {
	                                listingHTML.push('<div class="flex-property-new-listing">'+word_translate.rented+'!</div>');
	                            } else if (item.status == "2") {
	                                listingHTML.push('<div class="flex-property-new-listing">'+word_translate.sold+'!</div>');
	                            }
	                        } else {
	                            if (item.recently_listed === "yes") {
	                                listingHTML.push('<div class="flex-property-new-listing">'+word_translate.new_listing+'!</div>');
	                            }
	                        }
	                        if (view_grid_type=='1'){
	                            listingHTML.push('<h2 title="' + item.full_address + '"><span>'+item.full_address_top+'</span><span>'+item.full_address_bottom+'</span></h2>');
	                        }else{
	                            listingHTML.push('<h2 title="' + item.full_address + '"><span>' + item.full_address + '</span></h2>');
	                        }

	                        listingHTML.push('<ul class="features">');
	                        listingHTML.push('<li class="address">' + item.full_address + '</li>');
	                        listingHTML.push('<li class="price">$' + _.formatPrice(item.price) + '</li>');
	                        if (item.reduced == '') {
	                            listingHTML.push('<li class="pr">' + item.reduced + '</li>');
	                        } else if (item.reduced < 0) {
	                            listingHTML.push('<li class="pr down">' + item.reduced + '%</li>');
	                        } else {
	                            listingHTML.push('<li class="pr up">' + item.reduced + '%</li>');
	                        }
	                        var textbed = word_translate.bed;
	                        if (item.bed > 1) {
	                            textbed = word_translate.beds;
	                        } else {
	                            textbed = word_translate.bed;
	                        }
	                        listingHTML.push('<li class="beds">' + item.bed + ' <span>' + textbed + ' </span></li>');
	                        var textbath = word_translate.bath;
	                        if (item.bath > 1) {
	                            textbath = word_translate.baths;
	                        } else {
	                            textbath = word_translate.bath;
	                        }
	                        if (item.baths_half > 0) {
	                            listingHTML.push('<li class="baths">' + item.bath + '.5 <span>' + textbath + ' </span></li>');
	                        } else {
	                            listingHTML.push('<li class="baths">' + item.bath + ' <span>' + textbath + ' </span></li>');
	                        }
	                        listingHTML.push('<li class="living-size"> <span>' + _.formatPrice(item.sqft) + '</span>'+word_translate.sqft+' <span>(' + item.living_size_m2 + ' m2)</span></li>');
	                        listingHTML.push('<li class="price-sf"><span>$' + item.price_sqft + ' </span>/ '+word_translate.sqft+'<span>($' + item.price_sqft_m2 + ' m2)</span></li>');
	                        if (item.development !== '') {
	                            listingHTML.push('<li class="development"><span>' + item.development + '</span></li>');
	                        } else if (item.complex !== '') {
	                            listingHTML.push('<li class="development"><span>' + item.complex + '</span></li>');
	                        } else {
	                            listingHTML.push('<li class="development"><span>' + item.subdivision + '</span></li>');
	                        }
	                        listingHTML.push('</ul>');
	                        var totgallery='';
	                        if (item.gallery.length <= 1) {
	                            totgallery='no-zoom';
	                        }
	                        listingHTML.push('<div class="wrap-slider '+totgallery+'">');
	                        listingHTML.push('<ul>');
	                        for (var k = 0, m = item.gallery.length; k < m; k++) {
	                            // listingHTML.push('<li><img src="' + item.gallery[k] + '" data-src="' + item.gallery[k] + '" alt="' + item.full_address + '"></li>');
	                            if (k <= 0) {
	                                listingHTML.push('<li class="flex-slider-current"><img class="flex-lazy-image" data-original="' + item.gallery[k] + '" alt="' + item.full_address + '"></li>');
	                            } else {
	                                listingHTML.push('<li class="flex-slider-item-hidden"><img class="flex-lazy-image" data-original="' + item.gallery[k] + '" alt="' + item.full_address + '"></li>');
	                            }
	                        }
	                        listingHTML.push('</ul>');
	                        if (item.gallery.length > 1) {
	                            listingHTML.push('<button class="prev flex-slider-prev" aria-label="Prev"><span class="clidxboost-icon-arrow-select"></span></button>');
	                            listingHTML.push('<button class="next flex-slider-next" aria-label="Next"><span class="clidxboost-icon-arrow-select"></span></button>');
	                        }

	                        if (!item.hasOwnProperty("status")) {
	                            if (item.is_favorite) {
	                                listingHTML.push('<button class="clidxboost-btn-check flex-favorite-btn" aria-label="Remove Favorite"><span class="clidxboost-icon-check active"></span></button>');
	                            } else {
	                                listingHTML.push('<button class="clidxboost-btn-check flex-favorite-btn" aria-label="Save Favorite"><span class="clidxboost-icon-check"></span></button>');
	                            }
	                        }

	                        listingHTML.push('</div>');
	                        listingHTML.push('<a href="#" class="view-detail">'+item.full_address+'</a>');
	                        listingHTML.push('<a class="view-map-detail" data-geocode="'+item.lat + ':' + item.lng+'">View Map</a>');
	                        listingHTML.push('</li>');
                    }
                    listingHTML.push('</ul></div>');
                    $('.cw-tab-item-rent').html(listingHTML.join(''));
                    myLazyLoad.update();







                }
            });
        }
    }
