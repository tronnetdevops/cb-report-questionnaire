(function(window, $){
	"use strict";
	
	$.extend(window.rf, {
		"questionBuilder": function(e){
			var $modalTemplate = $("#question-modal");
			var $ele = $modalTemplate.data("modalRefEle");
			var data = $modalTemplate.data("qdata");
	
			data["name"] = $modalTemplate.find("input[name=name]").val();
			data["question"] = $modalTemplate.find("input[name=question]").val();
			data["type"] = $modalTemplate.find("select[name=type]").val();
	
			var options = [];
		
			$modalTemplate.find(".accordion-content").each(function(){
				var id = $(this).data("option");
				var optionName = $(this).find(".option-name").val();
				var optionDescription = $(this).find(".option-description").val();
				var optionItemsValues = $(this).find("select").val();
				var optionItems = [];
		
				for(var i in optionItemsValues){
					if(optionItemsValues.hasOwnProperty(i)) {
						optionItems.push( +optionItemsValues[i] );
					}
				}
		
				options.push({
					"name": optionName,
					"description": optionDescription,
					"id": id,
					"results": optionItems
				});
			});
	
			data["options"] = options;
	
			$ele.attr("qdata", data).text( data.name );
	
			rf.data.questions[ data.id ] = data;
	
			$("input[name=json_data]").val( JSON.stringify(rf.data) );
	
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
		
			$("input[name=json_data]").val( JSON.stringify(rf.data) );
		
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
			$parent.append( $('<a href="#" data-toggle="question-modal-delete" class="question-'+data.id+'" onclick="javascript:rf.loadDeleteModalData(this)"><i class="fa fa-trash"></i> Delete</a>') );
	
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
					"options": {}
				};
			}
	
			dt.row.add([
				'<a href="#" data-toggle="question-modal" class="question-'+data.id+' question-data-container" onclick="javascript:rf.loadEditModalData(this)">'+data.name+'</a>', 
				'<a href="#" data-toggle="question-modal-delete" class="question-control-delete-'+data.id+'" onclick="javascript:rf.loadDeleteModalData(this)"><i class="fa fa-trash"></i> Delete</a>'
			]).draw(false);
	
			$rftable.find(".question-"+data.id).data("qdata", data);
	
			return true;
		},

		"questionOptionBuilder": function(data){
			var id = $(".accordion-item").length;
			var $optionTemplate = $('<li class="accordion-item">'
				+'<a href="#question-option-'+id+'" onclick="javascript:rf.toggleTab(this)" role="tab" class="accordion-title" id="question-option-'+id+'-heading" aria-controls="question-option-'+id+'"></a>'
				+'<div id="question-option-'+id+'" class="accordion-content" data-option="'+id+'" role="tabpanel" data-tab-content aria-labelledby="question-option-'+id+'-heading">'
					+'<div class="question-option-field">'
						+'<label>Name'
							+'<input type="text" class="option-name">'
						+'</label>'
					+'</div>'
					+'<div class="question-option-field">'
						+'<label>Description'
							+'<input type="text" class="option-description">'
						+'</label>'
					+'</div>'
					+'<div class="">'
						+'<label>Points'
							+'<select style="width: 100%" multiple="multiple" class="rf-question-option-points"></select>'
						+'</label>'
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
	
			$optionTemplate.find("select").select2({
				"tags": true,
				"placeholder": "Start typing name of points...",
				"data": selectData
			}).on("change", function(e) {
				var selectedItems = $(e.target).val() || [];
				var newItems = [];
		
				if (rf.data.results){
					var dataValues = rf.data.results.map(function(v,i){ return v.text; });
				} else {
					var dataValues = [];
				}
		
				for(var id in selectedItems){
					var result = selectedItems[ id ];
			
					/**
					 * Numeric most likely means this is an ID and not a new entry.
					 * Could be problematic in the case of a new entry that is actually just a number...
					 */
					if ($.isNumeric(result)){
						continue;
					}
			
					if (dataValues.indexOf( result ) === -1){
						var newID = rf.data.results.length + newItems.length;
						newItems.push({
							"text": result,
							"id": newID
						});
				
						$(this).find('option[value="'+result+'"]').attr("value", newID);
					}
				}
		
				$.merge(rf.data.results, newItems);
		
				/**
				 * Reapplying the ID may cause issues...
				 */
				for(var pos in rf.data.results){
					rf.data.results[ pos ].id = pos;
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
	
			for(var id in data.options){
				var option = data.options[id];
		
				var $optionTemplate = rf.questionOptionBuilder(option);
		
				$container.append( $optionTemplate );
		
			}
	
			$optionsContainer.append( $container );
	
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
})(window, jQuery);