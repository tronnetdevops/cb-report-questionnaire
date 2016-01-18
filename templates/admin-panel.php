<?php
	$defaultJSONData = json_encode(array(
		'results' => array(
			array(
				'text' => 'Address',
				'id' => 0
			),
			array(
				'text' => 'Birthday',
				'id' => 1
			),
			array(
				'text' => 'Credit or debit card',
				'id' => 2
			),
			array(
				'text' => 'Email',
				'id' => 3
			),
			array(
				'text' => 'Employment history',
				'id' => 4
			),
			array(
				'text' => 'Financial history',
				'id' => 5
			),
			array(
				'text' => 'Fingerprints',
				'id' => 6
			),
			array(
				'text' => 'Health history',
				'id' => 7
			),
			array(
				'text' => 'Password (encrypted)',
				'id' => 8
			),
			array(
				'text' => 'Phone number',
				'id' => 9
			),
			array(
				'text' => 'Social Security Number',
				'id' => 10
			)
		),
		
		'questions' => array(
			array(
				'id' => 0,
				'name' => 'Job Application',
				'question' => 'Have you applied for a job with or worked for the federal government since 2000?',
				'type' => 'radio',
				'options' => array(
					array(
						'id' => 0,
						'name' => 'Yes',
						'description' => '',
						'results' => array(0, 4, 5, 6, 10)
					),
					array(
						'id' => 1,
						'name' => 'No',
						'description' => '',
						'results' => array()
					)
				)
			),
			
			array(
				'id' => 1,
				'name' => 'Account Websites',
				'question' => 'Have you signed up for an account with these websites?',
				'type' => 'multiselect',
				'options' => array(
					array(
						'id' => 0,
						'name' => 'Adobe',
						'description' => 'Before Oct. 2013',
						'results' => array(2,8)
					),
					array(
						'id' => 1,
						'name' => 'AOL',
						'description' => 'Before April 2014',
						'results' => array(0,3,4,8)
					),
					array(
						'id' => 2,
						'name' => 'eBay',
						'description' => 'Before May 2014',
						'results' => array(0,1,3,8,9)
					),
					array(
						'id' => 3,
						'name' => 'livingsocial',
						'description' => 'Before April 2014',
						'results' => array(1,3,8)
					),
					array(
						'id' => 4,
						'name' => 'slack',
						'description' => 'Before Feb 2015',
						'results' => array(3,8,9)
					),
					array(
						'id' => 5,
						'name' => 'snapchat',
						'description' => 'Before Jan 2014',
						'results' => array(9)
					),
					array(
						'id' => 6,
						'name' => 'twitch',
						'description' => 'Before March 2015',
						'results' => array(0,1,3,8,9)
					),
					array(
						'id' => 7,
						'name' => 'twitter',
						'description' => 'Before Feb 2013',
						'results' => array(3,8)
					)
				)
			),
			
			array(
				'id' => 3,
				'name' => 'Insurance Providers',
				'question' => 'Did you have health insurance from these providers?',
				'type' => 'multiselect',
				'options' => array(
					array(
						'id' => 0,
						'name' => 'Anthem',
						'description' => 'Before Jan. 2015',
						'results' => array(0,1,3,4,7,10)
					),
					array(
						'id' => 1,
						'name' => 'CareFirst',
						'description' => 'Before June 2014',
						'results' => array(1,3)
					),
					array(
						'id' => 2,
						'name' => 'CHS',
						'description' => 'Before July 2014',
						'results' => array(0,1,4,9,10)
					),
					array(
						'id' => 3,
						'name' => 'Premera',
						'description' => 'Before Jan. 2014',
						'results' => array(0,1,3,7,9,10)
					)
				)
			),
			
			array(
				'id' => 4,
				'name' => 'Credit at Retailers',
				'question' => 'Did you use a credit or debit card at these retailers?',
				'type' => 'multiselect',
				'options' => array(
					array(
						'id' => 0,
						'name' => 'Albertsons',
						'description' => 'June 2014 - July 2014',
						'results' => array(2)
					),
					array(
						'id' => 1,
						'name' => 'Dairy Queen',
						'description' => 'Aug. 2014 - Sept. 2014',
						'results' => array(2)
					),
					array(
						'id' => 2,
						'name' => 'Goodwill',
						'description' => 'Feb. 2013 - Aug. 2014',
						'results' => array(2)
					),
					array(
						'id' => 3,
						'name' => 'Home Depot',
						'description' => 'April 2014 - Sept. 2014',
						'results' => array(2,3)
					),
					array(
						'id' => 4,
						'name' => 'Kmart',
						'description' => 'Sept. 2014 - Oct. 2014',
						'results' => array(2)
					),
					array(
						'id' => 5,
						'name' => 'Michaels Stores',
						'description' => 'May 2013 - Jan. 2014',
						'results' => array(2)
					),
					array(
						'id' => 6,
						'name' => 'Neiman Marcus',
						'description' => 'July 2013 - Oct. 2013',
						'results' => array(2)
					),
					array(
						'id' => 7,
						'name' => 'P.F. Chang\'s',
						'description' => 'Feb. 2014 - June 2014',
						'results' => array(2)
					),
					array(
						'id' => 8,
						'name' => 'Sally Beauty Supply',
						'description' => 'March 2014 - April 2015',
						'results' => array(2)
					),
					array(
						'id' => 9,
						'name' => 'Staples',
						'description' => 'July 2014 - Sept. 2014',
						'results' => array(2)
					),
					array(
						'id' => 10,
						'name' => 'Supervalu',
						'description' => 'June 2014 - July 2014',
						'results' => array(2)
					),
					array(
						'id' => 11,
						'name' => 'Target',
						'description' => 'Nov. 2013 - Dec. 2013',
						'results' => array(0,2,3,9)
					),
					array(
						'id' => 12,
						'name' => 'United Parcel Service',
						'description' => 'Jan. 2014 - Aug. 2014',
						'results' => array(0,2,3)
					)
				)
			)
		)
	));
