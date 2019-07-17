<div class="bread_parent">
	<ul class="breadcrumb">
		<li><a href="<?php echo base_url('backend/support/dashboard');?>"><i class="icon-home"></i> Dashboard  </a></li>
		<li><a href="<?php echo base_url('backend/support/user_contactus'); ?>"><b>Support </b> </a></li>
	</ul>
</div>
<div class="mail-option mail-box ">
	<div class="col-md-2 no-left-padding">
		<aside class="sm-side">
			<?php $this->load->view('backend/support/comman_left'); ?>  
		</aside>
	</div>
	<div class="col-md-10 no-padding">
		<div class="inbox-head" >
			<form action="<?php echo base_url('backend/support/complete_tickets'); ?>" method="get" role="form" class="form-horizontal">
				<div class="panel-body col-sm-12 ">
					<table class="responsive table_head" cellpadding="5">          
						<thead >
							<tr>              
								<th width="10%">Request Subject</th>             
								<th width="10%">Request Id No.</th>
								<th width="10%">Starred/unstarred</th>
								<th width="10%">Request Order</th>
								<th width="10%"></th>  
							</tr>
						</thead>
						<tbody>
							<tr>
								<td width="10%">        
									<?php 
										$feedback_subjects=''; 
										$feedback_subjects = feedback_subject_status('all');
									?>                       
									<select name="subject" class="form-control">   
										<option value="0" >None</option> 
										<?php if(!empty($feedback_subjects)){ 
											foreach ($feedback_subjects as $key => $value) { ?>
												<option value="<?php echo $key; ?>" <?php if(!empty($_GET['subject']) && $_GET['subject']==$key) echo 'selected'?> ><?php echo $value; ?></option>               
											<?php } 
										} ?>               
									</select>
								</td> 
								<td width="">                               
									<input type="text" value="<?php if(!empty($_GET['support_id'])){ echo $_GET['support_id']; } ?>" name="support_id" class="form-control" >
								</td> 
								<td width="">                               
									<select name="sort_starred" class="form-control">                  
										<option value="0" >None</option> 
										<option value="1" <?php if(!empty($_GET['sort_starred']) && $_GET['sort_starred']=='1') echo 'selected'?> >Sort by Starred</option> 
										<option value="2" <?php if(!empty($_GET['sort_starred']) && $_GET['sort_starred']=='2') echo 'selected'?>>Sort by unstarred</option>
									</select>
								</td> 
								<td width="">                               
									<select name="order" class="form-control">                  
										<option value="2" <?php if(!empty($_GET['order']) && $_GET['order']=='2') echo 'selected'?> >Newest Request</option> 
										<option value="1" <?php if(!empty($_GET['order']) && $_GET['order']=='1') echo 'selected'?>>Oldest Request</option> 
									</select>
								</td>       
								<td> 
									<button type="submit" class="btn btn-primary tooltips" rel="tooltip" data-placement="top" data-original-title="Filter the notification" type="submit"><i class="icon icon-search"></i></button>
									<a class="btn btn-danger tooltips" href="<?php echo base_url('backend/support/complete_tickets'); ?>" rel="tooltip" data-placement="top" data-original-title="Reset" type="submit"> <i class="icon icon-refresh"></i></a>
								</td>
							</tr>
						</tbody>
					</table>
				</div>   
			</form>
		</div>
		<div class="adv-table table-responsive">
			<table class="table-bordered responsive table table-striped"  id="tab1">
				<thead class="thead_color">
					<tr>
						<th width="10%" class="jv no_sort">
							<div class="custom-checkbox-list">    
								<span class="checkboxli term-check">
									<input type="checkbox" name="checkAll" id="checkAll" class="">
									<label class="" for="checkAll"></label>
								</span> 
								<select name="commonstatus" id="commonstatus" class="form-control commonstatus order-select-status">
									<option value="">All</option>                                   
									<option value="1">Starred</option>                                   
									<option value="2">Unstarred</option>
									<option value="7">Incomplete</option> 
									 <option value="5">Delete</option>  
									                     
								</select>
							</div>
						</th>         
						<th><i class="icon-star  inbox-started "></i></th> 
						<th width="15%" class="no_sort">Support Subject</th>  
						<th width="20%" class="to_hide_phone ue no_sort">Request</th>                
						<th width="18%" class="to_hide_phone ue no_sort">Sender Name</th>
						<th width="15%" class="to_hide_phone span2">Request Time</th>
						<th width="15%" class="to_hide_phone span2">Request Complete</th>
						<th width="17%" class="ms no_sort ">Actions</th>
					</tr>
				</thead>
					<tbody>
						<?php if(!empty($contactus)): $i=$offset; 
							foreach($contactus as $row): $i++;
								$unread_msg='';
								$unread_msg=get_unread_msg_superadmin($row->support_id); ?>
								<tr class=" <?php if($unread_msg){ echo 'unread '; }else{ echo 'read '; } ?>">
									<td>
										<span class="checkboxli term-check">
											<input type="checkbox" id="checkall<?php echo $i ?>" name="checkstatus[]" value="<?php echo $row->support_id; ?>">
											&nbsp;&nbsp; 
											<label class="" for="checkall<?php echo $i ?>"></label>
										</span>
										<?php echo $i; ?>.
									</td>
									<td>
										<span class="inbox-small-cells important_notify">
											<a href="<?php echo base_url('backend/support/important_notification/'.$row->support_id.'/'.$row->mark_important.'/support') ?>"
											data-original-title="<?php if($row->mark_important==1){ echo 'Mark as Unstarred'; } else{ echo 'Mark as Starred'; } ?> "data-placement="bottom" rel="tooltip" class="tooltips">
											<i class="icon-star <?php if($row->mark_important==1){ ?> inbox-started <?php } ?>"></i> 
											</a>
										</span>   
									</td>    

									<td>
										<?php $feedback_subject='';
										$feedback_subject = feedback_subject_status($row->reason);?>
										<a href="<?php echo base_url().'backend/support/user_contactus_reply/'.$row->support_id.'/'.$offset?>" class="tooltips" rel="tooltip" data-placement="left" data-original-title="View Message"><?php echo $feedback_subject;?> 
										</a> 
									</td>
									<td class="">
										<a href="<?php echo base_url().'backend/support/user_contactus_reply/'.$row->support_id.'/'.$offset?>" class="tooltips" rel="tooltip" data-placement="left" data-original-title="View Message "><?php if(!empty($row->message)) echo word_limiter($row->message, 7); ?></a> 
									</td>               
									
																
									<td class="">
										<?php 
											if(!empty($row->firstname)) { 
												echo ucfirst($row->firstname);
											} else {
												if(!empty($message->firstname)) { 
													echo ucfirst($message->firstname);
												}
											} 
										?>
									</td>
									<td class="to_hide_phone"> <?php echo date('d M Y,H:i ',strtotime($row->created)); ?>  </td>
									<td class="to_hide_phone">
										<?php if(isset($row->mark_complete) && $row->mark_complete==0){ ?>
											<a class="label label-success label-mini tooltips" href="<?php echo base_url('backend/support/mark_complete/'.$row->support_id.'/'.$row->mark_complete)?>" rel="tooltip" data-placement="top" data-original-title="Mark as complete" > Incomplete </a> 
										<?php } 
										else{ ?>
											<a class="label label-warning label-mini tooltips" href="<?php echo base_url('backend/support/mark_complete/'.$row->support_id.'/'.$row->mark_complete)?>" rel="tooltip" data-placement="top" data-original-title="Mark as incomplete" > Complete </a> 
										<?php } ?> 
									</td>
									<td class="ms">
										<a href="<?php echo base_url().'backend/support/user_contactus_reply/'.$row->support_id.'/'.$offset?>" class="btn btn-success btn-xs tooltips"  rel="tooltip" data-placement="top" data-original-title="View Messages ">
											<i class="icon-eye-open"></i> 
										</a> 
										<a href="<?php echo base_url().'backend/support/delete_user_contactus/'.$row->support_id.'/'.$offset?>" class="btn btn-danger btn-xs black tooltips" rel="tooltip" data-placement="bottom" data-original-title="Remove" onclick="if(confirm('Do you want to delete it ?')){return true;} else {return false;}" >                   
											<i class="icon-trash "></i>
										</a> 
										<!--   </div> -->
									</td>
								</tr> 
							<?php endforeach; ?>
						<?php else: ?>
							<tr >
								<th colspan="8" > <center>No records found.</center></th>
							</tr>
						<?php endif; ?>
					</tbody>
				</table>
			</form>  
			<?php if(!empty($pagination)) {  ?>
				<div class="pull-right" >
					<?php echo $pagination;?>  
				</div>
			<?php } ?>
		</div>
	</div>
