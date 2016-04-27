(function(window, $){
	"use strict";
	
	$.extend(window.rf, {
		"questionBuilder": function(e){
			var $modalTemplate = $("#question-modal");
			var $ele = $modalTemplate.data("modalRefEle");
			var data = $modalTemplate.data("qdata");
			var categories = [];
			
			$modalTemplate.find("select[name=categories]").find("option:selected").each(function(){
				categories.push( +$(this).data("category") );
			});
			
			data["name"] = $modalTemplate.find("input[name=name]").val();
			data["question"] = $modalTemplate.find("input[name=question]").val();
			data["type"] = $modalTemplate.find("select[name=type]").val();
			data["categories"] = categories;
	
			var options = [];
		
			$modalTemplate.find(".accordion-content").each(function(){
				var id = $(this).data("option");
				var optionName = $(this).find(".option-name").val();
				var optionDescription = $(this).find(".option-description").val();
				var optionImage = $(this).find(".rf-option-image-url").val();
				var optionItems = [];

				$(this).find("select.rf-question-option-points").find("option:selected").each(function(){
					optionItems.push( +$(this).data("point") );
				});
		
				options.push({
					"name": optionName,
					"description": optionDescription,
					"image": optionImage,
					"id": id,
					"results": optionItems
				});
			});
	
			data["options"] = options;
	
			$ele.attr("qdata", data).text( data.name );
			
			$("#question-"+data.id+"-categories").text( 
				data.categories.map(function(id){
					return rf.data.categories[ +id ].text;
				}).join(", ")
			);
			
			rf.data.questions[ data.id ] = data;
	
			$("#rf-questionnaire-json-data").val( JSON.stringify(rf.data) );
	
			$("#question-modal").foundation("close");
				
			return false;
		},
		"deleteQuestion": function(e){
			var $modalTemplate = $("#question-modal-delete");
			var $ele = $modalTemplate.data("modalRefEle");
			var data = $modalTemplate.data("qdata");
			var $rftable = $(".rf-questionnaire-questions");
			var dt = $rftable.DataTable();
		
			delete rf.data.questions[ data.id ];
		
			var i=0;
			rf.data.questions = rf.data.questions.filter(function(v){ v.id = i++; return v; });
	
			dt.clear().draw();
		
			for(var id in rf.data.questions){
				var qdata = rf.data.questions[id];
				rf.addQuestion(qdata);
			}
		
			$("#rf-questionnaire-json-data").val( JSON.stringify(rf.data) );
		
			$("#question-modal-delete").foundation("close");
		
			return false;
		},
		"deleteQuestionOption": function(ele){
			var $modalTemplate = $("#question-option-modal-delete");
		
			$modalTemplate.data("modalRefEle").remove();
		
			$modalTemplate.foundation("close");
			$("#question-modal").foundation("open");
		},
		"saveQuestionPoint": function(ele){
			var $parent = $(ele).parent();
			var optionName = $parent.siblings().first().children("input").val();
	
			$parent.siblings().first().children().remove();
			$parent.siblings().first().text(optionName);
	
			$parent.children().remove();
			$parent.append( $('<a href="javascript:void(0);" data-toggle="question-modal-delete" class="question-'+data.id+'" onclick="javascript:rf.loadDeleteModalData(this)"><i class="fa fa-trash"></i> Delete</a>') );
	
			return true;
		},
		"addQuestionPoint": function(ele){
			var $table = $(ele).parent().find(".question-option-points");
			var dt = $table.DataTable();
	
			dt.row.add([
				'<input type="text" />',
				'<button type="button" class="button primary" onclick="javascript:rf.saveQuestionPoint(this);"><i class="fa fa-save"></i> Save</button>'
			]).draw(false);
	
			return true;
		},
		"toggleTab": function(ele){
			var $this = $(ele);
			$this.parent().toggleClass("is-active");
			$this.siblings().toggle();
	
			return true;
		},
		"addQuestionOption": function(ele){
			var $container = $(ele).siblings(".question-options").find("ul.accordion");
			var $optionTemplate = rf.questionOptionBuilder({"name": "New Option", "results": []});
	
			$container.append($optionTemplate);
	
			return true;
		},

		"addQuestion": function(data){
			var $rftable = $(".rf-questionnaire-questions");
			var dt = $rftable.DataTable();
			var id = dt.data().length;
	
			if (!data){
				var data = {
					"id": id, 
					"name": "New Question",
					"question": "Put your question text here...",
					"type": "multiselect", 
					"categories": [],
					"options": {}
				};
			}
	
			dt.row.add([
				'<div class="question-id-container-'+data.id+'" data-pos="'+data.id+'">'+data.id+'</div>', 
				'<a href="javascript:void(0);" data-toggle="question-modal" class="question-'+data.id+' question-data-container" onclick="javascript:rf.loadEditModalData(this)">'+data.name+'</a>', 
				'<div id="question-'+data.id+'-categories">'+data.categories.map(function(id){
					return rf.data.categories[ id ].text;
				}).join(", ")+'</div>', 
				'<a href="javascript:void(0);" data-toggle="question-modal-delete" class="question-control-delete-'+data.id+'" onclick="javascript:rf.loadDeleteModalData(this)"><i class="fa fa-trash"></i> Delete</a>'
			]).draw(false);
	
			$rftable.find(".question-"+data.id).data("qdata", data);
	
			return true;
		},

		"questionOptionBuilder": function(data){
			var id = $(".accordion-item").length;
			var $optionTemplate = $('<li class="accordion-item">'
				+'<a href="javascript:void(0);" onclick="javascript:rf.toggleTab(this)" role="tab" class="accordion-title" id="question-option-'+id+'-heading" aria-controls="question-option-'+id+'"></a>'
				+'<div id="question-option-'+id+'" class="accordion-content" data-option="'+id+'" role="tabpanel" data-tab-content aria-labelledby="question-option-'+id+'-heading">'
					+'<div class="row">'
						+'<div class="question-option-field">'
							+'<div class="small-12 columns">'
								+'<label>Name'
									+'<input type="text" class="option-name">'
								+'</label>'
							+'</div>'
						+'</div>'
					+'</div>'
					+'<div class="row">'
						+'<div class="small-12 columns">'
							+'<div class="question-option-field">'
								+'<label>Description'
									+'<input type="text" class="option-description">'
								+'</label>'
							+'</div>'
						+'</div>'
					+'</div>'
					+'<div class="row">'
						+'<div class="small-12 columns">'
							+'<div class="">'
								+'<label>Points'
									+'<select style="width: 100%" multiple="multiple" name="points" class="rf-question-option-points"></select>'
								+'</label>'
							+'</div>'
						+'</div>'
					+'</div>'
					+'<br/>'
					+'<div class="row">'
						+'<div class="small-12 columns">'
							+'<label>Image'
								+'<input type="text" name="image_url" style="width: 100%" class="regular-text rf-option-image-url">'
							+'</label>'
						+'</div>'
						+'<div class="small-6 columns">'
							+'<input type="button" name="upload-btn" class="button-secondary rf-option-image-upload-btn" value="Upload Image">'						+'</div>'
						+'<div class="small-6 columns">'
							+'<img src="" class="thumbnail rf-option-image-display"/>'
						+'</div>'
					+'</div>'
			
					+'<div class="">'
						+'<hr/>'
						+'<button type="button" class="button primary right"  data-toggle="question-option-modal-delete" onclick="javascript:rf.loadDeleteOptionModalData(this);"><i class="fa fa-trash"></i> Delete</button>'
						+'<br/>'
					+'</div>'
				+'</div>'
			+'</li>');
	
			$optionTemplate.find("a").text( data.name || "New Option" );
			$optionTemplate.find(".option-description").val( data.description || "" );
			$optionTemplate.find(".rf-option-image-url").val( data.image || "" );
			$optionTemplate.find(".rf-option-image-display").attr( "src", data.image || "" );
			$optionTemplate.find(".option-name").val( data.name || "New Option" ).bind("keyup", function(){
				$(this).parents(".accordion-content").siblings(".accordion-title").text( $(this).val() );
			});
	
			var selectData = [];
	
			for(var pos in rf.data.results){
				var option = $.extend({}, rf.data.results[+pos]);
		
				if (data.results.indexOf( +pos ) !== -1){
					option.selected = true;
				}
		
				selectData.push(option);
			}
			
	
			$optionTemplate.find(".rf-option-image-upload-btn").click(function(e) {
				var $parent = $(this).parents(".row").first();
		
				e.preventDefault();
				var image = wp.media({ 
					"title": "Upload Image",
					"multiple": false
				}).open().on("select", function(e){
					// This will return the selected image from the Media Uploader, the result is an object
					var uploaded_image = image.state().get("selection").first();
					// We convert uploaded_image to a JSON object to make accessing it easier
					// Output to the console uploaded_image
					console.log(uploaded_image);
					var image_url = uploaded_image.toJSON().url;
					// Let"s assign the url value to the input field
					$parent.find(".rf-option-image-url").val(image_url);
					$parent.find(".rf-option-image-display").removeClass("failed-image").attr("src", image_url);
				});
			});
			
			$optionTemplate.find(".rf-option-image-display").on("error", function(){
				$(this).addClass("failed-image");
			});
			
			var selectData = [];
	
			for(var pos in rf.data.results){
				var option = $.extend({}, rf.data.results[+pos]);
				
				console.log("looking for "+pos)
				console.log(data.results);
				if (data.results.indexOf( +pos ) !== -1){
					option.selected = true;
				}
		
				selectData.push(option);
			}
	
			$optionTemplate.find("select").select2({
				"tags": true,
				"placeholder": "Start typing name of points...",
				"data": selectData,
				"templateSelection": function(data){
					var match = rf.data.results.filter(function(result){ return result.text == data.text; });
					
					if (match.length){
						var id = match[0].id;
					} else {
						var id = rf.data.results.length;
						
						rf.data.results.push({
							"text": data.text,
							"id": id
						});
					}
					
					$(data.element).data("point", id);
					
					return data.text;
				}
			});
	
			return $optionTemplate;
		},
		"loadEditModalData": function(ele){
			var data = $(ele).data("qdata");
			var $modalTemplate = $("#question-modal");
			var $optionsContainer = $modalTemplate.find(".question-options");
			var $container = $('<ul class="accordion" data-accordion data-allow-all-closed="true" role="tablist"></ul>')
	
			$modalTemplate.data("modalRefEle", $(ele));
			$modalTemplate.data("qdata", data);
	
			$optionsContainer.children().remove();
	
			$modalTemplate.find("input[name=name]").val(data.name);
			$modalTemplate.find("input[name=question]").val(data.question);
			$modalTemplate.find("select[name=type]").val(data.type);
			
			var selectData = [];
	
			for(var pos in rf.data.categories){
				var category = $.extend({}, rf.data.categories[+pos] );
				
				if (data.categories.indexOf( +pos ) !== -1){
					category.selected = true;
				}
		
				selectData.push(category);
			}
			
			$modalTemplate.find("#rf-question-category").val(null).on("focus", function(e){
				e.preventDefault();
				e.stopImmediatePropagation();
				$(this).siblings(".select2-container").find("input.select2-search__field").focus();
			}).select2({
				"tags": true,
				"placeholder": "Start typing name of categories...",
				"data": selectData,
				"templateSelection": function(data){
					var match = rf.data.categories.filter(function(category){ return category.text == data.text; });
					
					if (match.length){
						var id = match[0].id;
					} else {
						var id = rf.data.categories.length;
						
						rf.data.categories.push({
							"text": data.text,
							"id": id
						});
					}
					
					$(data.element).data("category", id);
					
					return data.text;
				}
			});
	
			for(var id in data.options){
				var option = data.options[id];
		
				var $optionTemplate = rf.questionOptionBuilder(option);
		
				$container.append( $optionTemplate );
		
			}
			
			Sortable.create( $container.get(0) );
			
			$optionsContainer.append( $container );
	
			return true;
		},
		"loadQuestionOrderModalData": function(){
			var $modalTemplate = $("#question-order-modal");
			var $questionContainer = $modalTemplate.find("#question-order-modal-questions-container");
			var $questionsDOM = rf.data.questions.map(function(question){
				return '<div class="small-12 columns callout rf-question-order-question-item" data-qpos="'+question.id+'">'+question.name+'</div>';
			}).join('');
			
			$questionContainer.html( $questionsDOM );
			
			Sortable.create( $questionContainer.get(0) );
			
		},
		"setQuestionOrder": function(ele){
			var $modalTemplate = $("#question-order-modal");
			var $rftable = $(".rf-questionnaire-questions");
			var dt = $rftable.DataTable();
			
			var $questionContainer = $modalTemplate.find("#question-order-modal-questions-container");
			var orderedQuestions = [];
			var questionsIDsInOrder = $questionContainer.find(".rf-question-order-question-item").each(function(){
				var question = rf.data.questions[ +$(this).data("qpos") ];
				question['id'] = orderedQuestions.length;
				orderedQuestions.push( question );
			});
			
			rf.data.questions = orderedQuestions;
			
			$("#rf-questionnaire-json-data").val( JSON.stringify(rf.data) );

			dt.clear().draw();
			
			for(var id in rf.data.questions){
				var qdata = rf.data.questions[id];
				rf.addQuestion(qdata);
			}
			
			
			return true;
		},
		"loadDeleteModalData": function(ele){
			var data = $(ele).parents("tr").first().find(".question-data-container").data("qdata");
			var $modalTemplate = $("#question-modal-delete");
		
			$modalTemplate.find(".question-modal-delete-name").text( data.name );
	
			$modalTemplate.data("modalRefEle", $(ele));
			$modalTemplate.data("qdata", data);
	
			return true;
		},
		"loadDeleteOptionModalData": function(ele){
			var $parent = $(ele).parents("li.accordion-item").first();
			var $modalTemplate = $("#question-option-modal-delete");
		
			$modalTemplate.find(".question-option-modal-delete-name").text( $parent.find("input.option-name").val() );
		
			$modalTemplate.data("modalRefEle", $parent );
		
			return true;
		},
		"saveSettings": function(ele){
			window.rf.data.config.buttons.normal.background = $("#rf-settings-normal-button-color").val();
			window.rf.data.config.buttons.normal.color = $("#rf-settings-normal-button-font-color").val();
			window.rf.data.config.buttons.selected.background = $("#rf-settings-selected-button-color").val();
			window.rf.data.config.buttons.selected.color = $("#rf-settings-selected-button-font-color").val();
			window.rf.data.config.buttons.shape = $("#rf-settings-button-shape").val();
			window.rf.data.config.options.highlight = $("#rf-settings-selected-option-highlight-color").val();
			window.rf.data.config.options.color = $("#rf-settings-selected-option-highlight-font-color").val();
			
			$("#rf-questionnaire-json-data").val( JSON.stringify(rf.data) );
			
			$("#settings-modal").foundation("close");
			
			return true;
		}
	});

	$(document).foundation();

	$(document).ready(function() {
		var $rftable = $(".rf-questionnaire-questions");

		$rftable.dataTable();
 
		var dt = $rftable.DataTable();

		for(var id in rf.data.questions){
			var qdata = rf.data.questions[id];
			rf.addQuestion(qdata);
		}
	});
	
	 $("#rf-settings-normal-button-color").val(window.rf.data.config.buttons.normal.background);
	 $("#rf-settings-normal-button-font-color").val(window.rf.data.config.buttons.normal.color);
	 $("#rf-settings-selected-button-color").val(window.rf.data.config.buttons.selected.background);
	 $("#rf-settings-selected-button-font-color").val(window.rf.data.config.buttons.selected.color);
	 $("#rf-settings-button-shape").val(window.rf.data.config.buttons.shape);
	 $("#rf-settings-selected-option-highlight-color").val(window.rf.data.config.options.highlight);
	 $("#rf-settings-selected-option-highlight-font-color").val(window.rf.data.config.options.color);
	
	$("#rf-settings-normal-button-color").on('change.spectrum', function(e, tinycolor) {
		$(".rf-question-option-container.not-selected").css("background", $(this).val());
	});
	
	$("#rf-settings-selected-button-color").on('change.spectrum', function(e, tinycolor) {
		$(".rf-question-option-container.selected").css("background", $(this).val());
	});
	
	
	$("#rf-settings-normal-button-font-color").on('change.spectrum', function(e, tinycolor) {
		$(".rf-question-option-container.not-selected").css("color", $(this).val());
	});
	
	$("#rf-settings-selected-button-font-color").on('change.spectrum', function(e, tinycolor) {
		$(".rf-question-option-container.selected").css("color", $(this).val());
	});
	
	$("#rf-settings-button-shape").on("change", function(){
		$(".rf-question-option-container").removeClass("round").addClass( $(this).val() );
	});
	
})(window, jQuery);