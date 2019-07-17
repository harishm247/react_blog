<div class="bread_parent">
   <div class="col-md-9">
      <ul class="breadcrumb">
         <li><a href="<?php echo base_url('backend/superadmin/dashboard');?>"><i class="icon-home"></i> Dashboard  </a></li>
         <li><b>Influencers</b></li>
      </ul>
   </div>

   <div class="clearfix"></div>
</div>
<div class="panel-body no-padding-top">
   <header class="tabel-head-section">
      <form action="<?php echo base_url('backend/users/influencer') ?>" method="get" role="form" class="form-horizontal">
         <div class="no-padding-top">
            <table class="responsive table_head" cellpadding="5">          
               <thead>
                  <tr>
                     <th>Influencer Username</th>
                     <th>Email</th>
                     <th>Status</th>  
                     <th>Sort By</th>
                     <th></th>
                  </tr>
               </thead>
            <tbody>
               <tr>
               <td> 
                 <div class="" style="position: relative;">     
                  <input type="text" name="name" id="usernameSearch" placeholder="Influencer Username" value="<?php if(isset($_GET['name']))echo $_GET['name'];?>" class="form-control" autocomplete="off">
                  <div id="suggesstion-box"></div>
                  </div> 
               </td>
                  <td> 
                  <div class="">    
                   <input type="text" name="email" placeholder="Email" value="<?php if(isset($_GET['email']))echo $_GET['email'];?>" class="form-control">
                  
                  </div> 
               </td>
               <td>
                  <div class="">              
                     <select name="status" class="form-control">                  
                          <option value="" <?php if(empty($_GET['status']) || $_GET['status']=='') echo 'selected'; ?>>--Select--</option>
                          <option value="1" <?php if(!empty($_GET['status']) && $_GET['status']=='1') echo 'selected'; ?>>Active</option> 
                          <option value="0" <?php if(!empty($_GET['status']) && $_GET['status']=='0') echo 'selected'; ?>>Deactive</option> 
                     </select>
                  </div>     
               </td>
                <td>
                  <div class="">              
                     <select name="order" class="form-control">                  
                          <option value="order_by_acs" <?php if(!empty($_GET['order']) && $_GET['order']=='order_by_acs') echo 'selected'; ?>> Arrange by ASC order </option>
                          <option value="order_by_desc" <?php if(!empty($_GET['order']) && $_GET['order']=='order_by_desc') echo 'selected'; ?>>Arrange by DESC order</option> 
                          <option value="DESC" <?php if(!empty($_GET['order']) && $_GET['order']=='DESC') echo 'selected'; ?>>Sort by New</option> 
                          <option value="ASC" <?php if(!empty($_GET['order']) && $_GET['order']=='ASC') echo 'selected'; ?>>Sort by Old</option> 
                     </select>
                  </div>     
               </td>
               <td width="110"> 
                  <button class="btn btn-primary tooltips" rel="tooltip" data-placement="top" data-original-title="Search" type="submit"><i class="icon icon-search"></i></button>
                  <a class="btn btn-danger tooltips" rel="tooltip" data-placement="top" data-original-title="Reset Search" type="submit" href="<?php echo base_url('backend/users/influencer'); ?>"> <i class="icon icon-refresh"></i></a>
               </td>
               </tr> 
              </tbody>
            </table>
         </div>
      </form>
   </header>   
   <div class="adv-table" id="tab1">
      <table id="datatable_example" class="table-bordered responsive table table-striped table-hover">
         <thead class="thead_color" style="border: 1px solid #ddd;">
            <tr>
               <th class="jv no_sort" width="8%">
                  <div class="col-md-12 no-padding-left">
                     <span class="checkboxli term-check">
                     <input type="checkbox" id="checkAll" class="" >
                     <label class="" for="checkAll"></label>
                     </span>
                     <select class="form-control commonstatus order-select-status" >
                        <option value="">All</option>
                        <option value="1">Active</option>
                        <option value="0">Deactive</option>
                        <option value="2">Delete</option>                     
                     </select>
                  </div>
               </th>
               <th>User ID</th>
               <th>Username</th>
               <th>Email</th>
               <th width="7%">Order By</th>
               <th>Status</th>
               <th><i class="fa fa-calendar"></i> Created Date</th>
               <th width="7%">Actions</th>
            </tr>
         </thead>
         <tbody>
          <form class="formid" action="<?php echo current_url(); ?>" method="post" >
            <input type="hidden" name="submitOrder" value="1">
            <?php  
               if(!empty($users)): 
               $i=0; foreach($users as $row){ $i++;
            ?><?php if(!empty($row->favorite_incredible_places_id)): ?>
            <tr>
               <td>
                  <span class="checkboxli term-check">
                  <input type="checkbox" id="checkall<?php echo $i ?>" name="checkstatus[]" value="<?php echo $row->user_id; ?>">  &nbsp;&nbsp; <?php echo $offset+$i.".";?>
                  <label class="" for="checkall<?php echo $i ?>">
                  </label>
                  </span>
               </td>

               <td>#&nbsp;<?php echo $row->user_id ?>
               </td>
                <td>
               <!--   <a href="<?php echo base_url();?>backend/users/edit_user/<?php echo $row->user_id.'?user_type=2';?>"><?php $first_name = ucfirst($row->first_name); $last_name = ucfirst($row->last_name);echo $first_name.' '.$last_name ?></a> -->
                   <a href="<?php echo base_url();?>backend/users/edit_user/<?php echo $row->user_id.'?user_type=2';?>"><?php $screen_name = ucfirst($row->screen_name); $last_name = ucfirst($row->last_name);echo $screen_name?></a>
                </td>
                <td><?php echo $row->email ?></td>
                
                 <input type="hidden" name="main_id[]" value="<?php echo $row->user_id ?>">
                <td><input style="width: 58px" class="order_by" type="number" name="order_by[]" value="<?php echo $row->order_by ?>" min="0" max="100" step="any" data-placement="top" data-original-title="Delete" ></td>

               
               <td>
                <div class="btn-group">
                    <button data-toggle="dropdown" type="button" 
                    <?php if($row->status==1){ ?>
                            class="btn btn-success btn-xs dropdown-toggle">Active
                    
                    <?php }if($row->status==0){ ?>
                           class="btn btn-warning btn-xs dropdown-toggle">Deactive 
                    <?php } if($row->status==2){ ?>
                            class="btn btn-danger btn-xs dropdown-toggle">Banned 
                    <?php } ?>
                    <span class="caret"></span>
                    </button>
                    <ul role="menu" class="dropdown-menu">
                    <?php if($row->status==0){ ?>
                      <li><a href="<?php echo base_url('backend/superadmin/change_status_users/'.$row->user_id.'/1/')?>" > Active</a> </li>
                       <?php }if($row->status==1){ ?>
                      <li><a href="<?php echo base_url('backend/superadmin/change_status_users/'.$row->user_id.'/0/')?>" > Deactive</a> </li> 
                       <?php } ?>   
                  </ul> 
                </div>
               </td>
               <td><?php echo date('d M Y,h:i  A',strtotime($row->created));?></td>
               <td>
                <a href="<?php echo base_url().'backend/users/edit_user/'.$row->user_id.'?user_type=2'?>" class="btn btn-primary btn-xs tooltips" rel="tooltip" data-placement="top" data-original-title=" View <?php //echo ucwords($row->name); ?>"><i class="fa fa-eye"></i>
                  </a>
                  <a href="javascript:void(0);" onclick="return confirmBox('Are you sure you want to delete it ?','<?php echo base_url().'backend/users/delete/users/user_id/'.$row->user_id?>')" class="btn btn-danger btn-xs tooltips" rel="tooltip" data-placement="top" data-original-title="Delete  <?php //echo ucwords($row->name); ?>" onclick="if(confirm('Are you sure you want to delete it ?')){return true;} else {return false;}"><i class="icon-trash "></i>
                  </a>
               </td>
            </tr>
            <?php endif;
             } ?>
            <?php else:
            if(empty($_GET)){ ?> 
            <tr>
               <th colspan="9">
                <center> <img src="<?php echo base_url('/assets/backend/admin/images/empty-item.png'); ?>"></center>
                  <center>No Influencer User Available.</center>
               </th>
            </tr>
            <?php } else{  ?>
              <tr>
               <th colspan="9">
                <!-- <center> <img src="<?php echo base_url('/assets/backend/admin/images/user.png'); ?>"></center>
                  <center>Influencer user's are not available related to your search.</center> -->
               <center class="msg_error">
                    Your search did not match any documents.<br>
                    Suggestions:<br>
                    Make sure that all words are spelled correctly.<br>
                    Try to search by Status.<br>
                    Try to search by Sort By.<br>             
                </center>
               </th>
            </tr>

          <?php } endif;  ?>

         </tbody>
          <?php if(!empty($users)): ?>
         <tfoot>
         <tr>
         <td colspan="4"></td>  
         <td>
          <input class="custom-save btn btn-primary tooltips" data-placement="top" data-original-title="Update Orders" onclick='$("#custon-form").click();' type="submit" value="Update" style="width: 100%;">
       </td>
         <td colspan="2"></td>
         <td></td>
         </tr>
         </tfoot>
           <?php endif;  ?>
         <!-- <input class="custom-save pull-right btn btn-primary" type="submit" name="order_by" value="Save"> -->
          </form>
      </table>
     

      <div class="row-fluid  control-group mt15">
         <div class="span12 pull-right">
            <?php if(!empty($pagination))  echo $pagination;?>
         </div>
      </div>
   </div>
   <!-- End .content -->
