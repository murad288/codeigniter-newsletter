<?php      require_once(APPPATH.'views/template/header.php'); ?>


<!-- include summernote css/js -->
<link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.css" rel="stylesheet">
<!-- include select2 css/js -->
<link href="<?=base_url('assets/plugins/bootstrap-multiselect/css/bootstrap-multiselect.css')?>" rel="stylesheet">

<!-- Main content -->
<section class="content">
	
		<div class="row">
			<div id="message" align="center"  style="overflow: hidden;margin-bottom: 10px;"></div>
			<?php 
			if (isset($this->session->err_msg)) {
				?>
				<p class="alert alert-danger"><?=$this->session->err_msg?></p>
				<?php
			}
			if (isset($error)) {
				foreach ($error as $err) {
					echo '<p class="alert alert-danger">'.$err.'</p>';
				}
				
			}else{
				

			?>
			<div class="form_wrapper form-lg">
				<?php $form_attribute = array('class' => 'form-horizontal','method'=>'post','id'=>'draft_nl_form');
				    echo form_open('newsletter/draft_newsletter', $form_attribute);
				?>
						
					
					<fieldset>

					<!-- Form Name -->
					<legend><?=@$title?></legend>	

					<!-- Text input-->
					<div class="form-group">
					  <label class="col-md-3 control-label" for="nl_group">Newsletter group</label>
					  <div class="col-md-6">
					  	<select id="nl_group" name="nl_group[]" class="form-control input-sm nl_group" multiple="multiple">
					  		<?php
					  		if (isset($newsletter_group) and $newsletter_group) {
					  			foreach ($newsletter_group as $group) {
					  				?>
					  				<option value="<?=$group->gid?>"><?=$group->group_name?></option>
					  				<?php
					  			}
					  		}
					  		?>
					  		
					  	</select>
					    
					  </div>
					</div>

					<!-- Text input-->
					<div class="form-group">
					  <label class="col-md-3 control-label" for="emails">Email</label>
					  <div class="col-md-6">
					    <input id="emails" name="nl_email" type="text" placeholder="Enter email" class="form-control input-sm nl_email">
					    <p class="help-block">More than one email separated by comma</p>
					  </div>
					</div>

					<!-- Text input-->
					<div class="form-group">
					  <label class="col-md-3 control-label" for="emails">Title</label>
					  <div class="col-md-6">
					    <input id="emails" name="nl_title" type="text" placeholder="Enter newsletter title" class="form-control input-sm">
					  </div>
					</div>

					<!-- Textarea -->
					<div class="form-group">
					  <label class="col-md-3 control-label" for="newsletter">Newsletter</label>
					  <div class="col-md-8"><a href="#">Load newsletter template</a>
					    <textarea id="summernote" name="nl_contents" class="form-control input-sm"><p><b>hhhhhhhhhh</b></p> </textarea>
					    
					  </div>
					</div>

					<!-- Button (Double) -->
					<div class="form-group">
					  <label class="col-md-3 control-label" for="cancel"></label>
					  <div class="col-lg-6">
					    <button id="cancel" name="cancel" class="btn btn-default">Cancel</button>
					    <button id="save" name="save" class="btn btn-success">Save</button>
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
<!-- include libraries(jQuery, bootstrap) -->




<?php      require_once(APPPATH.'views/template/footer.php'); ?>
<script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.js"></script>
<script type="text/javascript">
	$(document).ready(function() { 
		//Summernote RTE Help : https://summernote.org/deep-dive
	  $('#summernote').summernote({
	  	height: 300,
	  	toolbar: [
		  ['style', ['style']],
		  ['font', ['bold', 'underline', 'clear']],
		  ['fontname', ['fontname']],
		  ['fontsize', ['fontsize']],
		  ['color', ['color']],
		  ['para', ['ul', 'ol', 'paragraph']],
		  ['table', ['table']],
		  ['insert', ['link', 'picture', 'video']],
		  ['view', ['fullscreen', 'codeview', 'help']],
		]
		
	  
	  });
	});
</script>

<script src="<?=base_url('assets/plugins/bootstrap-multiselect/js/bootstrap-multiselect.js')?>"></script>
<script type="text/javascript">
	$(document).ready(function(){
		//Help: https://www.jqueryscript.net/form/jQuery-Multiple-Select-Plugin-For-Bootstrap-Bootstrap-Multiselect.html
		$('.nl_group').multiselect({
			buttonWidth: '500px',
            dropRight: true
		});
	});
</script>

<script type="text/javascript">
	

	
	$(document).ready(function(){
		$('.form_wrapper').on('submit','#draft_nl_form',function(event){
			event.preventDefault();
			var form_wrapper = $('.form_wrapper');
			var frm_url = $(this).attr('action');
			var frm_data = new FormData($(this)[0]);
			var group_list = $('.nl_group').val();
			var email_list = $('.nl_email').val();
//alert(group_list);
			if(group_list = 'null'){

				$('#message').empty().html('<span class="alert alert-danger">Group list is empty.</span>');
				$(group_list).focus();
				return false;
				
			}
			
			$.ajax({ 
				type: 'post',
				data : frm_data,
				cache: false,  
				url: frm_url, 
	    		dataType: "json",
				success: function(return_msg){ 
					alert(return_msg);
						//$(form_wrapper).empty().removeClass('form-sm').html(return_msg); 
					
					console.log(result);

					 
				    //alert($(form_wrapper).html());
				}
				
			});
		});

		function scrollToTop() { 
            window.scrollTo(0, 0); 
        } 
		
	});
	
</script>

<script type="text/javascript">
	
</script>