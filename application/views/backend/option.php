<div class="bread_parent">
<ul class="breadcrumb">
    <li><a href="<?php echo base_url('backend/superadmin/dashboard');?>"><i class="icon-home"></i> Dashboard  </a></li>
    <li><b>Setting</b> </li>
</ul>
</div>
<div class="panel-body">
  <div class="adv-table">
    <div class="portlet-body form">
  <!-- BEGIN FORM-->
  <section class="panel">
      <?php echo form_error();?>       
  <form class="form-horizontal" method="post" action="<?php echo current_url()?>" enctype="multipart/form-data">
  <?php echo $this->session->flashdata('msg_error');?>
  <?php echo form_error('name[]'); ?>
     <div class="form-body">
        <?php $i=0;
        foreach ($option as $value) {
          if($i==0){ ?>
             <header class="panel-heading colum">
                 Social Media <i class="icon-cogs"></i>
              </header><?php
          }                      
          elseif($i==7){ ?>
             <header class="panel-heading colum">
                  Address <i class="icon-map-marker"></i>
              </header><?php
          }
          elseif($i==12){ ?>
             <header class="panel-heading colum">
                  Fix content <i class="icon-money"></i>
              </header><?php
          }
           elseif($i==17){ ?>
             <header class="panel-heading colum">
                  Stores  <i class="icon-money"></i>
              </header><?php
          }
          ?>

      <div class="form-group">
           <label class="col-md-3 control-label"><?php echo $value->option_name;?></label> 

           <div class="col-md-9">
           <?php if($value->id==24 || $value->id==25 ){ ?>
           <textarea class="form-control tinymce_edittor" rows="1" cols="6" name="name[]"><?php echo $value->option_value;?></textarea>
           <?php }elseif($value->id==26){

            if($value->option_value){ ?>
                <div style="width: 200px;" class="fileupload-new thumbnail">
                    <img alt="" src="<?php echo base_url().$value->option_value;?>">
                </div>
               <?php } ?>
               <b>Want to update banner image</b>
                <input type="file" name="bg_image" class="btn default btn-file">
            <?php }
            else{                  
             ?>       
             <input type="text" <?php if($value->id==22){ ?> pattern="https?://.+" title="Include http://"  <?php } ?> placeholder="<?php echo $value->option_value ?>" class="form-control" name="name[]" value="<?php echo $value->option_value;?>">
            <?php  } ?> 
              <input type="hidden" name="ids[]" value="<?php echo $value->id;?>">
           </div>
        </div> 
        <?php $i++;} ?>
     </div>
     <div class="form-actions fluid">
        <div class="col-md-offset-2 col-md-10">
          <input type="hidden" name="option" value="1">
           <button class="btn btn-primary" type="submit">Save</button>
           <a href="<?php echo base_url()?>backend/superadmin/dashboard">
           <button class="btn btn-danger" type="button">Cancel</button>  </a>                            
        </div>
     </div>
  </form>
  </section>
  <!-- END FORM--> 
</div>
</div>
</div>

<style>
.colum{
margin-bottom: 20px;
}
</style>

