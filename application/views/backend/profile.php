<div class="bread_parent">
  <ul class="breadcrumb">
    <li><a href="<?php echo base_url('backend/superadmin/dashboard');?>"><i class="icon-home"></i> Dashboard  </a></li>
    <li><b>My Profile</b> </li>    
  </ul>
</div>

<div class="panel-body">
   <div class="">
      <form role="form" method="post" class="form-horizontal" action="<?php echo current_url()?>">
      <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>"/>
     
         <div class="form-body label-static">
            <div class="col-md-10 center-block">
               <div class="form-group">
                  <label class="control-label col-md-4">First Name<span class="mandatory">*</span> </label>
                  <div class="col-md-5">
                     <input type="text" placeholder="First Name" class="form-control" name="firstname" value="<?php if(!empty($user->first_name)) echo $user->first_name ; ?>" data-bvalidator="required,alpha" data-bvalidator-msg="First name is required and must be alphabate only"><?php echo form_error('firstname'); ?>
                  </div>
               </div>
               <div class="form-group">
                  <label class="control-label col-md-4">Last Name </label>
                  <div class="col-md-5">
                     <input type="text" placeholder="Last Name" class="form-control" name="lastname" value="<?php if(!empty($user->last_name)) echo $user->last_name ; ?>"><?php //echo form_error('lastname'); ?>
                  </div>
               </div>
               <div class="form-group">
                  <label class="control-label col-md-4">Email Address<span class="mandatory">*</span> </label>
                  <div class="col-md-5">
                     <input type="email" placeholder="Email Address" class="form-control" name="email" value="<?php if(!empty($user->email)) echo $user->email;?>" data-bvalidator="email" data-bvalidator-msg="Valid email-address is required"><?php echo form_error('email'); ?>
                  </div>
               </div>               
            </div>
            <div class="clearfix"></div>
            <div class="form-btn-block">
               <div class="col-md-10 center-block">
                  <div class="form-group text-center">
                     <button class="btn btn-primary" type="submit"><i class="icon-repeat"></i> Update Profile</button>
                  </div>
               </div>
            </div>
         </div>
      </form>
   </div>
</div>