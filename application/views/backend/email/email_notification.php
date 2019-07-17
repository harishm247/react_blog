<div class="bread_parent">
   <div class="col-md-9">
      <ul class="breadcrumb">
         <li><a href="<?php echo base_url('backend/superadmin/dashboard');?>"><i class="icon-home"></i> Dashboard  </a></li>
         <li><b>Support</b></li>
      </ul>
   </div>

   <div class="clearfix"></div>
</div>
<div class="panel-body no-padding-top">
  
   <div class="adv-table" id="tab1">
      <table id="datatable_example" class="table-bordered responsive table table-striped table-hover">
         <thead class="thead_color">
            <tr>
               <th class="jv no_sort" width="8%">
                  <div class="col-md-12 no-padding-left" style="width: 70px;">
                     <span class="checkboxli term-check">
                     <input type="checkbox" id="checkAll" class="" >
                     <label class="" for="checkAll"></label>
                     </span>
                     <select class="form-control commonstatus order-select-status" >
                        <option value="">All</option>
                        <option value="2">Delete</option>                     
                     </select>
                  </div>
               </th>
               <th>Name</th>
               <th>User Type</th>
               <th>Email</th>
               <th>Website</th>
               <th>Instagram Handle</th>
               <th>Message</th>
               <th><i class="fa fa-calendar"></i> Created Date</th>
               <th>Actions</th>
            </tr>
         </thead>
         <tbody>
            <?php
               if(!empty($notification)):
               $i=0; foreach($notification as $row){ $i++;
            ?>
            <tr>
               <td>
                  <span class="checkboxli term-check">
                  <input type="checkbox" id="checkall<?php echo $i ?>" name="checkstatus[]" value="<?php echo $row->id; ?>">  &nbsp;&nbsp; <?php echo $i.".";?>
                  <label class="" for="checkall<?php echo $i ?>">
                  </label>
                  </span>
               </td>

                <td>
                <?php $name = ucfirst($row->name);echo $name; ?>
                </td>
               <td><?php echo $row->user_type ?></td>
			          <td><?php echo $row->email ?></td>
			         
			         
               <td><?php if(!empty($row->website)) {echo $row->website;} else{ echo "NA"; } ;?></td>
               <td><?php echo $row->instagram_handle ?></td>
               <td><?php echo $row->message ?></td>
              
               <td><?php echo date('d M Y,h:i  A',strtotime($row->created));?></td>
               <td>
            <!--     <a href="<?php echo base_url().'backend/users/edit_user/'.$row->id?>" class="btn btn-primary btn-xs tooltips" rel="tooltip" data-placement="top" data-original-title=" View <?php //echo ucwords($row->name); ?>"><i class="fa fa-eye"></i>
                  </a> -->
                  <a href="javascript:void(0);" onclick="return confirmBox('Are you sure you want to delete it ?','<?php echo base_url().'backend/users/delete/contactus_notification/id/'.$row->id?>')" class="btn btn-danger btn-xs tooltips" rel="tooltip" data-placement="top" data-original-title="Delete  <?php //echo ucwords($row->name); ?>" onclick="if(confirm('Are you sure you want to delete it ?')){return true;} else {return false;}"><i class="icon-trash "></i>
                  </a>
                  <!-- <a href=""><i class="icon-reply email-reply"></i></a> -->
               </td>
            </tr>
            <?php } ?>
            <?php else: ?>
            <tr>
               <th colspan="9">
                <center> <img src="<?php echo base_url('/assets/backend/admin/images/empty-item.png'); ?>"></center>
                  <center>No Email Notifications Available.</center>
               </th>
            </tr>
            <?php endif; ?>
         </tbody>
      </table>
      <div class="row-fluid  control-group mt15">
         <div class="span12 pull-right">
            <?php if(!empty($pagination))  echo $pagination;?>
         </div>
      </div>
   </div>
   <!-- End .content -->
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

   jQuery(document).ready(function($) {
      $('body').find('#tab1').on('change','.commonstatus', function(event) {      
         var row_id=[] ;  

         var new_status=$(this).val();
         if(new_status==''){
            return false;
          }else if(new_status==2){
           var action_name = 'Delete';
          }else{
            return false;
          }


         if($("input:checkbox[name='checkstatus[]']").is(':checked')){    

            swal({
                title: "Are you sure you want to "+action_name+" it!",
                type: "warning",
                padding: 0,
                showCloseButton: true,
                showCancelButton: true,
                focusConfirm: false,
                background: '#f1f1f1',
                buttonsStyling: false,
                confirmButtonClass: 'btn btn-confirm',
                cancelButtonClass: 'btn btn-cancle',
                confirmButtonText: 'Ok',
                cancelButtonText: 'Cancel',
                animation: false
            }, function() {

                  var i=0;
                  $("input[type='checkbox']:checked").each(function() {
                     if($(this).val()!=''){
                        row_id[i]=$(this).val();       
                        i++; 
                     }    
                  });   

                  var tb_name = "<?php 'contactus_notification'; ?>"; 
                  var col_name = "<?php echo 'id' ?>";     

                $.post(
                  '<?php echo base_url() ?>'+'backend/Superadmin/change_all_user_status',
                   {
                      'table_name': tb_name, 
                      'col_name': col_name, 
                      'status': new_status, 
                      'row_id': row_id
                   }, 
                   function(data) { 
                    
                      if(data.status==true){ 
                        $(location).attr('href', '<?php echo base_url('backend/superadmin/email_notification')?>');
                     }else{ 
                          
                        window.location.reload(true);
                        return false;
                     }
                  });

            });    
         }else{
            errorMsg('Please check the checkbox');
            return false;
         } 

      });

   });
</script>
<style type="text/css">
  .email-reply{
    background: blue;
    color: #fff;
    padding: 3px;
  }
</style>