<div class="bread_parent">
   <div class="col-md-9">
      <ul class="breadcrumb">
         <li><a href="<?php echo base_url('backend/superadmin/dashboard');?>"><i class="icon-home"></i> Dashboard  </a></li>
         <li><a href="javascript:;"><b>List Of Blog Articles</b> </a></li>
      </ul>
   </div>
  <div class="col-md-3">
      <div class="btn-group pull-right">
      <a class="btn btn-primary tooltips add_task" href="<?php echo base_url();?>backend/superadmin/dashboard/<?php //echo $_GET['user_id'];?>" rel="tooltip" data-placement="top" data-original-title=" Click to go back "><i class="icon-plus"></i> Back
         </a>
      </div>
   </div>
   <div class="clearfix"></div>
</div>
<div class="panel-body no-padding-top">
   <header class="tabel-head-section">
  <?php ?>
      <form action="<?php echo base_url('backend/blogs/all_users_blog') ?>" method="get" role="form" class="form-horizontal">
        
        
        <input type="text" name="type" id="type" value="<?= (!empty($_GET['type'])) ? $_GET['type'] : 0; ?>">
         <div class="no-padding-top">
            <table class="responsive table_head" cellpadding="5">          
               <thead>
                  <tr>
                    <th>Blog Title</th>
                    <th>Users</th>
                     <th>Status</th>           
					           <th>Admin Status</th> 					 
                     <th>Sort By</th>
                     <th></th>
                  </tr>
               </thead>
            <tbody>
               <tr>
               <td>
                  <div class="">  
                   <input type="text" placeholder="Blog Title" class="form-control" name="blog_title" value="<?php if(!empty($_GET['blog_title'])) echo $_GET['blog_title']; ?>">
					        </div> 
               </td>
               <td>
                 <div class="">     
                    <select name="user_id" class="form-control">
                        <option value="">Select</option> 
                        <?php foreach($usersData as $users):
                          if(!$users['user_role']==0):
                          ?>                 
                        <option value="<?php echo $users['user_id']; ?>"><?php echo ucfirst($users['first_name']." ".$users['last_name']); endif; ?></option> 
                        <?php $i++; endforeach; ?>
                    </select>
                  </div>   
               </td>
			         <td>
      			      <div class="">              
                   <select name="status" class="form-control">
                        <option value="">Select</option>                  
                        <option value="1" <?php if(isset($_GET['status']) && $_GET['status']=='1') echo 'selected'; ?>>Active</option> 
                        <option value="0" <?php if(isset($_GET['status']) && $_GET['status']=='0') echo 'selected'; ?>>Inactive</option> 
                   </select>
                  </div>   
      			   </td>
                <td>
                  <div class="">              
                     <select name="approved_by_admin" class="form-control">
                          <option value="">Select</option>                  
                          <option value="1" <?php if(isset($_GET['approved_by_admin']) && $_GET['approved_by_admin']=='1') echo 'selected'; ?>>Approved</option> 
                          <option value="0" <?php if(isset($_GET['approved_by_admin']) && $_GET['approved_by_admin']=='0') echo 'selected'; ?>>Unapproved</option> 
                     </select>
                  </div>   
                </td>
                <td>
                  <div class="">              
                     <select name="order" class="form-control">                  
                          <option value="DESC" <?php if(!empty($_GET['order']) && $_GET['order']=='DESC') echo 'selected'; ?>>Sort by New</option> 
                          <option value="ASC" <?php if(!empty($_GET['order']) && $_GET['order']=='ASC') echo 'selected'; ?>>Sort by Old</option> 
                     </select>
                  </div>     
               </td>
               <td width="110"> 
                  <button class="btn btn-primary tooltips" rel="tooltip" data-placement="top" data-original-title="Search" type="submit"><i class="icon icon-search"></i></button>

                  <a class="btn btn-danger tooltips" rel="tooltip" data-placement="top" data-original-title="Reset your blogs search" type="submit" href="<?php echo base_url('backend/users/blog/') //.$_GET["user_id"] ?>"> <i class="icon icon-refresh"></i></a>
               </td>
               </tr> 
              </tbody>
            </table>
         </div>
      </form>
   </header>   
   <div class="adv-table" id="tab1">
      <table id="datatable_example" class="table-bordered responsive table table-striped table-hover">
         <thead class="thead_color">
            <tr>
               <th class="jv no_sort" width="8%">S.No
               </th>
               <th>Cover Photo</th>
               <th>Title</th>
               <th>Article Type</th>
               <th>URL</th>
			         
			         <th>Created</th>
               <th>Updated</th>
               <th>Status</th>
             <th width="7%">Actions</th>
            </tr>
         </thead>
         <tbody>
            <?php
			         if(!empty($blogs)):
               $i=0; foreach($blogs as $row){ $i++;
            ?>
            <tr>
               <td><?php echo $offset+$i ?>
               </td>
               <td><?php if(!empty($row->cover_photo_thumbnail))echo '<img src="'.base_url().$row->cover_photo_thumbnail.'" width="100" height="70">'; ?></td>
			         <td><?php echo $row->blog_title ?></td>
			         <td><?php echo  $row->type ?></td>
               <td><a href="<?php echo $row->url ?>">Click Here</a></td>
      			   <td><?php  echo date('d-m-Y',strtotime($row->created));?> </td>
      			   <td><?php  echo date('d-m-Y',strtotime($row->updated));?> </td>
               <td> <div class="btn-group">
                    <button data-toggle="dropdown" type="button" 
                    <?php if($row->status==1){ ?>
                            class="btn btn-success btn-xs dropdown-toggle">Active
                    <?php }if($row->status==0){ ?>
                           class="btn btn-warning btn-xs dropdown-toggle">Deactive 
                    <?php }if($row->status==2){ ?>
                           class="btn btn-info btn-xs dropdown-toggle">Deleted 
                    <?php }  ?>
                    </button>
                </div></td>
               <td>
                <div class="btn-group">
                <button data-toggle="dropdown" type="button" 
                    <?php if($row->approved_by_admin==1){ ?>
                            class="btn btn-success btn-xs dropdown-toggle">Approved
                     <?php } else{ ?> 
                      class="btn btn-warning btn-xs dropdown-toggle">Not Approved
                     <?php }     ?>
                  <span class="caret"></span>
                  </button> 
                   <ul role="menu" class="dropdown-menu">
                      <li><a href="<?php echo base_url('backend/blogs/change_approve/'.$row->blog_id.'/1/')?>" > Approved</a> </li>
                      <li><a href="<?php echo base_url('backend/blogs/change_approve/'.$row->blog_id.'/0/')?>" > Not Approved</a> </li>  
                   </ul>
                   </div> 
                </td>
            </tr>
            <?php } ?>
            <?php else: ?>
            <tr>
               <th colspan="9">
                  <center>No Blog Articles Available.</center>
               </th>
            </tr>
            <?php endif; ?>
         </tbody>
         <?php if(!empty($videos)): ?>
         <tfoot>
         <tr>
         <td colspan="4"></td>  
         <td>
          <input class="custom-save btn btn-primary" onclick='$("#custon-form").click();' type="submit" value="Update" style="width: 100%;">
       </td>
         <td colspan="2"></td>
         </tr>
         </tfoot>
           <?php endif;  ?>
      </table>
      <div class="row-fluid  control-group mt15">
         <div class="span12 pull-right">
            <?php if(!empty($pagination))  echo $pagination;?>
         </div>
      </div>
   </div>
   <!-- End .content -->