</div>
<script type="text/javascript">
  $("#order_by_up").click(function(){
     // console.log($(".order_by").length);
  
  $('.formid').each(

    function(index){  
     //   var input = $(this);
 alert($("input[type=text]").each(function(){

       alert($(".order_by").val());
 });
    }
);
  });

</script>
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
          }
          if(new_status==1){
           var action_name = 'Active';
          }else if(new_status==0){
           var action_name = 'Deactive';
          }else if(new_status==2){
           var action_name = 'Delete';
          }else{
            return false;
          }


         if($("input:checkbox[name='checkstatus[]']").is(':checked')){    

            swal({
                title: "Are you sure you want to "+action_name+" it?",
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

                  var tb_name = "<?php 'users'; ?>"; 
                  var col_name = "<?php echo 'user_id' ?>";     

                $.post(
                  '<?php echo base_url() ?>'+'backend/users/change_all_user_status',
                   {
                      'table_name': tb_name, 
                      'col_name': col_name, 
                      'status': new_status, 
                      'row_id': row_id
                   }, 
                   function(data) { 
                    
                      if(data.status==true){ 
                        $(location).attr('href', '<?php echo base_url('backend/users')?>');
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
<script type="text/javascript">
   $("#usernameSearch").keyup(function () {
      
        $.ajax({
            type: "POST",
            url :'<?php echo base_url() ?>'+'backend/users/influencer_user_search',
            data: {
                keyword: $("#usernameSearch").val()
            },
            //dataType: "json",
            beforeSend: function(){
                 
                },
                success: function(data){
                  if(data){
                    $("#suggesstion-box").show();
                    $("#suggesstion-box").html(data);
                    $("#usernameSearch").css("background","#FFF");
                  }else{ $("#suggesstion-box").hide();} 

                }
        });
    });
function selectCountry(val) {
  $("#usernameSearch").val(val);
  $("#suggesstion-box").hide();
}
</script>
<style type="text/css">
/*.custom-save {
    position: absolute;
    top: 38px;
    left: 89%;
    padding: 6px 40px 8px 32px;
}*/
tfoot tr td {
    border: 0px !important;
}
.table-bordered {
    border: 0px !important;
}

</style>