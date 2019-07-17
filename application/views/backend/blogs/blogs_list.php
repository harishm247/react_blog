<div class="bread_parent">
   <div class="col-md-9">
      <ul class="breadcrumb">
         <li><a href="<?php echo base_url('backend/superadmin/dashboard');?>"><i class="icon-home"></i> Dashboard  </a></li>
         <li><b>Articles</b></li>
      </ul>
   </div> 
   <div class="clearfix"></div>
</div>
<div class="panel-body no-padding-top">
   <header class="tabel-head-section">
  <?php ?>
      <form action="<?php echo base_url('backend/all_users_blog') ?>" method="get" role="form" class="form-horizontal">
        <div class="no-padding-top">
            <table class="responsive table_head" cellpadding="5">          
               <thead>
                  <tr>
                    <th>Username</th>
                     <th>Article Title</th>
                     <th>Article Type</th>           
                     <th>Admin Approval</th>           
                     <th>Sort By</th>
                     <th></th>
                  </tr>
               </thead>
            <tbody>
               <tr>
               <td>
               <div class="" style="position: relative;">            
                 <input type="text" placeholder="Username" id="usernameSearch" class="form-control" name="username" value="<?php if(!empty($_GET['username'])) echo $_GET['username']; ?>" autocomplete="off" >
                 <div id="suggesstion-box"></div>
                </div>   
               </td>
               <td>
                  <div class="">
                   <input type="text" placeholder="Article Title" class="form-control" name="blog_title" value="<?php if(!empty($_GET['blog_title'])) echo $_GET['blog_title']; ?>">
                  </div> 
               </td>
                <td>
                 <div class="">              
                     <select name="article_type" class="form-control">
                          <option value="">Select</option>                  
                      <?php
                         if(!empty($blogType)):
                         $i=0; foreach($blogType as $btype): $i++;
                      ?>
                          <option value="<?= $btype->blog_article_id ?>"<?php if(isset($_GET['article_type']) && $_GET['article_type']==$i) echo 'selected'; ?>><?= $btype->type ?></option> 
                      <?php endforeach; endif; ?>
                     </select>
                  </div>   
                </td>
                <td>
                 <div class="">              
                   <select name="approved_by_admin" class="form-control">
                        <option value="">All</option>                  
                        <option value="1" <?php if(isset($_GET['approved_by_admin']) && $_GET['approved_by_admin']=='1') echo 'selected'; ?>>Approved</option> 
                        <option value="0" <?php if(isset($_GET['approved_by_admin']) && $_GET['approved_by_admin']=='0') echo 'selected'; ?>>Unapproved</option>
                        <option value="3" <?php if(isset($_GET['approved_by_admin']) && $_GET['approved_by_admin']=='3') echo 'selected'; ?>>Pending</option>  
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

                  <a class="btn btn-danger tooltips" rel="tooltip" data-placement="top" data-original-title="Reset Search" type="submit" href="<?php echo base_url('backend/all_users_blog') //.$_GET["user_id"] ?>"> <i class="icon icon-refresh"></i></a>
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
                     <select class="form-control commonstatus1 order-select-status" >
                        <option value="">All</option>
                        <option value="1">Approved</option>
                        <option value="0">Unapproved</option>
                        <option value="3">Pending</option>
                        <option value="2">Delete</option>                     
                     </select>
                  </div>
               </th>
               <th>Description</th>
               <th>Order By</th>             
               <th><i class="fa fa-calendar"></i> Created/Updated Date</th>
             <th width="130px">Actions</th>
            </tr>
         </thead>
         <tbody>
          <form class="formid" action="<?php echo current_url(); ?>" method="post" >
            <input type="hidden" name="submitOrder" value="1">
            <?php
               if(!empty($blogs)):
               $i=0; foreach($blogs as $row){ $i++;
            ?>
            <tr>
               <td>              
                  <span class="checkboxli term-check">
                  <input type="checkbox" id="checkall<?php echo $i ?>" name="checkstatus[]" value="<?php echo $row->blog_id; ?>">  &nbsp;&nbsp; <?php echo $offset+$i.".";?>
                  <label class="" for="checkall<?php echo $i ?>">
                  </label>
                  </span>
               </td>
               </td>
               <td>
                <b style="font-size: 16px"><?= ucfirst($row->blog_title); ?></b>
                <div class="discription-wrap" style="margin-top: 5px">

                  <div class="discription-left">
                    
                    <?php if(!empty($row->cover_photo_thumbnail)) echo '<img src="'.base_url().$row->cover_photo_thumbnail.'" >'; ?>
                  </div>
                   <div class="discription-right">
                   <b>Username : </b><a href="<?php echo base_url() ?>backend/users/edit_user/<?php echo $row->user_id.'?user_type=2'; ?>"><?= ucfirst($row->first_name).' '. ucfirst($row->last_name); ?></a>
                  <br><b>Article Type : </b><?= ucfirst($row->type); ?>
                  <br><b>URL : </b><a class="text-ellips" href="<?php echo $row->url; ?>" target="_blank"><?php echo $row->url; ?></a>
                   </div>
                </div>
              </td>
              <!--  <td>
               </td> -->
               <input type="hidden" name="main_id[]" value="<?php echo $row->blog_id ?>">
                <td><input style="width: 58px" class="order_by" type="number" name="order_by[]" value="<?php echo $row->order_by ?>" min="0" max="10" step="any" data-placement="top" data-original-title="Delete" ></td>
               <td><p><?=  date('d M Y, h:i  A', strtotime($row->created));?></p>
                    <p><?= date('d M Y, h:i A',strtotime($row->updated));?></p>
                </td>
               <!-- <td><i class="fa fa-calendar"></i>  </td> -->
            <!--    <td> <div class="btn-group">
                    <button data-toggle="dropdown" type="button" 
                    <?php if($row->status==1){ ?>
                            class="btn btn-success btn-xs dropdown-toggle">Active
                    <?php }if($row->status==0){ ?>
                           class="btn btn-warning btn-xs dropdown-toggle">Deactive 
                    <?php }if($row->status==2){ ?>
                           class="btn btn-info btn-xs dropdown-toggle">Deleted 
                    <?php }  ?>
                    </button>
                </div></td> -->
               <td>
                <div class="btn-group">
                <button style="margin: 0 2px;" data-toggle="dropdown" type="button" 
                    <?php if($row->approved_by_admin==1){ ?>
                            class="btn btn-success btn-xs dropdown-toggle">Approved
                     <?php } else if($row->approved_by_admin==0) { ?> 
                      class="btn btn-danger btn-xs dropdown-toggle">Unapproved
                     <?php } else if($row->approved_by_admin==3) { ?>
                       class="btn btn-warning btn-xs dropdown-toggle">Pending
                     <?php } ?>
                  <span class="caret"></span>
                  </button> 
                   <ul role="menu" id="singleAction" class="dropdown-menu admin-status">
                      <?php // if($row->approved_by_admin==0){ ?>
                      <li><a data-status-val="1" data-row-id="<?php echo $row->blog_id ?>" href="#" > Approved</a></li>
                    <?php // } ?>
                     <?php //if($row->approved_by_admin==1){ ?>
                      <li><a data-status-val="0" data-row-id="<?php echo $row->blog_id ?>" href="#">Unapproved</a> </li> 
                      <?php //} ?> 
                      <li><a data-status-val="3" data-row-id="<?php echo $row->blog_id ?>" href="#">Pending</a> </li> 
                      <li><a data-status-val="2" data-row-id="<?php echo $row->blog_id ?>"  href="#" >Delete</a> </li> 
                   </ul>
                    <a href="<?php echo $row->url ?>" class="btn btn-info  link-btn btn-xs tooltips" rel="tooltip" data-placement="top" data-original-title="Click to View More" target="_blank" style="margin:0 2px;" ><i class="fa fa-link"></i>
                   </a>
                    </div>
                </td>
            </tr>
            <?php } ?>
            <?php else: 
            if(empty($_GET)){ ?>
            <tr>
               <th colspan="9">
               <center> <img src="<?php echo base_url('/assets/backend/admin/images/empty-item.png'); ?>"></center>
                  <center>No Articles Available.</center>
               </th>
            </tr>
            <?php } else{ ?>
            <tr>
               <th colspan="9">
               <!--  <center> <img src="<?php echo base_url('/assets/backend/admin/images/user.png'); ?>"></center>
                  <center>Articles are not available related to your search.</center> -->
                <center class="msg_error">
                    Your search did not match any documents.<br>
                    Suggestions:<br>
                    Make sure that all words are spelled correctly.<br>
                    Try to search by Admin Approval.<br>
                    Try to search by Article Type.<br>
                    Try to search by Sort By.<br>             
                </center>
               </th>
            </tr>
          <?php } endif; ?>
         </tbody>
         <?php if(!empty($blogs)): ?>
         <tfoot>
         <tr>
         <td colspan="2"></td>  
         <td>
          <input class="custom-save btn btn-primary tooltips" data-placement="top" data-original-title="Update Orders" onclick='$("#custon-form").click();' type="submit" value="Update" style="width: 100%;">
       </td>
         <td colspan="2"></td>
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


  <link rel="stylesheet" type="text/css" href="<?php echo BACKEND_THEME_URL ?>/css/jquery.multiselect.css">
