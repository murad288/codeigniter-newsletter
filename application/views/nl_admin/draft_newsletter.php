<?php      require_once(APPPATH.'views/template/header.php'); ?>


<!-- include summernote css/js -->
<link href="<?=base_url('assets/css/summernote/summernote.css')?>" rel="stylesheet">
<!-- select2 -->
    <link href="<?=base_url('assets/css/select/select2.min.css')?>" rel="stylesheet">

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
					  <label class="col-md-2 control-label" for="nl_group">Newsletter group</label>
					  <div class="col-md-8">
					  	<select id="nl_group" name="nl_group[]" class="form-control input-sm select2_multiple" >
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
					  <label class="col-md-2 control-label" for="emails">Email</label>
					  <div class="col-md-8">
					    
					    <select multiple="" name="nl_email[]" class="select2_multiple_email form-control input-sm "></select>
					    
					  </div>
					</div>

					<!-- Text input-->
					<div class="form-group">
					  <label class="col-md-2 control-label" for="emails">Title</label>
					  <div class="col-md-8">
					    <input id="emails" name="nl_title" type="text" placeholder="Enter newsletter title" class="form-control input-sm">
					  </div>
					</div>

					<!-- Textarea -->
					<div class="form-group">
					  <label class="col-md-2 control-label" for="newsletter">Newsletter</label>
					  <div class="col-md-10"><a href="load_newsletter" id="load_newsletter">Load newsletter template</a>
					    <textarea id="summernote" name="nl_contents" class="form-control input-sm" style="overflow: hidden;"><?php 
					    require_once(APPPATH.'views/template/nl_template02.php'); 
					    ?> </textarea>
					    
					  </div>
					</div>

					<!-- Button (Double) -->
					<div class="form-group">
					  <label class="col-md-3 control-label" for="cancel"></label>
					  <div class="col-lg-6">
					    <button id="cancel" name="cancel" class="btn btn-default">Cancel</button>
					    <button id="save" name="save" class="btn btn-success">Save</button>
					  </div>
					  <div class="work_message"></div>
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
<script src="<?=base_url('assets/ajax/ajax_settings.js')?>"></script>

<script src="<?=base_url('assets/js/plugins/summernote/summernote.js')?>"></script>
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

<script src="<?=base_url()?>assets/js/plugins/select/select2.full.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		//multiselect
		$(".select2_multiple").select2({
            maximumSelectionLength: 5,
            placeholder: "Select group - Maximum 5 group",
            allowClear: true
        });

        $(".select2_multiple_email").select2({
            maximumSelectionLength: 5,
            placeholder: "Type email - Maximum 5 email",
            allowClear: true,

            ajax: {
			    url: "<?=base_url()?>newsletter/search_subscribers_email/",
			    type: 'post',
			    dataType: 'json',
			    delay: 250,
			    data: function (params) {
			      return {
			        searchTerm: params.term, // search term
			        //page: params.page
			      };
			    },
			    processResults: function (data) {
			      // parse the results into the format expected by Select2
			      // since we are using custom formatting functions we do not need to
			      // alter the remote JSON data, except to indicate that infinite
			      // scrolling can be used
			      //console.log(data);

			      return {
			        results: data,
			        
			      };
			    },
			    cache: true
			  }
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

			
			$.ajax({ 
				type: 'post',
				data : frm_data,
				cache: false,  
				url: frm_url, 
	    		processData: false,
    			contentType: false,
				success: function(return_msg){ 
					$('.work_message').empty();
					var json = $.parseJSON(return_msg);
					
					if (json.success) {
						alert('Drafting success.');
						window.location.href= "./n_list/";
					}else if (json.error){
						alert(json.error);
						//$(form_wrapper).empty().removeClass('form-sm').html(return_msg); 
					}
					
					console.log(return_msg);

					 
				    //alert($(form_wrapper).html());
				},
				error: function(err){
					console.log(err);
				}
				
			});
		});

		//load newsletter

		$('.form_wrapper').on('click','a#load_newsletter', function(e){
			e.preventDefault();
			alert('working');
			
		});

		
		
	});
	
</script>

<script type="text/javascript">
	
</script>

