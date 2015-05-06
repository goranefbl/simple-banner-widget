(function ($) {
	"use strict";
	$(function () {
		$("body").on("change", ".goran-ad-size", function(e){
			if($(this).val() == "custom") {
				$(this).parent().next().show();
			} else {
				$(this).parent().next().hide();
			}
		});
		$("body").on("click", ".goran_add_ad", function(e){
			e.preventDefault();
			var widget_holder = $(this).closest('.widget-inside');
			var clone = widget_holder.find('.goran_ads_clone');
			console.log(clone);
			$('.goran_ad_holder').append(clone.html());
		});
		$("body").on("click", ".goran_remove_ad", function(e){
			e.preventDefault();
			$(this).parent().remove();
			console.log(ad_holder);
		});
	});
}(jQuery));