<script type="text/javascript" src="<?php echo BACKEND_THEME_URL ?>/js/jquery.multiselect.js"></script>
<!-- One Status -->
<script type="text/javascript">
   jQuery(document).ready(function($) {
    event.preventDefault();
       jQuery(".admin-status li a").click(function(){
         var row_id=[] ;  

         var new_status=$(this).data('status-val');
         var row_id=$(this).data('row-id');
       // alert(row_id); 
          if(new_status==1){
           var action_name = 'Approve';
          }else if(new_status==0){
           var action_name = 'Unapprove';
          }else if(new_status==2){
           var action_name = 'Delete';
          }else if(new_status==3){
           var action_name = 'Pending';
          }else if(new_status==''){
          return false;
          }
          else{
            return false;
          }
     // if($("input:checkbox[name='checkstatus[]']").is(':checked')){    

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

                  
                  var tb_name  = "<?php echo 'fh_blog_articles'; ?>"; 
                  var col_name = "<?php echo 'blog_id'; ?>";     
                 
                url ='<?php echo base_url() ?>'+'backend/all_users_blog/change_all_status/';
                  $.post(
                    url, 
                    {
                     'table_name': tb_name,
                     'col_name': col_name,
                     'status': new_status,
                      'row_id': row_id
                     }, 
                     function(data) { 
                     //alert(data);           
                     if(data.status==true){ 
                       //alert("if"); 
                        $(location).attr('href', '<?php echo base_url('backend/all_users_blog/')?>');
                     }else{    
                      //alert("Else");
                        window.location.reload(true);
                        return false;
                     }
                  });

            });    
         // }else{
         //    errorMsg('Please check the checkbox');
         //    return false;
         // }
      });
  });
