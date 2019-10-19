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
			if (isset($error)) {
				echo '<p class="alert alert-danger">'.$error.'</p>';
			}else{
				

			?>
			<div class="form_wrapper form-md">
				<?php $form_attribute = array('class' => 'form-horizontal','method'=>'post');
				    echo form_open('newsletter/subscriber_edit/'.$subsc_info->id, $form_attribute);
				?>
						<legend><?=@$title?></legend>		
						<fieldset>
						<!-- Text input-->
						<div class="form-group">
						  <label class="col-md-3 control-label" for="subsc_name">Subscriber name:</label>  
						  <div class="col-md-8">
							<input id="subsc_name" name="subs_name" type="text" class="form-control input-sm" maxlength="50" value="<?=$subsc_info->name?>" required="" >
							
						  </div>
						</div>

						<!-- Text input-->
						<div class="form-group">
						  <label class="col-md-3 control-label" for="subsc_email">Subscriber email:</label>  
						  <div class="col-md-8">
							<input id="subsc_email" name="subs_email" type="text" class="form-control input-sm" maxlength="50" value="<?=$subsc_info->email?>" readonly>
							
						  </div>
						</div>
						
						
						<!-- Multiple Checkboxes -->
						<div class="form-group">
							<label class="col-md-3 control-label" for="subs_group">Group</label>
							<div class="col-lg-6">
								<?php
								$i=0;
								$subscr_group = explode(',', $subsc_info->subscription_group);
								if ($newsletter_group) {
									foreach ($newsletter_group as $group) {
										(in_array($group->gid, $subscr_group))? $style="checked":$style='';
										?>
										<div class="checkbox">
											<label for="subs_group-<?=$i?>">
												<input type="checkbox" name="subs_group[]" id="subs_group-<?=$i?>" value="<?=$group->gid?>" <?=$style?>><?=$group->group_name?>
								    		</label>
								    	</div>
										<?php
										$i++;
									}
								}
								?>
						    
						  	</div>
						</div>

						<!-- Text input-->
						<div class="form-group">
						  <label class="col-md-3 control-label" for="status">Status:</label>  
						  <div class="col-md-4">
							<select class="form-control input-sm" name="status">
								<option value="active">Active</option>
								<option value="Inactive">Inactive</option>
							</select>
							
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
			<?php

			}
			?>
		</div>
	
</section> <!-- /main-content -->

<?php      require_once(APPPATH.'views/template/footer.php'); ?>