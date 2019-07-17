<div class="bread_parent">
<ul class="breadcrumb">
    <li><a href="<?php echo base_url('backend/superadmin/dashboard');?>"><i class="icon-home"></i> Dashboard  </a></li>
     <li><a href="<?php echo base_url('backend/content/pages'); ?>">Pages </a></li>
      <li><a href="<?php echo base_url('backend/content/page_add'); ?>"><b>Add Pages</b> </a></li>         
</ul>
</div> 
  <div class="panel-body">
      <form role="form" class="form-horizontal tasi-form" action="<?php echo current_url()?>" enctype="multipart/form-data" method="post">

          <?php echo $this->session->flashdata('msg_error');?>
          <div class="form-body">
            <div class="form-group">
              <label class="col-md-2 control-label">Title</label>
              <div class="col-md-10">
                <input type="text" placeholder="Page Title" class="form-control" name="page_title" value="<?php echo set_value('page_title');?>"><?php echo form_error('page_title'); ?>
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-2 control-label">Content</label>
              <div class="col-md-10">
                <div class="input-group">
                  <textarea class="tinymce_edittor form-control" cols="100" rows="12" name="page_content"><?php echo set_value('page_content');?></textarea>
                  <?php echo form_error('page_content'); ?>
                </div>
              </div>
            </div>
          </div>
          <div class="form-actions fluid">
            <div class="col-md-offset-2 col-md-10">
              <button  class="btn btn-primary" type="submit">Submit</button>
              <a class="btn btn-danger" href="<?php echo base_url()?>backend/content/pages">
               Cancel</a>                              
              </div>
            </div>
          </form>
          <!-- END FORM--> 
        </div>
      