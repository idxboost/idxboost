_.mixin({
	/**
	 * Number.prototype.format(n, x, s, c)
	 * 
	 * @param integer n: length of decimal
	 * @param integer x: length of whole part
	 * @param mixed   s: sections delimiter
	 * @param mixed   c: decimal delimiter
	 */
	formatPrice: function(value, n, x, d, c, s, p) {
	    var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\D' : '$') + ')',
	        num = Number(value).toFixed(Math.max(0, ~~n));
    
    	return (s && p ? s : '') + (c ? num.replace('.', c) : num).replace(new RegExp(re, 'g'), '$&' + (d || ',')) + (s && !p ? s : '');
	},
	formatShortPrice: function (value) {
		var price = Number(value),
        	short_price;
        
        if (price < 1000) {
            return price;
        }
        
        if (price < 10000) {
            short_price = Math.ceil(price / 100) / 10;
            
            return short_price + 'K';
        } else {
            if (price < 1000000) {
                short_price = Math.ceil(price / 1000);
                
                if (short_price < 100) {
                    return String(short_price).substr(0, 2) + 'K';
                }
                
                if (short_price >= 1000) {
                    return '1M';
                }
                
                return short_price + 'K';
            } else {
                if (price < 10000000) {
                    short_price = Math.ceil(price / 10000) / 100;
                } else {
                    short_price = Math.ceil(price / 100000) / 10;
                }
            }
        }
        
        if (String(short_price, '.') !== -1) {
            short_price = String(short_price).substr(0, 4);
        }
        
        return short_price + 'M';
	},
    sortByKey: function(rows, key, order) {
        return (order === 'ASC') ? _.sortBy(rows, key) : _.sortBy(rows, key).reverse();
    },
    getMinByKey: function(rows, key) {
        return _.min(rows, function(item) {
            return item[key];
        });
    },
    getMaxByKey: function(rows, key) {
        return _.max(rows, function(item) {
           return item[key]; 
        });
    },
    getMinPriceShort: function(price) {
        return _.formatShortPrice(_.min(price));
    },
    getMaxPriceShort: function(price) {
        return _.formatShortPrice(_.max(price));
    },
    getMLSImage: function(mls_num, image) {
        var base_url = '//retsimages.s3.amazonaws.com';
        var path = mls_num.substr(-2);
        
        return [base_url, path, image].join("/");
        
    }
});