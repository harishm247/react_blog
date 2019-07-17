<style type="text/css">
   hr.style1{
   border:none;
   border-left:1px solid hsla(200, 10%, 50%,100);
   height:100vh;
   width:1px;
   }
</style>
<div class="bread_parent">
   <ul class="breadcrumb">
      <li><a href="<?php echo base_url('backend/superadmin/dashboard');?>"><i class="icon-home"></i> Dashboard  </a></li>
      <li><a href="<?php echo base_url('backend/tasks'); ?>">Tasks Managment </a></li>
      <li><b>Add Task</b></li>
   </ul>
</div>


<div class="col-sm-12">
   <div class="panel-body">
      <form role="form" class="form-horizontal tasi-form" action="<?php echo current_url()?>" enctype="multipart/form-data" method="post">
         <?php //echo validation_errors(); ?>
         <?php echo $this->session->flashdata('msg_error');?>
         <header class="panel-heading colum"><i class="fa fa-angle-double-right"></i>Task information :</header>
         <br>
		  <div class="form-group">
            <label class="col-md-2 control-label">Project <span class="mandatory">*</span></label>
            <div class="col-md-9">
               <select class="form-control" name="project_id" >
			      <option value="">Select project</option>
				  <?php foreach($projects as $project){ ?>
                  <option value="<?php echo $project->id;?>"  <?php echo set_select('project_id',$project->id);?> ><?php echo $project->project_name;?></option>
				  <?php } ?>
               </select>
               <span class="error"><?php echo form_error('project_id'); ?> </span> 
            </div>
         </div>
         <div class="form-group">
            <label class="col-md-2 control-label">Task <span class="mandatory">*</span></label>
            <div class="col-md-9">
               <input type="text" placeholder="Task" class="form-control" name="task" value="<?php echo set_value('task');?>" > <span class="error"><?php echo form_error('task'); ?> </span>
            </div>
         </div>
          <div class="form-group">
            <label class="col-md-2 control-label">Assigned <span class="mandatory">*</span></label>
            <div class="col-md-9">
               <select class="form-control" name="user_id" >
			      <option value="">Select </option>
				  <?php foreach($users as $user){ ?>
                  <option value="<?php echo $user->user_id;?>"  <?php echo set_select('user',$user->user_id);?> ><?php echo $user->first_name.' '.$user->last_name;?></option>
				  <?php } ?>
               </select>
               <span class="error"><?php echo form_error('user_id'); ?> </span> 
            </div>
         </div>
        
      
        
        

         <br>
         <div class="form-actions fluid">
            <div class="col-md-offset-2 col-md-10">
               <button  class="btn btn-primary" type="submit">Submit</button>
               <a class="btn btn-danger" href="<?php echo base_url()?>backend/attribute/index">
               Cancel</a>
            </div>
         </div>
      </form>
      <!-- END FORM--> 
   </div>
</div>
<link rel="stylesheet" type="text/css" href="<?php echo BACKEND_THEME_URL ?>/css/jquery.multiselect.css">
<script type="text/javascript" src="<?php echo BACKEND_THEME_URL ?>/js/jquery.multiselect.js"></script>
<script>
     $(function () {
        $('.multiselect').multiselect({
        //    columns: 3,
            placeholder: 'Select States',
            search: true,
            searchOptions: {
                'default': 'Search States'
            },
            selectAll: true
        });

    });
   $(document).ready(function(){
    var max_fields_limit      = 10; //set limit for maximum input fields
       var x = 1; //initialize counter for text box
       $('.add_more_button').click(function(e){ //click event on add more fields button having class add_more_button
           e.preventDefault();
               x++; //counter increment
               $('.input_fields_container').append('<div class="form-group"><label class="col-md-2 control-label">Attribute Value <span class="mandatory">*</span></label><div class="input-group col-md-9"><input autocomplete="off" class="input form-control" placeholder="Attribute Value"  name="attribute_value[]" type="text"><div class="input-group-addon"><a href="javatpoint:void(0)" class="remove_field" style="margin-left:10px;">Remove</a></div></div></div>'); //add input field
           
       });  
       $('.input_fields_container').on("click",".remove_field", function(e){ //user click on remove text links
           e.preventDefault(); $(this).parents('div.form-group').remove(); x--;
       });
   
   $('#file_type').change(function() {
    $('#read_only').show();
    $('.section').hide();
    if($(this).val()==1 || $(this).val()==2 || $(this).val()==8)
    {
      $('.section-show'+$(this).val()).show();
    }else if($(this).val()==6){
      $('#read_only').hide();
    }else if($(this).val()==9){
      $('.section-show'+$(this).val()).show();
      $('.section-show-all').show();
    }else{
      $('.section-show-all').show();
      $('#read_only').hide();
    }
      });
   });
   
</script>