</div>

<script>
	$("#tab1 #checkAll").click(function () {
		if ($("#tab1 #checkAll").is(':checked')) {
			$("#tab1 input[type=checkbox]").each(function () {
				$(this).prop("checked", true);
			});
		} else {
			$("#tab1 input[type=checkbox]").each(function () {
				$(this).prop("checked", false);
			});
		}
	});
</script>
<script type="text/javascript" >
	jQuery(document).ready(function($) { 
		$('#commonstatus').change(function(event) {     
			var row_id=[] ;    
			var new_status=$(this).val();   
			if(new_status==1){
				var action_name = 'Starred';
			}else if(new_status==2){
				var action_name = 'Unstarred';
			}else if(new_status==5){
				var action_name = 'Delete';
			}else if(new_status==7){
				var action_name = 'Incomplete';
			}else{
				return false;
			}
			if($("input:checkbox[name='checkstatus[]']").is(':checked')){    
				if(confirm("Do you want to "+action_name+" it ?") == false){
				//window.location.reload(true);
				return false;
			}
			var i=0;
			$("input[type='checkbox']:checked").each(function() {
				row_id[i]=$(this).val();                
				i++;               
			});       
     
			$.post('<?php echo base_url() ?>'+'backend/support/change_all_status/support', {'status': new_status,'row_id': row_id}, function(data) {    
				if(data.status==true){  
					window.location.reload(true);
				}else{       
					window.location.reload(true);
					return false;
				}
			});    
			}else{
				errorMsg('Please Check the checkbox');
				return false;
			}  
		});
	});
</script>