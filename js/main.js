(function(window, $){
	"use strict";
	
	$(document).foundation();
	$(document).ready(function() {
		$(".rf-accounts-table").dataTable();
	
		var $cache = $(".rf-options-container");
	
		$cache.css("width", $cache.parent().width());

		var vTop = $cache.offset().top - parseFloat($cache.css("marginTop").replace(/auto/, 0));
		$(window).scroll(function (event) {
			var y = $(this).scrollTop();

			if (y >= vTop) {
				$cache.addClass("stuck");
			} else {
				$cache.removeClass("stuck");
			}
		});

		$(".rf-question-option-container").bind("click", function(e){
			var $this = $(this);
			var $parent = $this.parents(".rf-question-container");
			var type = $parent.data("type");
		
			switch(type){
				case "multiselect":
					$this.toggleClass("selected");
				
					(""+$this.data("results")).split(",").map(function(id){
					
						if (!$.isNumeric(id)){
							return true;
						}
					
						var $option = $(".rf-option[data-option="+id+"]");
					
						var currentCount = +$option.find(".rf-option-count").data("count");
					
						if ($this.hasClass("selected")){
							$option.addClass("has-points").find(".rf-option-count").data("count", ++currentCount).text(currentCount);
						} else {
							$option.find(".rf-option-count").data("count", --currentCount);
						
							if (currentCount){
								$option.addClass("has-points").find(".rf-option-count").text(currentCount)
							} else {
								$option.removeClass("has-points").find(".rf-option-count").text("");
							}
						}
					
						$option.addClass("hit");
					
						setTimeout(function($ele){
							$ele.removeClass("hit");
						}, 200, $option);
					});
				
					break;
			
				case "radio":
					$this.toggleClass("selected");
									
					(""+$this.data("results")).split(",").map(function(id){
					
						if (!$.isNumeric(id)){
							return true;
						}
					
						var $option = $(".rf-option[data-option="+id+"]");
					
						var currentCount = +$option.find(".rf-option-count").data("count");
				
						if ($this.hasClass("selected")){
							$option.addClass("has-points").find(".rf-option-count").data("count", ++currentCount).text(currentCount);
						} else {
							$option.find(".rf-option-count").data("count", --currentCount);
						
							if (currentCount){
								$option.addClass("has-points").find(".rf-option-count").text(currentCount)
							} else {
								$option.removeClass("has-points").find(".rf-option-count").text("");
							}
						}
					
						$option.addClass("hit");
					
						setTimeout(function($ele){
							$ele.removeClass("hit");
						}, 200, $option);
					});
				
					$this.parent().parent().find(".rf-question-option-container.selected").not($this).removeClass("selected").each(function(){
						(""+$(this).data("results")).split(",").map(function(id){
						
							if (!$.isNumeric(id)){
								return true;
							}
						
							var $option = $(".rf-option[data-option="+id+"]");
						
							var currentCount = +$option.find(".rf-option-count").data("count");
					
							$option.find(".rf-option-count").data("count", --currentCount);
						
							if (currentCount){
								$option.addClass("has-points").find(".rf-option-count").text(currentCount)
							} else {
								$option.removeClass("has-points").find(".rf-option-count").text("");
							}
						
							$option.addClass("hit");
						
							setTimeout(function($ele){
								$ele.removeClass("hit");
							}, 200, $option);
						});
					});
				
				
					break;
			}
		
		});
	});
})(window, jQuery);