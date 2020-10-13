<div id='create-topic-wizard' class="wizard">
	<h2><?php echo $title; ?></h2>
	<div class="form">
		<?php if($prayerRequest == 1) {
			echo  '<h3><strong>'.t('Take a step to write prayer request below! This helps your prayer partners how they can start praying.')
					.'</strong></h3>';
					
		?>
		
		<div class='content-row content-row-buttons'> 
			<div class='left-content left-content-buttons'>
				<div class="prayvine-buttons clearfix">
		  			<a class="ajax-prayer-top no-action">Write a prayer</a>
					<a class="ajax-request no-action prayvine-active" >Request prayer</a> 
					<a class="ajax-comment no-action" >Share prayer update</a> 
				</div>
				<div class="white-box" style="width:770px;"><?php echo drupal_render($form); ?></div>
			</div>
		</div>
		<?php } else { ?>
			<?php echo drupal_render($form); ?>
		<?php }?>
	</div>
</div>
