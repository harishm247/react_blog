<div class="bread_parent">
   <ul class="breadcrumb">
      <li><a href="<?php echo base_url('backend/support/dashboard');?>"><i class="icon-home"></i> Dashboard  </a></li>
      <li><a href="<?php echo base_url('backend/support/user_contactus'); ?>">Support </a></li>
      <li><a href=""><b>Reply </b> </a></li>
   </ul>
</div>
<div class="mail-option mail-box ">
   <div class="col-xs-12 col-ms-2 col-md-2 no-padding">
      <div class="row">
         <div class="col-xs-12 col-sm-12 col-md-12">
            <aside class="sm-side">
               <?php  $this->load->view('backend/support/comman_left');  ?>  
            </aside>
         </div>
      </div>
   </div>
   <div class="col-xs-12 col-ms-10 col-md-10">
      <div class="row">
         <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="panel-body">
               <div class="">
                  <div class="dashboard-tab-sub-warp">
                     <div class="rply_head_row clearfix">
                        <div class="col-xs-12 col-sm-6 col-md-6">
                           <h3><i class="icon-user"></i><span> Reply Message</span></h3>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 text-right">
                           <?php if(!empty($message)){ ?>
                           <h3 class=""><?php echo "#Ticket ID : ".$message->support_id; ?></h3>
                           <?php if(isset($message->mark_complete) && $message->mark_complete==0){ ?>
                           <a class="label label-success label-mini tooltips" href="<?php echo base_url('backend/support/mark_complete/'.$message->support_id.'/'.$message->mark_complete) ?>" rel="tooltip" data-placement="top" data-original-title="Mark as complete" > Incomplete </a> 
                           <?php } 
                              else{ ?>
                           <a class="label label-warning label-mini tooltips" href="<?php echo base_url('backend/support/mark_complete/'.$message->support_id.'/'.$message->mark_complete)?>" rel="tooltip" data-placement="top" data-original-title="Mark as incomplete" > Complete </a> 
                           <?php }?> 
                           <?php } ?>
                        </div>
                     </div>
                     <?php if(!empty($support_detail)){ ?>
                     <div class="support-chats support_chat_conversation">
                        <?php
                           foreach ($support_detail as $row){
                           	   $userData = array();
	                           if($row->user_id && ($row->user_role==1 || $row->user_role==0)){
	                           		$userData = getRow('users',array('user_id'=>$row->user_id),array('user_name','user_role'));
	                           } 
                        ?>  
                        <div >
                           <div class='<?php if($row->user_role==1 || $row->user_role==0 || $row->user_role==3){ 
                              echo "alert alert-info user-mail"; 
                              }else{ 
                              echo "alert alert-success admin-reply"; 
                              } ?>'>
                              <?php if(!empty($row->message)){
                                 $thread='';
                                 if($row->parent_id==0){
                                 	$thread = 1;
                                 }else{
                                 	$thread = 0;
                                 }
                                 
                                 if($row->user_role==1 || $row->user_role==0 || $row->user_role==3){ 
                              ?> 
                              <p>
                                 <b><i class="fa fa-user"></i>&nbsp;
                                 	<?php 
                                 		if(!empty($row->firstname)){
                                 	 		echo ucfirst($row->firstname);
                                 	 	}else{
                                 	 		echo ucfirst($userData->user_name);
                                 	 	}
                                 	 ?>
                                 </b> 
                              </p>
                              <?php }else{ ?> 
	                              <p class="admin-name"><b><i class="fa fa-headphones"></i> &nbsp;Support Team</b>
	                              </p>
                              <?php } ?>
                              <p class="chats-content" style='text-align:justify'>
                                 <?php if(!empty($row->message)){ echo $row->message; } ?> 
                              </p>
                              <div class="clearfix"></div>
                              <div class="pull-right chat-time"><i class="fa fa-clock-o"></i>&nbsp;
                                 <?php if(!empty($row->created)){ echo date('d m Y, H:i:s',strtotime($row->created)); } ?>
                              </div>
                              <?php 
                                 } ?>
                              <?php if($row->user_role==1){ ?>
                              <div class="pull-right chat-time">
                                 <i class="fa fa-envelope"></i>&nbsp;
                                 <?php if(!empty($row->email)){ echo $row->email; }else{ echo $message->email;  }
                                    ?>&nbsp;&nbsp;&nbsp;&nbsp;
                              </div>
                              <?php } ?>
                              <div class="clearfix"></div>
                              <?php if($row->user_role==1){ ?>
                              <div class="clearfix"></div>
                              <?php } ?>
                           </div>
                        </div>
                        <?php } ?>
                     </div>
                     <?php if(isset($message->user_id) && $message->user_id >0){ 
                        if(isset($message->mark_complete) && $message->mark_complete==0){ ?>
                     <form action="<?php echo current_url() ?>" method="post" id="form_valid" >
                        <div class="chats-text">
                           <textarea name="reply_message" rows="3" class="form-control" placeholder="Type your message here..." data-bvalidator="required" data-bvalidator-msg="Reply is required"></textarea>
                           <p class="required"><?php echo form_error('reply_message') ?></p>
                        </div>
                        <button class="btn btn-primary pull-right" type="submit"><i class="fa fa-reply"></i>&nbsp; Reply</button>
                        <div class="clearfix"></div>
                     </form>
                     <?php } 
                        }
                        }
                        else{ ?>
                     <center>No messages found.</center>
                     <?php 
                        } ?>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>