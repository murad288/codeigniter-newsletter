<?php      require_once(APPPATH.'views/template/header.php'); ?>
<!-- Main content -->
<section class="content">
	
		<div class="row">
			<?php 
			if (isset($this->session->err_msg)) {
				?>
				<p class="alert alert-danger"><?=$this->session->err_msg?></p>
				<?php
			}
			?>
			<div class="form_wrapper form-md">
				<?php $form_attribute = array('class' => 'form-horizontal','method'=>'post');
				    echo form_open('newsletter/add_subscriber',$form_attribute);
				?>
						<legend><?=@$title?></legend>		
						<fieldset>
						<!-- Text input-->
						<div class="form-group">
						  <label class="col-md-3 control-label" for="subsc_name">Subscriber name:</label>  
						  <div class="col-md-8">
							<input id="subsc_name" name="subs_name" type="text" class="form-control input-sm" maxlength="50" value="" required="">
							
						  </div>
						</div>

						<!-- Text input-->
						<div class="form-group">
						  <label class="col-md-3 control-label" for="subsc_email">Subscriber email:</label>  
						  <div class="col-md-8">
							<input id="subsc_email" name="subs_email" type="text" class="form-control input-sm" maxlength="50" value="" required="">
							
						  </div>
						</div>
						
						
						<!-- Multiple Checkboxes -->
						<div class="form-group">
							<label class="col-md-3 control-label" for="subs_group">Group</label>
							<div class="col-lg-6">
								<?php
								$i=0;
								if ($newsletter_group) {
									foreach ($newsletter_group as $group) {
										?>
										<div class="checkbox">
											<label for="subs_group-<?=$i?>">
												<input type="checkbox" name="subs_group[]" id="subs_group-<?=$i?>" value="<?=$group->gid?>"><?=$group->group_name?>
								    		</label>
								    	</div>
										<?php
										$i++;
									}
								}
								?>
								
						    
						  	</div>
						</div>
						<!-- Button (Double) -->
						<div class="form-group">
						  <label class="col-md-4 control-label" for="submit"></label>
						  <div class="col-md-8">
							<button id="submit" name="submit" class="btn btn-success">Submit</button>
							<button id="cancel" name="cancel" class="btn btn-default">Cancel</button>
						  </div>
						</div>
						
					</fieldset>
						
				<?php echo form_close(); ?>
			</div>
		</div>
	
</section> <!-- /main-content -->

<?php      require_once(APPPATH.'views/template/footer.php'); ?>