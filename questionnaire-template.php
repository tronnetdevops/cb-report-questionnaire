<?php
	require_once('includes/request-update.php');
	require_once('includes/template-loader.php');
	
	$data = json_decode(get_option('json_data', '{}' ), true);
		
	get_header();
?>
	<div class="top-bar hide">
		<div class="row">
			<div class="top-bar-left">
				<ul class="dropdown menu">
					<li class="menu-text">Regal Finance</li>

				</ul>
			</div>
			<div class="top-bar-right">
				<ul class="dropdown menu" data-dropdown-menu>
					<li class="has-submenu">
						<a href="#"><i class="fa fa-tasks"></i> Tools</a>
						<ul class="submenu menu vertical" data-submenu>
							<li><a href="#">Accounts</a></li>
							<li><a href="#">Settings</a></li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
	</div>
 
	<br/>
	
	<div class="row">
		<div class="large-9 columns">
			
			<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
		
			<?php the_content(); ?>
	
			<?php endwhile; ?>
	
			<br/>	
		</div>
		
		<div class="large-12 columns">
			<hr/>
		</div>
	</div>
	
	
	<div class="row">
		<div class="large-3 columns">
			<div class="rf-options-container" style="z-index: 100;">
				<div class="rf-option-lead row">
					<div class="small-12 columns">
						<strong>How many times your information has been exposed to hackers</strong>
					</div>
				</div>
				<?php foreach($data['results'] as $result) : ?>
				<div class="rf-option row collapse" data-option="<?php echo $result['id']; ?>">
					<div class="small-10 columns"><?php echo $result['text']; ?></div>
					<div class="small-2 text-right columns"><span class="rf-option-count" data-count="0"></span></div>
				</div>
				<?php endforeach; ?>
			</div>
		</div>
		
		<div class="large-9 columns">
			<?php foreach($data['questions'] as $question) : ?>
				<div class="rf-question-container" data-type="<?php echo $question['type']; ?>">
					<div class="row rf-question-text-container">
						<div class="small-12 columns">
							<h5 class="rf-question-text"><?php echo $question['question']; ?></h5>
						</div>
					</div>
					<div class="row small-up-1 medium-up-2 large-up-4">
						<?php foreach($question['options'] as $questionOption) : ?>
						<div class="column">
							<div class="rf-question-option-container text-center" data-results="<?php echo implode(",", $questionOption['results']); ?>">
								<div class="rf-question-option-name"><?php echo $questionOption['name']; ?></div>
								<?php if (!empty($questionOption['description'])) : ?>
								<div class="rf-question-option-description"><?php echo $questionOption['description']; ?></div>
								<?php endif; ?>
							</div>
						</div>
						<?php endforeach; ?>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
	
<?php
	get_footer(); 
?>
