





			<div class="form_wrapper form-lg">
				<?php $form_attribute = array('class' => 'form-horizontal','method'=>'post','id'=>'draft_nl_form');
				    echo form_open('newsletter/draft_newsletter', $form_attribute);
				?>
						
					
					<fieldset>

					<!-- Form Name -->
					<legend><?=@$title?></legend>	

					<!-- Text input-->
					<div class="form-group">
					  <label class="col-md-2 control-label" for="nl_group">Newsletter group</label>
					  <div class="col-md-8">
					  	<?php
					  	$nl_group = explode(',', $newsletter->nl_group);
					  	foreach ($nl_group as $group) {
					  		?>
					  		<div class="label label-success"><?=$group?></div>
					  		<?php
					  	}
					  	?>
					    
					  </div>
					</div>

					<!-- Text input-->
					<div class="form-group">
					  <label class="col-md-2 control-label" for="emails">Email</label>
					  <div class="col-md-8">
					    <?php
					  	$nl_email = explode(',', $newsletter->nl_email);
					  	foreach ($nl_email as $email) {
					  		?>
					  		<div class="label label-success"><?=$email?></div>
					  		<?php
					  	}
					  	?>
					    
					    
					  </div>
					</div>

					<!-- Text input-->
					<div class="form-group">
					  <label class="col-md-2 control-label" for="emails">Title</label>
					  <div class="col-md-8">
					    <input id="emails" name="nl_title" type="hidden" placeholder="Enter newsletter title" class="form-control input-sm">
					    <?=$newsletter->title?>
					  </div>
					</div>

					<!-- Textarea -->
					<div class="form-group">
					  <label class="col-md-2 control-label" for="newsletter">Newsletter</label>
					  <div class="col-md-10"><a href="#">Load newsletter template</a>
					    <input type="hidden" name="nl_content" value="">
					    <div style="overflow: hidden;"><?=$newsletter->nl_contents?></div>
					    
					  </div>
					</div>
					<input type="hidden" name="tracking_no" value="<?=$newsletter->tracking_no?>" id="tracking_no">
					<!-- Button (Double) -->
					<div class="form-group">
					  <label class="col-md-3 control-label" for="cancel"></label>
					  <div class="col-lg-6">
					    <button id="cancel" name="cancel" class="btn btn-default" type="button">Cancel</button>
					    <button id="send" name="save" class="btn btn-success" type="button">Send</button>
					  </div>
					  <div class="work_message"></div>
					</div>

					</fieldset>
					
	
						
					
						
				<?php echo form_close(); ?>
			</div>
			



