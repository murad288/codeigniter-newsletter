<?php      require_once(APPPATH.'views/template/header.php'); ?>
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
                    	<a href="<?=base_url('newsletter/add_subscriber')?>" class="pull-left btn btn-primary">Add new subscriber</a>
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
                            <th>Name</th>
                            <th>Email</th>
                            <th>Group</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Option</th>
                        </tr>
                        <?php
                        if (isset($subscribers)) {
                        	if ($subscribers) {//if result found
                        		foreach ($subscribers as $subsc) {
                        			$status = $subsc->status;
                        			$date = date('d-m-Y h:i:s',strtotime($subsc->createdTime));
                        			if ($status =='active') $status_style='label label-success';
                        			if ($status =='unsubscribed') $status_style='label label-default';
                        			if ($status =='banned') $status_style='label label-danger';
                        			if ($status =='Inactive') $status_style='label label-warning';
                        			?>
                        			<tr>
                        				<td><?=$subsc->id?></td>
                        				<td><?=$subsc->name?></td>
                        				<td><?=$subsc->email?></td>
                        				<td>
                        					<?php
                                            $subscr_group = explode(',', $subsc->subscription_group);
                                            foreach ($subscr_group as $group_id) {

                                                ?>
                                                <span class="label label-default"><?=@$nl_group_list[$group_id]?></span>
                                                <?
                                            }
                                            ?>
                        					</td>
                        				<td><span class="<?=@$status_style?>"><?=$subsc->status?></span></td>
                        				<td><?=$date?></td>
                        				<td><a href="subscriber_edit/<?=$subsc->id?>" class=""><i class="fa fa-pencil"></i></a> | <a href="subscriber_delete/<?=$subsc->id?>"><i class="fa fa-trash-o"></i></a></td>
                        			</tr>
                        			<?php
                        		}
                        	}else{
                        		echo "<tr><td colspan='7'>No subscriber found.</td></tr>";
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

<?php      require_once(APPPATH.'views/template/footer.php'); ?>