<div class="bread_parent">
<ul class="breadcrumb">
    <li><a href="<?php echo base_url('backend/superadmin/dashboard');?>"><i class="icon-home"></i> Dashboard  </a></li>
     <li><a href="<?php echo base_url('backend/content/pages'); ?>">Pages </a></li>
      <li><b>Edit Page</b></li>         
</ul>
</div> 
  <div class="panel-body">
      <form role="form" class="form-horizontal tasi-form" action="<?php echo current_url()?>" enctype="multipart/form-data" method="post">
          <?php echo $this->session->flashdata('msg_error');?>
          <div class="form-body">
            <div class="form-group">
              <label class="col-md-2 control-label">Title <span class="error">*</span></label>
         <div class="col-md-10">
            <input type="text" placeholder="Title" disabled="disabled" class="form-control" name="page_title" value="<?php if(!empty($page->title)) echo $page->title; else echo set_value('page_title');?>"><?php echo form_error('page_title'); ?>
         </div>
      </div>
    <div class="form-group">
         <label class="col-md-2 control-label"> Content <span class="error">*</span></label>
         <div class="col-md-10">
            <div class="input-group">
                <textarea class="tinymce_edittor form-control" cols="100" rows="12" name="page_content"><?php if(!empty($page->description)) echo ($page->description); else echo set_value('page_content');?></textarea><?php echo form_error('page_content'); ?>
               </div>
         </div>
      </div>
         <!--         <header class="panel-heading colum">Meta Information: </header><br>     
       
            <div class="form-group">
                <label class="col-md-2 control-label">Meta Title</label>
                <div class="col-md-9">
                 <textarea class="form-control" cols="150" rows="2" name="meta_title" placeholder="Meta Title"><?php if(!empty($page->meta_content)) echo ($page->meta_content); else echo set_value('meta_content');?></textarea>
                                 </div>
            </div> -->



       <!--      <div class="form-group">
              <label class="col-md-2 control-label">Meta Keywords </label>
              <div class="col-md-9">
               <textarea class="form-control" cols="150" rows="3" name="meta_keywords" placeholder="Meta Keywords"><?php if(!empty($page->meta_keyword)) echo ($page->meta_keyword); else echo set_value('meta_keyword');?></textarea>
                             
              </div>
            </div> -->


          <!--   <div class="form-group">
              <label class="col-md-2 control-label">Meta Descritpion </label>
              <div class="col-md-9">
               <textarea class="form-control" cols="150" rows="4" name="meta_description" placeholder="Meta Descritpion"><?php if(!empty($page->meta_description)) echo ($page->meta_description); else echo set_value('meta_description');?></textarea>          
               <b class="validation_info">The Brief Content must not have more than 225 characters.</b><br> 
                               
              </div>
            </div> -->
 
    </div>
     <div class="form-actions fluid">
      <div class="col-md-offset-2 col-md-10">
         <button class="btn btn-primary" type="submit">Submit</button>
         <a href="<?php echo base_url()?>backend/content/pages" class="btn btn-danger">Cancel </a>                             
      </div>
   </div>
</form>
<!-- END FORM--> 
</div>
