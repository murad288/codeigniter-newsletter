<?php      require_once(APPPATH.'views/template/header.php'); ?>
<style>
    @media screen and (min-width: 768px) {
        .modal-dialog {
          width: 700px; /* New width for default modal */
        }
        .modal-sm {
          width: 350px; /* New width for small modal */
        }
    }
    @media screen and (min-width: 992px) {
        .modal-lg {
          width: 950px; /* New width for large modal */
        }
    }
</style>
<!-- Main content -->
<section class="content">
	
		<div class="row">
			<?php
			if (isset($this->session->successMsg)) {
				?>
				<p class="alert alert-info"><?=$this->session->successMsg?></p>
				<?php
			}

			if (isset($this->session->errorMsg)) {
				?>
				<p class="alert alert-danger"><?=$this->session->errorMsg?></p>
				<?php
			}
			?>
			
			<div class="form_wrapper form-lg">
				<legend><?=@$title?></legend>
				<div class="panel-body table-responsive">
					
                    <div class="box-tools m-b-15">
                    	<a href="<?=base_url('newsletter/draft_newsletter')?>" class="pull-left btn btn-primary">Draft Newsletter</a>
                        <div class="input-group">
                            <input type="text" name="table_search" class="form-control input-sm pull-right" style="width: 150px;" placeholder="Search"/>
                            <div class="input-group-btn">
                                <button class="btn btn-sm btn-default"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                    <table class="table table-hover">
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Group</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Update time</th>
                        </tr>
                        <?php
                        if (isset($newsletters)) {
                        	if ($newsletters) {//if result found
                        		foreach ($newsletters as $newsletter_list) {
                        			$status = $newsletter_list->status;
                                    $encoded_nl_tracking = $this->NewsletterModel->encode_newsletter_tracking_no($newsletter_list->tracking_no);
                        			$date = date('d-m-Y h:i:s',strtotime($newsletter_list->date_created));
                                    $update_date = $newsletter_list->update_time;
                        			if ($status =='active') $status_style='label label-success';
                        			if ($status =='unsubscribed') $status_style='label label-default';
                        			if ($status =='banned') $status_style='label label-danger';
                        			if ($status =='Inactive') $status_style='label label-warning';
                        			?>
                        			<tr id="<?=$encoded_nl_tracking?>">
                        				<td><?=$newsletter_list->nl_id?></td>
                        				<td><?=$newsletter_list->title?>
                                            
                                            <div id="<?=$encoded_nl_tracking?>">
                                                <a href="<?=base_url()?>newsletter/edit_newsletter/<?=$newsletter_list->nl_id?>"> <i class="fa fa-edit"></i> Edit</a> | 
                                                <a href="trash_newsletter"  class="trash_newsletter" id=""> <i class="fa fa-trash-o"></i>  Delete</a> | 
                                                <a href="send_newsletter"  class="send_newsletter"><i class="fa fa-envelope"></i>  Send</a>
                                            </div>
                                        </td>
                        				<td>
                        					<?php echo $newsletter_list->nl_group;
                                            $subscr_group = explode(',', $newsletter_list->nl_group);
                                            foreach ($subscr_group as $group_id) {

                                                ?>
                                                <span class="label label-default"><?=@$nl_group_list[$group_id]?></span>
                                                <?
                                            }
                                            ?>
                        					</td>
                        				<td><span class="<?=@$status_style?>"><?=$newsletter_list->status?></span></td>
                        				<td><?=$date?></td>
                        				<td><?=$update_date?></td>
                                        <td></td>
                                        
                        			</tr>
                        			<?php
                        		}
                        	}else{
                        		echo "<tr><td colspan='7'>No newsletter found.</td></tr>";
                        	}
                        }
                        ?>
                        
                    </table>
                    <div class="table-foot">
                        <ul class="pagination pagination-sm no-margin pull-right">
                            <li><a href="#">&laquo;</a></li>
                            <li><a href="#">1</a></li>
                            <li><a href="#">2</a></li>
                            <li><a href="#">3</a></li>
                            <li><a href="#">&raquo;</a></li>
                    	</ul>
                    </div>
                </div><!-- /.box-body -->
                
			</div>
		</div>
	
</section> <!-- /main-content -->

<!-- Modal -->
<div class="modal bs-example-modal-lg fade" id="myModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalMprof" >
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header"align="center">
        <h4 class="modal-title" id="myModalTitle">Modal</h4>
        <button type="button" class="close" data-dismiss="modal">
            <span aria-hidden="true">&times; </span>
            <span class="sr-only">Chiudi</span>
        </button>        
      </div>
      <b><div class="modal-body" id="modalContent">
      </div></b>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>

<?php      require_once(APPPATH.'views/template/footer.php'); ?>

<script type="text/javascript">
    $(document).ready(function(){
        $('.form_wrapper').on('click','a.trash_newsletter',function(e){
            e.preventDefault();
            var track_no = $(this).parent('div').attr('id'); 

            if (confirm('Are you want to delete this newsletter?')) {
                $.ajax({
                    type: 'post',
                    data : {tracking_no:track_no},
                    cache: false,  
                    url: $(this).attr('href'), 
                    dataType: 'json',
                    success: function(response){ 
                        if(response.msg=='success'){
                            $('#'+track_no).find("td").fadeOut(1000, function(){ $(this).parent().remove();});
                        }else{
                            alert(response.msg);
                        }
                        //console.log(response);
                    },
                    error: function(error){
                        console.log(error);
                    }
                });
            }else{
                return false;
            }
            
            
            
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function(){
        $('.form_wrapper').on('click','a.send_newsletter',function(e){
            e.preventDefault();
            var track = $(this).parent('div').attr('id');

            $('#myModalTitle').empty().html('Send Newsletter');
            $('#modalContent').empty().html('Loading... Please wait....');
            $('#myModal').modal('show');
            
            //var numStep = 2;
            //loadAjaxStep(1); 
            $.ajax({
                type: 'post',
                data : {tracking_no:track},
                cache: false,  
                url: $(this).attr('href'), 
                dataType: 'json',
                success: function(response){ 
                    if(response.status=='success'){
                        $('#modalContent').empty().html(response.msg);
                        if(response.que_status == 'success'){
                            $('#modalContent').append('Done.');
                            sendNewsLetter();
                        }else{
                            alert('Error.'+response.msg);
                        }
                    }else{
                        alert(response.status);
                    }
                    //console.log(response);
                },
                error: function(error){
                    console.log(error.responseText);
                }
            });
            function sendNewsLetter(){
                $('#modalContent').append('<br>Sending newsletter. Please wait....');
                $.ajax({
                    type: 'post',
                    data : {},
                    cache: false,  
                    url: 'send_email_newsletter', 
                    dataType: 'json',
                    success: function(response){ 

                        if(response.status=='success'){
                            $('#modalContent').append(response.msg);
                        }else if(response.status=='failed'){
                            $('#modalContent').append(response.msg);
                        }
                        

                        console.log(response);
                    },
                    error: function(error){ 
                        //alert(error.responseText);
                        $('#modalContent').append(error.responseText);
                        console.log(error);
                    }
                });
            }
            
            
        });
    });
</script>