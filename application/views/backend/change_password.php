<div class="bread_parent">
  <ul class="breadcrumb">
      <li><a href="<?php echo base_url('backend/superadmin/dashboard');?>"><i class="icon-home"></i> Dashboard  </a></li>
      <li><b>Change Password</b> </li>           
  </ul>
</div>

<div class="panel-body">
   <div class="">
      <form role="form" method="post" class="form-horizontal" action="<?php echo current_url()?>">
        <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" />
         <div class="form-body label-static">
            <div class="col-md-10 center-block">
               <div class="form-group">
                  <label class="control-label col-md-4">Old Password<span class="mandatory">*</span> </label>
                  <div class="col-md-5">
                     <input type="password" placeholder="Old Password" class="form-control" name="oldpassword" value=""><?php echo form_error('oldpassword'); ?>
                  </div>
               </div>
               <div class="form-group">
                  <label class="control-label col-md-4">New Password<span class="mandatory">*</span> </label>
                  <div class="col-md-5">
                     <input type="password" placeholder="New Password" class="form-control" name="newpassword" value=""><?php echo form_error('newpassword'); ?>
                  </div>
               </div>
               <div class="form-group">
                  <label class="control-label col-md-4">Confirm Password<span class="mandatory">*</span></label>
                  <div class="col-md-5">
                     <input type="password" placeholder="Confirm Password" class="form-control" name="confpassword" value=""><?php echo form_error('confpassword'); ?>
                  </div>
               </div>
            </div>
            <div class="clearfix"></div>
            <div class="form-btn-block">
               <div class="col-md-10 center-block">
                  <div class="form-group text-center">
                     <button class="btn btn-primary" type="submit"><i class="icon-repeat"></i>  Update Password</button>
                  </div>
               </div>
            </div>
         </div>
      </form>
   </div>
</div>