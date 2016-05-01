<?php
	global $post;

	$defaultData = array(
		'config' => array(
			'options' => array(
				'highlight' => '#48D1CC',
				'color' => '#CC0000'
			),
			'buttons' => array(
				'shape' => 'rectangle',
				'normal' => array(
					'background' => '#FFFFFF',
					'color' => '#000000'
				),
				'selected' => array(
					'background' => '#48D1CC',
					'color' => '#000000'
				)
			)
		),
		'categories' => array(),
		'results' => array(),
		'questions' => array()
	);

	$defaultJSONData = json_encode( $defaultData );
	
  $questionnaire = get_post_meta($post->ID, '_questionnaire_json_data', true);
	
	$dashboardJSONData = empty($questionnaire) ? $defaultJSONData : $questionnaire;
	
	$dashboardData = json_decode($dashboardJSONData, true);
?>
	<style>
		.rf-question-option-container{
			background-color: <?php echo $dashboardData['config']['buttons']['normal']['background'] ?>;
			color: <?php echo $dashboardData['config']['buttons']['normal']['color'] ?>;
			
		}
		
		.rf-question-option-container.selected{
			background: <?php echo $dashboardData['config']['buttons']['selected']['background'] ?>;
			color: <?php echo $dashboardData['config']['buttons']['selected']['color'] ?>;
		}
	</style>
	<div id="rf-questionnaire-container">
		<input type="hidden" name="_questionnaire_json_data" id="rf-questionnaire-json-data" value="<?php echo esc_attr( $dashboardJSONData ); ?>" />
	
		<div class="row">
			<div class="small-4 columns">
			
				<h4>Questions</h4>
			</div>
			<div class="small-8 columns rf-gt-main-control-buttons">
				<button type="button" class="button tiny right primary" onclick="javascript:rf.addQuestion();"><i class="fa fa-plus"></i> Add Question</button>
				<button type="button" class="button tiny right primary" onclick="javascript:rf.loadQuestionOrderModalData()" data-toggle="question-order-modal"><i class="fa fa-sort-amount-asc"></i> Question Order</button>
				<button type="button" class="button tiny right primary" onclick="javascript:rf.loadResultsManagementModalData()" data-toggle="result-management-modal"><i class="fa fa-check-circle-o"></i> Manage Points</button>
				<button type="button" class="button tiny right primary" data-toggle="settings-modal"><i class="fa fa-gears"></i> Manage Settings</button>
			</div>
		</div>
		<div class="row">
			<div class="small-12 columns">		
				<table class="rf-questionnaire-questions" style="width: 100%;">
					<thead>
						<tr>
							<th width="5%">ID</th>
							<th width="70%">Name</th>
							<th width="10%">Categories</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>
		</div> 
	
		<div id="settings-modal" class="reveal" data-reveal>
			<h2 class="title">General Settings</h2>
		
			<div class="row">
				<div class="small-6 columns">
				
					<div class="row">
						<div class="small-12 columns">
							<strong>Unselected Button</strong>
						</div>
						<div class="small-6 columns">
							<div class="type-field">
								<label>Button Color
									<input type="color" name="normal-button-color" id="rf-settings-normal-button-color" value="#FFFFFF">
								</label>
							</div>
						</div>
						<div class="small-6 columns">
							<div class="type-field">
								<label>Font Color
									<input type="color" name="normal-button-font-color" id="rf-settings-normal-button-font-color" value="#000000">
								</label>
							</div>
						</div>
					</div>
				</div>
				<div class="small-6 columns">
					<br/>
					<div class="rf-question-option-container not-selected text-center">
						<div class="rf-question-option-name">Option Name</div>
						<div class="rf-question-option-description">description</div>
					</div>
				</div>
			</div>
		
			<hr/>
		
			<div class="row">
				<div class="small-6 columns">
					<div class="row">
						<div class="small-12 columns">
							<strong>Selected Button</strong>
						</div>
						<div class="small-6 columns">
							<div class="type-field">
								<label>Button Color
									<input type="color" name="selected-button-color" id="rf-settings-selected-button-color" value="#48D1CC">
								</label>
							</div>
						</div>
						<div class="small-6 columns">
							<div class="type-field">
								<label>Font Color
									<input type="color" name="selected-button-font-color" id="rf-settings-selected-button-font-color" value="#000000">
								</label>
							</div>
						</div>
					</div>
				</div>
				<div class="small-6 columns">
					<br/>
					<div class="rf-question-option-container selected text-center">
						<div class="rf-question-option-name">Selected Option</div>
						<div class="rf-question-option-description">selected</div>
					</div>
				</div>
			</div>
		
			<hr/>
		
			<div class="row">
				<div class="small-12 columns">
					<div class="type-field">
						<label>Button Shape
							<select name="type" id="rf-settings-button-shape">
								<option value="rectangle">Rectangle</option>
								<option value="round">Rounded</option>
							</select>
						</label>
					</div>
				</div>
			</div>
		
			<hr/>
		
			<div class="row">
				<div class="small-6 columns">
					<div class="type-field">
						<label>Option Highlight Color
							<input type="color" name="option-highlight-color" id="rf-settings-selected-option-highlight-color" value="#48D1CC">
						</label>
					</div>
				</div>
				<div class="small-6 columns">
					<div class="type-field">
						<label>Option Highlight Font Color
							<input type="color" name="option-highlight-font-color" id="rf-settings-selected-option-highlight-font-color" value="#CC0000">
						</label>
					</div>
				</div>
			</div>
		

		
			<button class="button tiny right" type="button" onclick="javascript: rf.saveSettings(this);"><i class="fa fa-save"></i> Submit</button>
		
			<button class="close-button" data-close aria-label="Close reveal" type="button">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
	
		<div id="question-modal" class="reveal" data-reveal>
			<h2 class="title">Edit Question</h2>
			<p class="lead"></p>
			<p class="text"></p>
			<div class="question-field">
				<label>Name
					<input type="text" name="name">
				</label>
			</div>
		
			<div class="question-field">
				<label>Question
					<input type="text" name="question">
				</label>
			</div>

			<div class="type-field">
				<label>Type
					<select name="type">
						<option value="radio">Single</option>
						<option value="multiselect">Multiple</option>
					</select>
				</label>
			</div>
			
			<div class="category-field">
				<label>Category
					<select style="width: 100%;" class="js-example-tags form-control select2-hidden-accessible" multiple="multiple" name="categories" id="rf-question-category"></select>
				</label>
			</div>
			
			<br/>
		
			<button class="button tiny primary right" type="button" onclick="javascript:rf.addQuestionOption(this);"><i class="fa fa-plus"></i> Add Option</button>
		
			<br/>
		
			<hr/>
		
			<div class="question-options"></div>
		
			<hr/>
		
			<button class="button tiny primary right" type="button" onclick="javascript: rf.questionBuilder(this);"><i class="fa fa-save"></i> Submit</button>
		
			<button class="close-button" data-close aria-label="Close reveal" type="button">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>

		<div id="result-management-modal" class="reveal" data-reveal>
			<h2 class="title">Points Management</h2>

			<form onsubmit="return false;">
				<div class="row" id="results-management-modal-points-container"></div>
			</form>
		
			<button class="button tiny right" type="button" onclick="javascript: rf.setResultsManagement(this);" data-toggle="result-management-modal"><i class="fa fa-save"></i> Submit</button>
		
			<button class="close-button" data-close aria-label="Close reveal" type="button">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>

		<div id="question-order-modal" class="reveal" data-reveal>
			<h2 class="title">Question Order</h2>
			<p class="lead">Drag and drop the questions in the specific order you would like them to appear.</p>

			<div class="row" id="question-order-modal-questions-container"></div>
		
		
			<button class="button tiny right" type="button" onclick="javascript: rf.setQuestionOrder(this);" data-toggle="question-order-modal"><i class="fa fa-save"></i> Submit</button>
		
			<button class="close-button" data-close aria-label="Close reveal" type="button">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
	
		<div id="question-modal-delete" class="reveal" data-reveal>
			<h2 class="title">Delete Question</h2>
			<p class="lead">Are you sure you want to delete "<span class="question-modal-delete-name"></span>" question?</p>
			<p class="text">This cannot be undone!</p>
		
			<button class="button tiny alert right" type="button" onclick="javascript: rf.deleteQuestion(this);"><i class="fa fa-trash"></i> Delete</button>
		
			<button class="close-button" data-close aria-label="Close reveal" type="button">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
	
		<div id="question-option-modal-delete" class="reveal" data-reveal>
			<h2 class="title">Delete Option</h2>
			<p class="lead">Are you sure you want to delete "<span class="question-option-modal-delete-name"></span>" option?</p>
			<p class="text">This cannot be undone!</p>
		
			<button class="button tiny alert right" type="button" onclick="javascript: rf.deleteQuestionOption(this);"><i class="fa fa-trash"></i> Delete</button>
		
			<button class="close-button" data-close aria-label="Close reveal" type="button" onclick="javascript: $('#question-modal').foundation('open');">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
	</div>

	<script>
		window.rf = {
			"settings": {
				"videoURI": "<?php echo plugins_url( '/' , __FILE__ ); ?>"
			},
			"data": JSON.parse('<?php echo addslashes( $dashboardJSONData ); ?>')
		};
	</script>