</div>


  <link rel="stylesheet" type="text/css" href="<?php echo BACKEND_THEME_URL ?>/css/jquery.multiselect.css">
<script type="text/javascript" src="<?php echo BACKEND_THEME_URL ?>/js/jquery.multiselect.js"></script>
<style>
.status{
	text-align: center;
    padding: 2px 0;
	color:#fff;
}
</style>
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
          if(new_status==0){
           var action_name = 'Inactive';
               action='status';
          }else if(new_status==1){
           var action_name = 'Active';
                action='status';
          }else if(new_status==2){
           var action_name = 'Approved';
            action='approve';
          }else if(new_status==3){
           var action_name = 'Not Approved';
          }else{
            return false;
          }


         if($("input:checkbox[name='checkstatus[]']").is(':checked')){    

            swal({
                title: "Do you want to "+action_name+" it!",
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

                  var tb_name  = "<?php echo base64_encode('fh_blog_articles'); ?>"; 
                  var col_name = "<?php echo base64_encode('blog_id'); ?>";     
                 
				 if(new_status == 3){ change_status=0;url ='<?php echo base_url() ?>'+'backend/blogs/change_all_status';}
				 else url ='<?php echo base_url() ?>'+'backend/blogs/change_all_status';
				  
                  $.post(url, {'table_name': tb_name, 'col_name': col_name, 'status': new_status, 'row_id': row_id}, function(data) {            
                     if(data.status==true){  
                        $(location).attr('href', '<?php echo base_url('backend/blogs/index')?>');
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

<script>
$('select #user_id').change(function(){
	$('#assign_task input[name="user_id"]').val($(this).val());
	
});


</script>