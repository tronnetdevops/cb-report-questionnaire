<?php
	global $post;
	
	$data = json_decode(get_option('json_data', '{}' ), true);
		
	$bottomText = get_post_meta($post->ID, '_questionnaire_bottom_text' , true );	
		
	get_header();
	
?>

	<style>
		.rf-question-option-container{
			background-color: <?php echo $data['config']['buttons']['normal']['background'] ?>;
			color: <?php echo $data['config']['buttons']['normal']['color'] ?>;
			
		}
		
		.rf-question-option-container.selected{
			background: <?php echo $data['config']['buttons']['selected']['background'] ?>;
			color: <?php echo $data['config']['buttons']['selected']['color'] ?>;
		}
		
		.rf-option.hit{
		    background-color: <?php echo $data['config']['options']['highlight'] ?>;
		}
		

		.rf-option.has-points{
			color: <?php echo $data['config']['options']['color'] ?>;
		}
	</style>
	
	<div class="top-bar hide">
		<div class="row">
			<div class="top-bar-left">
				<ul class="dropdown menu">
					<li class="menu-text">Regal Finance <?php the_ID(); ?></li>

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
			<div class="orbit" role="region" aria-label="Favorite Space Pictures" data-orbit data-auto-play="false" data-use-m-u-i="false">
				<ul class="orbit-container">
					<button class="orbit-previous"><span class="show-for-sr">Previous Slide</span>&#9664;&#xFE0E;</button>
					<button class="orbit-next"><span class="show-for-sr">Next Slide</span>&#9654;&#xFE0E;</button>
					<?php foreach($data['questions'] as $question) : ?>
					<li class="is-active orbit-slide">
						<div class="rf-question-container" data-type="<?php echo $question['type']; ?>">
							<div class="row rf-question-text-container">
								<div class="small-12 columns">
									<h5 class="rf-question-text"><?php echo $question['question']; ?></h5>
								</div>
							</div>
							<div class="row small-up-1 medium-up-2 large-up-4">
								<?php foreach($question['options'] as $questionOption) : ?>
								<div class="column">
									<div class="rf-question-option-container text-center <?php echo $data['config']['buttons']['shape']; ?>" data-results="<?php echo implode(",", $questionOption['results']); ?>">
										<?php if (!empty($questionOption['image'])) : ?>
										<img src="<?php echo $questionOption['image']; ?>" class="rf-option-image-display"/>
										<?php else : ?>
										<div class="rf-question-option-name"><?php echo $questionOption['name']; ?></div>
										<?php endif; ?>
										<?php if (!empty($questionOption['description'])) : ?>
										<div class="rf-question-option-description"><?php echo $questionOption['description']; ?></div>
										<?php endif; ?>
									</div>
								</div>
								<?php endforeach; ?>
							</div>
						</div>
					</li>
					<?php endforeach; ?>
			  </ul>
			  <nav class="orbit-bullets">
			    <button class="is-active" data-slide="0"><span class="show-for-sr">First slide details.</span><span class="show-for-sr">Current Slide</span></button>
			    <button data-slide="1"><span class="show-for-sr">Second slide details.</span></button>
			    <button data-slide="2"><span class="show-for-sr">Third slide details.</span></button>
			    <button data-slide="3"><span class="show-for-sr">Fourth slide details.</span></button>
			  </nav>
			</div>
			
			<div class="row">
				<div class="large-12 columns">
					<?php echo nl2br($bottomText); ?>
				</div>
			</div>
		</div>
	</div>

<?php
	get_footer(); 
?>