</script>
<!-- One Status End  -->


<!-- Single Action -->
<script type="text/javascript">
   jQuery(document).ready(function($) {

      $('body').find('#tab1').on('change','#singleAction', function(event) {   
    
         var row_id=[] ;  

         var new_status=$(this).val();
         if(new_status==''){
           return false;
          }
         if(new_status==1){
           var action_name = 'Approve';
          }else if(new_status==0){
           var action_name = 'Unapprove';
          }
          else if(new_status==2){
           var action_name = 'Delete';
          }
          else if(new_status==3){
           var action_name = 'Pending';
          }
          else{
            return false;
          }
      });
});
</script>

<!-- Single Action End  -->



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

      $('body').find('#tab1').on('change','.commonstatus1', function(event) {   
    
         var row_id=[] ;  

         var new_status=$(this).val();
         if(new_status==''){
           return false;
          }
         if(new_status==1){
           var action_name = 'Approve';
          }else if(new_status==0){
           var action_name = 'Unapprove';
          }
          else if(new_status==2){
           var action_name = 'Delete';
          }
          else if(new_status==3){
           var action_name = 'Pending';
          }
          else{
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

                  var tb_name  = "<?php echo 'fh_blog_articles'; ?>";    
                  var col_name = "<?php echo 'approved_by_admin'; ?>";
               url ='<?php echo base_url() ?>'+'backend/All_users_blog/change_all_status';
            $.post(url, 
            {
              'table_name': tb_name, 
              'col_name': col_name, 
              'status': new_status, 
              'row_id': row_id
            }, 
            function(data) 
            {        
               if(data.status==true){
                  $(location).attr('href', '<?php echo base_url('backend/All_users_blog/index')?>');
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

<script type="text/javascript">
  
    $("#usernameSearch").keyup(function () {
      var table_name  = "<?php echo 'fh_blog_articles'; ?>"; 
      //console.log(table_name);
        $.ajax({
            type: "POST",
            url :'<?php echo base_url() ?>'+'backend/Common/autosuggetion_user',
            data: {
                keyword: $("#usernameSearch").val(),
                table_name: table_name
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
tfoot tr td {
    border: 0px !important;
}
.table-bordered {
    border: 0px !important;
}
</style>