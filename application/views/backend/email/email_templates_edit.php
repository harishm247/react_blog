<div class="bread_parent">
   <ul class="breadcrumb">
      <li><a href="<?php echo base_url('backend/superadmin/dashboard');?>"><i class="icon-home"></i> Dashboard  </a></li>
      <li><a href="<?php echo base_url('backend/email_templates/'); ?>">Email Templates </a></li>
      <li><b>Edit Email Template</b></li>
   </ul>
</div>
<div class="panel-body">
   <form role="form" class="form-horizontal tasi-form" action="<?php echo current_url()?>" enctype="multipart/form-data" method="post">
      <div class="form-body">
         <div class="form-group">
            <label class="col-md-2 control-label">Template Name<span class="error">*</span></label>
            
            <div class="col-md-10">
               <input type="text" class="form-control" name="template_name" value="<?php if(!empty($email_template[0]->template_name)) echo $email_template[0]->template_name ; else echo set_value('template_name'); ?>"><?php echo form_error('template_name'); ?>
            </div>
         </div>
         <div class="form-group">
            <label class="col-md-2 control-label">Template Subject<span class="error">*</span></label>
            <div class="col-md-10">
               <input type="text" class="form-control" name="template_subject" value="<?php if(!empty($email_template[0]->template_subject)) echo $email_template[0]->template_subject ; else echo set_value('template_subject');?>"><?php echo form_error('template_subject'); ?>
            </div>
         </div>
         <div class="form-group">
            <label class="col-md-2 control-label">Email Template Body<span class="error">*</span></label>
            <div class="col-md-10">
               <textarea  class="tinymce_edittor form-control" cols="100" rows="7" name="template_body"><?php if(!empty($email_template[0]->template_body)) echo $email_template[0]->template_body; else echo set_value('template_body'); ?></textarea><?php echo form_error('template_body'); ?>
            </div>
         </div>
         <hr>
         <div class="form-group">
            <label class="col-md-2 control-label">Template Subject (For Admin) </label>
            <div class="col-md-10">
               <input type="text" class="form-control" name="template_subject_admin" value="<?php if(!empty($email_template[0]->template_subject_admin)) echo $email_template[0]->template_subject_admin; else echo set_value('template_subject_admin'); ?>"><?php echo form_error('template_subject_admin'); ?>
            </div>
         </div>
         <div class="form-group">
            <label class="col-md-2 control-label">Email Template Body (For Admin) </label>
            <div class="col-md-10">
               <textarea  class="tinymce_edittor form-control" cols="100" rows="7" name="template_body_admin"><?php if(!empty($email_template[0]->template_body_admin)) echo $email_template[0]->template_body_admin; else echo set_value('template_body_admin'); ?></textarea><?php echo form_error('template_body_admin'); ?>
            </div>
         </div>
         <div class="form-group">
            <label class="col-md-2 control-label">Email Enable</label>    
         <div class="col-md-10">
            <select name="email_status" class="form-control">
               <option value="1"<?php if(!empty($email_template[0]->template_email_enable==1)) echo "selected"; ?>>Yes</option>
               <option value="2"<?php if(!empty($email_template[0]->template_email_enable==2)) echo "selected"; ?>>No</option>
            </select>
          </div>
         </div>
      </div>

      <div class="clearfix"></div>

      <div class="form-actions fluid">
         <div class="col-md-offset-2 col-md-10">
            <button class="btn btn-primary tooltips" type="submit"><!-- <i class="icon-repeat"></i> --> Update</button>
            <a href="<?php echo base_url()?>backend/email_templates/" class="btn btn-danger" ><!-- <i class="icon-remove"></i> --> Cancel
            </a>                              
         </div>
      </div>
   </form>
   <!-- END FORM--> 
</div>