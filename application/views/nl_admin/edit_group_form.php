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
				    echo form_open('newsletter/edit_group/'.@$group_info->gid, $form_attribute);
					($group_info->status=='active')? $active_selected='"selected"':$inactive_selected='selected';
				?>
						<legend><?=@$title?></legend>		
						<fieldset>
						<!-- Text input-->
						<div class="form-group">
						  <label class="col-md-3 control-label" for="group_name">Group name:</label>  
						  <div class="col-md-4">
							<input id="group_name" name="group_name" type="text" class="form-control input-sm" maxlength="50" value="<?=@$group_info->group_name?>" required="">
							
						  </div>
						</div>
						<!-- Text input-->
						<div class="form-group">
						  <label class="col-md-3 control-label" for="group_status">Group status:</label>  
						  <div class="col-md-4">
							<select id="group_status" name="group_status" class="form-control input-sm">
								<option value="active" <?=@$active_selected?>>Active</option>
								<option value="inactive" <?=@$inactive_selected?>>Inactive</option>
							</select>
							
						  </div>
						</div>
						<input type="hidden" name="gid" value="<?=@$group_info->gid?>">
						<!-- Button (Double) -->
						<div class="form-group">
						  <label class="col-md-3 control-label" for="submit"></label>
						  <div class="col-md-4">
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