?>
	<div class="wrap">
		<h2>Credit Block Questionaire</h2>

		<div class="row">
			<div class="small-8 columns">
				
				<h4>Questions</h4>
			</div>
			<div class="small-4 columns">
				<button type="button" class="button right primary" onclick="javascript:rf.addQuestion();"><i class="fa fa-plus"></i> Add Question</button>
			</div>
		</div>
		<div class="row">
			<div class="small-12 columns">		
				<table class="rf-questionnaire-questions" style="width: 100%;">
					<thead>
						<tr>
							<th width="80%">Name</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>
		</div> 
	
		<form method="post" action="options.php">
		    <?php settings_fields( 'cb-questionnaire-settings-group' ); ?>
		    <?php do_settings_sections( 'cb-questionnaire-settings-group' ); ?>
			<input type="hidden" name="json_data" value="<?php echo esc_attr($defaultJSONData /* get_option('json_data', $defaultJSONData ) */ ); ?>" />
		    
			<?php submit_button(); ?>
		</form>
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
		
		<button class="button primary right" type="button" onclick="javascript:rf.addQuestionOption(this);"><i class="fa fa-plus"></i> Add Option</button>
		
		<br/>
		
		<hr/>
		
		<div class="question-options"></div>
		
		<hr/>
		
		<button class="button primary right" type="button" onclick="javascript: rf.questionBuilder(this);"><i class="fa fa-save"></i> Submit</button>
		
		<button class="close-button" data-close aria-label="Close reveal" type="button">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>
	
	<div id="question-modal-delete" class="reveal" data-reveal>
		<h2 class="title">Delete Question</h2>
		<p class="lead">Are you sure you want to delete "<span class="question-modal-delete-name"></span>" question?</p>
		<p class="text">This cannot be undone!</p>
		
		<button class="button alert right" type="button" onclick="javascript: rf.deleteQuestion(this);"><i class="fa fa-trash"></i> Delete</button>
		
		<button class="close-button" data-close aria-label="Close reveal" type="button">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>
	
	<div id="question-option-modal-delete" class="reveal" data-reveal>
		<h2 class="title">Delete Option</h2>
		<p class="lead">Are you sure you want to delete "<span class="question-option-modal-delete-name"></span>" option?</p>
		<p class="text">This cannot be undone!</p>
		
		<button class="button alert right" type="button" onclick="javascript: rf.deleteQuestionOption(this);"><i class="fa fa-trash"></i> Delete</button>
		
		<button class="close-button" data-close aria-label="Close reveal" type="button" onclick="javascript: $('#question-modal').foundation('open');">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>

	<script>
		window.rf = {"data": JSON.parse('<?php echo addslashes( /* $defaultJSONData; */ get_option('json_data', $defaultJSONData ) ); ?>')};
	</script>