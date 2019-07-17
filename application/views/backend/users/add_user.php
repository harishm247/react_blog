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
      <li><a href="<?php echo base_url('backend/users'); ?>">Users </a></li>
      <li><b>Add User</b></li>
   </ul>
</div>


<div class="col-sm-12">
   <div class="panel-body">
      <form role="form" class="form-horizontal tasi-form" action="<?php echo current_url()?>" enctype="multipart/form-data" method="post">
         <?php //echo validation_errors(); ?>
         <?php echo $this->session->flashdata('msg_error');?>
         <header class="panel-heading colum"><i class="fa fa-angle-double-right"></i>User information :</header>
         <br>
		
         <div class="form-group">
            <label class="col-md-2 control-label">First Name <span class="mandatory">*</span></label>
            <div class="col-md-9">
               <input type="text" placeholder="First Name" class="form-control" name="first_name" value="<?php echo set_value('first_name');?>" > <span class="error"><?php echo form_error('first_name'); ?> </span>
            </div>
         </div> 
		 <div class="form-group">
            <label class="col-md-2 control-label">Last Name <span class="mandatory">*</span></label>
            <div class="col-md-9">
               <input type="text" placeholder="Last Name" class="form-control" name="last_name" value="<?php echo set_value('last_name');?>" > <span class="error"><?php echo form_error('last_name'); ?> </span>
            </div>
         </div>
		<!-- <div class="form-group">
            <label class="col-md-2 control-label">Mobile <span class="mandatory">*</span></label>
            <div class="col-md-9">
               <input type="text" placeholder="Mobile" class="form-control" name="mobile" value="<?php echo set_value('mobile');?>" > <span class="error"><?php echo form_error('mobile'); ?> </span>
            </div>
         </div>-->
		 <div class="form-group">
            <label class="col-md-2 control-label">Email <span class="mandatory">*</span></label>
            <div class="col-md-9">
               <input type="text" placeholder="Last Name" class="form-control" name="email" value="<?php echo set_value('email');?>" > <span class="error"><?php echo form_error('email'); ?> </span>
            </div>
         </div>
		
		 
		 
            
      
        
        

         <br>
         <div class="form-actions fluid">
            <div class="col-md-offset-2 col-md-10">
               <button  class="btn btn-primary" type="submit">Submit</button>
               <a class="btn btn-danger" href="<?php echo base_url()?>backend/users">
               Cancel</a>
            </div>
         </div>
      </form>
      <!-- END FORM--> 
   </div>
</div>
<!--<link rel="stylesheet" type="text/css" href="<?php echo BACKEND_THEME_URL ?>/css/jquery.multiselect.css">
<script type="text/javascript" src="<?php echo BACKEND_THEME_URL ?>/js/jquery.multiselect.js"></script>-->
<link   href="<?php echo base_url();?>assets/css/chosen.min.css" rel="stylesheet">
<script src="<?php  echo base_url();?>assets/js/chosen.jquery.min.js"></script>
<script type="text/javascript">
$(".chosen-select").chosen();
</script>
<script>
     /*$(function () {
        $('.multiselect').multiselect({
        //    columns: 3,
            placeholder: 'Select States',
            search: true,
            searchOptions: {
                'default': 'Search States'
            },
            selectAll: true
        });

    });*/
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