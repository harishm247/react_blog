<div class="col-lg-12">
   <section class="panel">
      <div class="bread_parent">
         <div class="col-md-9">
         	<ul class="breadcrumb">
         	   <li><a href="<?php echo base_url('backend/superadmin/dashboard');?>"><i class="icon-home"></i> Dashboard  </a></li>
         	   <li><b>Articles Type</b> </li>
         	</ul>
         </div>
         <div class="col-md-3">
            <div class="btn-group pull-right">
               <a class="btn btn-primary btn-toggle-link tooltips" id="add" data-original-title="Click to add article type">
               Add Articles Type
               </a>
            </div>
         </div>
         <div class="clearfix"></div>
      </div>
      <br>
      <div id="tab1">
         <div class="panel-body div_border toggle-inner-panel" id="form" style="display: none;">
            <div class="col-md-12 no-padding">
               <form role="form" class="form-horizontal tasi-form" name="frm1" id="frm1" action="<?php echo base_url(); ?>backend/All_users_blog/blog_type" enctype="multipart/form-data" method="post" id="form_valid">
                  <input type="hidden" name="type_action" value="1">
                  <div class="form-body">
                     <div class="form-group">
                        <div class="col-md-6">
                           <input type="text" id="type" placeholder="Article Type Name" class="form-control" name="type" value="" data-bvalidator="required" data-bvalidator-msg="Article Type Name">
                            <?= form_error('type');?>
                       </div>
                        
                        <div class="col-md-3" id="input_field_to_search">
                           <input type="number" id="order_by" min='1' step=any placeholder="Arrange order No" class="form-control" name="order_by" value="" data-bvalidator="number,required" data-bvalidator-msg="Arrange order No">  
                          <?= form_error('order_by');?>             
                        </div>
                       
                        <button class="btn btn-primary" value="blogTypeSubmit" name="blogTypeSubmit" type="submit"><i class="icon-plus"></i> Submit</button>
                     </div>
                  </div>
               </form>
            </div>
            <!-- END FORM--> 
         </div>
         <br>
         <!--table -->
        <span class="error text-center"><?php  echo form_error("type[]",'<p class="text-danger">','</p>'); ?></span> 
        <span class="error text-center"><?php  echo form_error("order_by[]",'<p class="text-danger">','</p>'); ?></span> 
         <div class="panel-body">
            <div class="clearfix"></div>
            <div class="adv-table">
             <table id="datatable_example" class="table-bordered responsive table table-striped table-hover">
              <thead class="thead_color">
                     <tr>
                        <th width="10%">
                           <div class="col-md-10 no-padding-left">
                              <span class="checkboxli term-check">
                              <input type="checkbox" name="checkAll" id="checkAll">
                              <label class="" for="checkAll"></label> 
                              </span>
                              <select name="commonstatus" id="commonstatus" class="form-control order-select-status">
                                 <option value="">All</option>
                                 <option value="1">Publish</option>
                                 <option value="0">Unpublish</option>
                                 <!-- <option value="5">Delete</option> -->                     
                              </select>
                           </div>
                        </th>
                        <th style="padding-left: 22px;">Article type name </th>
                        <!-- <th style="padding-left: 22px;">Article Name Label</th> -->
                        <th style="padding-left: 22px;">Order by</th>
                        <th width="8%">Status</th>
                        <th width="18%"><i class="fa fa-calendar"></i> Created Date</th>
                        <!-- <th>Actions</th> -->
                     </tr>
                  </thead>
                    <?= form_error('type');?>
                  <form action="<?php echo base_url(); ?>backend/all_users_blog/blog_type" id="update_form" name="update_form" method="post">
                     <input type="hidden" name="type_action" value="2">
                  <?php 
                  if(!empty($articleTypeData)){
                  $i=0; foreach ($articleTypeData as $articleType) {  $i++; ?>
                  <tbody>
                     <input type="hidden" name="blog_article_id[]" value="<?php echo $articleType->blog_article_id?>">
                     <tr>
                    <td>
                  <span class="checkboxli term-check">
                  <input type="checkbox" id="checkall<?php echo $i ?>" name="checkstatus[]" value="<?php echo $articleType->blog_article_id; ?>"> <label class="" for="checkall<?php echo $i ?>" ></label></span>&nbsp;&nbsp;<b><?php echo '# '.$articleType->blog_article_id;?></b>
                 </td>
                        <td>
                           <div class="col-md-8"><input class="form-control" type="text" name="type[]" id="update_type" value="<?= ucfirst($articleType->type); ?>">
                           </div>
                        </td>
                        <td>
                           <div class="col-md-6">
                              <input type="number" step=any min="1" class="form-control" name="order_by[]" id="update_order_by" value="<?= $articleType->order_by;?>" required="">
                              <input type="hidden" name="main_id[]" value="<?php echo $articleType->blog_article_id ?>">
                           </div>
                        </td>
                        <td>
                        	<?php if(!empty($articleType->status)){ ?>
                           <a class="label label-success label-mini tooltips" href="<?php echo  base_url(); ?>backend/all_users_blog/change_approve/<?= $articleType->blog_article_id ?>/0" rel="tooltip" data-placement="top" value="<?= $articleType->status ?>" data-original-title="Click to Unpublish">Publish</a> 
                           <?php }else{ ?>
                           	 <a class="label label-warning label-mini tooltips" href=" <?php echo base_url(); ?>backend/all_users_blog/change_approve/<?= $articleType->blog_article_id ?>/1" rel="tooltip" data-placement="top" value="<?= $articleType->status ?>" data-original-title="Click to Publish">Unpublish</a> 
                           <?php } ?>
                        </td>
                        <td class="to_hide_phone"><?= date('d M Y, h:i  A', strtotime($articleType->created)); ?> </td>
                     </tr>
                  </tbody>
               <?php }  ?>
                  <tbody>
                     <tr>
                        <td colspan="8"><button type="submit" class="btn btn-primary pull-right tooltips" rel="tooltip" data-placement="top" data-original-title="Update the article type and there order sequences">Update Article Type</button></td>
                     </tr>
                  </tbody>
                  <?php } ?>
                  </form>
               </table>
            </div>
         </div>
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
      </script>
      <script type="text/javascript">
         jQuery(document).ready(function($) {  
           $('#commonstatus').change(function(event) {    
           var row_id=[] ;  
           
           var new_status=$(this).val();
                       if(new_status==''){
                        return false;
                       }else if(new_status==1){
                         var action_name = 'Publish';
                         }else if(new_status==0){
                         var action_name = 'Unpublish';
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
            },function() {
              var i=0;
                $("input[type='checkbox']:checked").each(function() {
                  row_id[i]=$(this).val();       
                 i++;               
               });      
              url ='<?= base_url()?>'+'backend/All_users_blog/article_type_status';  
             var tb_name ='fh_blog_article_type';     
             $.post(url, {'table_name': tb_name,'status': new_status,'row_id': row_id}, function(data) {           
                    if(data.status==true){  
                    window.location='<?= base_url()?>'+'backend/All_users_blog/blog_type';
                  }else{      
                     window.location.reload(true);
                     return false;
                  }
                });  
                 });    
             }else{
                alert('Please Check the checkbox');
             return false;
             }  
           });
         });
         
      </script>
   </section>
   <script type="text/javascript">
     
   </script>
</div>