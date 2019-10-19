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
			<div class="form_wrapper form-sm">
				<?php $form_attribute = array('class' => 'form-horizontal','method'=>'post');
				    echo form_open('newsletter/subscriber_delete/'.$id, $form_attribute);
				?>
					<legend><i class="fa fa-exclamation-triangle"></i> <?=@$title?></legend>
					<fieldset>
						<p><b>Subscriber name: </b> <?=$subsc_info->name?></p>
						<p><b>Subscriber email: </b> <?=$subsc_info->email?></p>
						
						<p style="color:red; padding: 10px;"><i class="fa fa-exclamation-triangle"></i> Do you want to delete this subscriber?</p>
						<input type="hidden" name="subsc_id" value="<?=$id?>">
						<!-- Button (Double) -->
						<div class="form-group">
						  <label class="col-md-4 control-label" for="submit"></label>
						  <div class="col-md-8">
							<button id="submit" name="submit" class="btn btn-danger">Delete</button>
							<button id="cancel" name="cancel" class="btn btn-default">Cancel</button>
						  </div>
						</div>
						
					</fieldset>
						
				<?php echo form_close(); ?>
			</div>
		</div>
	
</section> <!-- /main-content -->

<?php      require_once(APPPATH.'views/template/footer.php'); ?>