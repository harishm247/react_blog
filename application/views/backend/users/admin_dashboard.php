<div >
  <section class="panel">

    <ul class="breadcrumb">
   <li><i class="icon-home"></i><b> Dashboard </b></li>
</ul>
<header class="panel-heading">
   Hello <?php echo ucwords(superadmin_details()); ?>, Welcome to the admin section of  Flowhaus  <i class="icon-smile"></i>
</header>
<div class="panel-body latest_user">
   <!--========================Written by prem for Admin Info ===================-->
   <div class="col-md-8">
      <div class="board-block board-block-success">
         <div class="block-header">
            <!-- <a href="<?php echo base_url(); ?>backend/users"> -->
               <h3 class="chart-tittle">
                  New Users 
               </h3>
            <!-- </a> -->
            <a href="<?php echo base_url(); ?>backend/users" class="badge block-badge pull-right block-toggle-btn">View All</a>
         </div>
         <div class="clearfix"></div>
         <section class="panel in" id="collapseExample14">
            <div class="table-height-warp0">
              <table id="datatable_example" class="table-bordered responsive table table-striped table-hover">
                <thead class="thead_color">
                <tr>
                  <th>Name</th>
                   <th>Email</th>
                   <th><i class="fa fa-calendar"></i> Created Date</th>
                   <th>Actions</th>
                </tr>
                </thead>
                 <tbody>
                <?php
                   if(!empty($users)):
                   $i=0; foreach($users as $row){ $i++;
                ?>
                 <?php foreach($influenceusers as $id ): 
                    if($id->user_id==$row->user_id){
                      $type = '?user_type=2';
                    }
                    else{
                       $type = '?user_type=1';
                    }
                    endforeach; ?>
                <tr>
                   <td>
                    <a href="<?php echo base_url();?>backend/users/edit_user/<?php echo $row->user_id.$type;?>"><?php $first_name = ucfirst($row->first_name); $last_name = ucfirst($row->last_name);echo $first_name.' '.$last_name ?></a></td>
                    <td><?php echo $row->email ?></td>
                   
                   
                   <td><?php echo date('d M Y, h:i A',strtotime($row->created));?></td>
                   <td class="vd-icons">

                    <a href="<?php echo base_url().'backend/users/edit_user/'.$row->user_id.$type;?>" class="btn btn-primary btn-xs tooltips" rel="tooltip" data-placement="top" data-original-title=" View <?php //echo ucwords($row->name); ?>"><i class="fa fa-eye"></i>
                      </a>
                   
                      <a href="javascript:void(0);" onclick="return confirmBox('Are you sure you want to delete it ?','<?php echo base_url().'backend/common/delete/users/user_id/'.$row->user_id?>')" class="btn btn-danger btn-xs tooltips" rel="tooltip" data-placement="top" data-original-title="Delete  <?php //echo ucwords($row->name); ?>" onclick="if(confirm('Are you sure you want to delete it ?')){return true;} else {return false;}"><i class="icon-trash "></i>
                      </a>
                   </td>
                </tr>
                <?php } ?>
                <?php else: ?>
                <tr>
                   <th colspan="9">
                      <center>No User Available.</center>
                   </th>
                </tr>
                <?php endif; ?>
             </tbody>
            </table>  
          </div>
         </section>
      </div>
   </div>
   <div class="col-md-4">
      <div class="report-section">
         <!--daily report-->
         <div class="col-md-12">
            <div class="info-box info-warning">
               <span class="info-box-icon"><i class="fa fa-user"></i></span>
               <div class="info-box-content">
                  <span class="info-box-text">Total Influencer</span>
                  <div class="info-box-number"><span><?php echo $infludata ?></span>
                  </div>
                  <div class="progress">
                     <div class="progress-bar" style="width: 30%"></div>
                  </div>
               </div>
               <!-- /.info-box-content -->
            </div>
         </div>
         <!--Weekly report-->
         <div class="col-md-12">
            <div class="info-box info-success">
               <span class="info-box-icon"><i class="fa fa-user"></i></span>
               <div class="info-box-content">
                  <span class="info-box-text">Total Users</span>
                  <div class="info-box-number"><span><?=$totlaUser?></span>
                   <!--   <span class="total-number-order pull-right">
                     Total Orders <b>
                     35</b>
                     </span> -->
                  </div>
                  <div class="progress">
                     <div class="progress-bar" style="width: 30%"></div>
                  </div>
               </div>
               <!-- /.info-box-content -->
            </div>
         </div>
      </div>
   </div>
    <div class="clearfix"></div>
 </div>
</section> 
<div class="panel-body"> 
  <div class="adv-table">
      <div class="col-lg-3">
         <div class="board-block board-block-info">
            <div class="block-header">
               <h3 class="chart-tittle">
                  <a href="<?php echo base_url();?>backend/all_users_blog/">Blog Articles </a>
               </h3>
               <span class="pull-right badge block-badge">
               <a class="count_number" href="<?php echo base_url();?>backend/all_users_blog/">
               <?php echo $approve_by_admin_blog +  $unapprove_by_admin_blog + $pending_by_admin_blog ?></a></span>
            </div>
            <section class="panel in" id="collapseExample6">
               <table class="table table-hover personal-task">
                  <tbody>
                       <tr>
                        <td>
                           <i class="fa fa-thumbs-up"></i>
                        </td>
                        <td><a href="<?php echo base_url();?>backend/all_users_blog/?approved_by_admin=1">Approved</a></td>
                        <td><a href="<?php echo base_url();?>backend/all_users_blog/?approved_by_admin=1"><?php echo $approve_by_admin_blog; ?></a></td>
                     </tr>
                     <tr>
                        <td>
                           <i class="icon-thumbs-down"></i>
                        </td>
                        <td><a href="<?php echo base_url();?>backend/all_users_blog/?approved_by_admin=0">Unapproved</a></td>
                        <td><a href="<?php echo base_url();?>backend/all_users_blog/?approved_by_admin=0"><?php echo $unapprove_by_admin_blog; ?></a></td>
                     </tr>   
                     <tr>
                        <td>
                           <i class="fa fa-clock-o"></i>
                        </td>
                        <td><a href="<?php echo base_url();?>backend/all_users_blog/?approved_by_admin=3">Pending</a></td>
                        <td><a href="<?php echo base_url();?>backend/all_users_blog/?approved_by_admin=3"><?php echo $pending_by_admin_blog; ?></a></td>
                     </tr>                  
                  </tbody>
               </table>
            </section>
         </div>
      </div>
          <div class="col-lg-3">
         <div class="board-block board-block-danger">
            <div class="block-header">
               <h3 class="chart-tittle">
                   <a href="<?php echo base_url();?>backend/videos/">My Videos</a>
               </h3>
               <span class=" pull-right badge block-badge">
                  <a class="count_number" href="<?php echo base_url();?>backend/videos/">
               <?php echo $approve_by_admin_video + $unapprove_by_admin_video +  $pending_by_admin_video;  ?></a></span>
               <a data-toggle="collapse" href="#collapseExample6" aria-expanded="false" aria-controls="collapseExample6" class="block-toggle-btn pull-right"></span></a>
            </div>
            <section class="panel in" id="collapseExample6">
               <table class="table table-hover personal-task">
                  <tbody>
                     <tr>
                        <td>
                           <i class="fa fa-thumbs-up"></i>
                        </td>
                        <td><a href="<?php echo base_url();?>backend/videos/?adminapproved=1">Approved</a></td>
                        <td><a href="<?php echo base_url();?>backend/videos/?adminapproved=1"><?php echo $approve_by_admin_video; ?></a></td>
                     </tr>
                     <tr>
                        <td>
                           <i class="icon-thumbs-down"></i>
                        </td>
                        <td><a href="<?php echo base_url();?>backend/videos/?adminapproved=0">Unpproved</a></td>
                        <td><a href="<?php echo base_url();?>backend/videos/?adminapproved=0"><?php echo $unapprove_by_admin_video; ?></a></td>
                     </tr>
                     <tr>
                        <td>
                          <i class="fa fa-clock-o"></i>
                        </td>
                        <td><a href="<?php echo base_url();?>backend/videos/?adminapproved=3">Pending</a></td>
                        <td><a href="<?php echo base_url();?>backend/videos/?adminapproved=1"><?php echo $pending_by_admin_video; ?></a></td>
                     </tr>
                  </tbody>
               </table>
            </section>
         </div>
      </div>
       <div class="col-lg-3">
         <div class="board-block board-block-success">
            <div class="block-header">
               <h3 class="chart-tittle">
                   <a href="<?php echo base_url();?>backend/shops/">My Shop</a>
               </h3>
               <span class=" pull-right badge block-badge">
                <a class="count_number" href="<?php echo base_url();?>backend/shops/">
               <?php echo $approve_by_admin_shop + $unapprove_by_admin_shop + $pending_by_admin_shop;  ?></a></span>
               <a data-toggle="collapse" href="#collapseExample6" aria-expanded="false" aria-controls="collapseExample6" class="block-toggle-btn pull-right"></a>
            </div>
            <section class="panel in" id="collapseExample6">
               <table class="table table-hover personal-task">
                  <tbody>
                        <td>
                           <i class="fa fa-thumbs-up"></i>
                        </td>
                        <td><a href="<?php echo base_url();?>backend/shops/?adminapproved=1">Approved</a></td>
                        <td><a href="<?php echo base_url();?>backend/shops/?adminapproved=1"><?php echo $approve_by_admin_shop; ?></a></td>
                     </tr>
                     <tr>
                        <td>
                           <i class="icon-thumbs-down"></i>
                        </td>
                        <td><a href="<?php echo base_url();?>backend/shops/?adminapproved=0">Unpproved</a></td>
                        <td><a href="<?php echo base_url();?>backend/shops/?adminapproved=0"><?php echo $unapprove_by_admin_shop; ?></a></td>
                     </tr>
                     <tr>
                        <td>
                           <i class="fa fa-clock-o"></i>
                        </td>
                        <td><a href="<?php echo base_url();?>backend/shops/?adminapproved=3">Pending</a></td>
                        <td><a href="<?php echo base_url();?>backend/shops/?adminapproved=3"><?php echo $pending_by_admin_shop; ?></a></td>
                     </tr>
                     
                  </tbody>
               </table>
            </section>
         </div>
      </div>
       <div class="col-lg-3">
         <div class="board-block board-block-warning">
            <div class="block-header">
               <h3 class="chart-tittle">
                   <a href="<?php echo base_url();?>backend/upcoming_trips/">My Upcoming Trips</a>
               </h3>
               <span class=" pull-right badge block-badge">
                <a class="count_number" href="<?php echo base_url();?>backend/upcoming_trips/">
               <?php echo $approve_by_admin_trips +  $unapprove_by_admin_trips +  $pending_by_admin_trips;  ?></a></span>
               <a data-toggle="collapse" href="#collapseExample6" aria-expanded="false" aria-controls="collapseExample6" class="block-toggle-btn pull-right"></a>
            </div>
            <section class="panel in" id="collapseExample6">
               <table class="table table-hover personal-task">
                  <tbody>
                     <tr>
                        <td>
                           <i class="fa fa-thumbs-up"></i>
                        </td>
                        <td><a href="<?php echo base_url();?>backend/upcoming_trips/?adminapproved=1">Aprroved</a></td>
                        <td><a href="<?php echo base_url();?>backend/upcoming_trips/?adminapproved=1"><?php echo $approve_by_admin_trips; ?></a></td>
                     </tr>
                     <tr>
                        <td>
                           <i class="icon-thumbs-down"></i>
                        </td>
                        <td><a href="<?php echo base_url();?>backend/upcoming_trips/?adminapproved=0">Unaprroved</td>
                        <td><?php echo $unapprove_by_admin_trips; ?></td>
                     </tr>
                     <tr>
                        <td>
                           <i class="fa fa-clock-o"></i>
                        </td>
                        <td><a href="<?php echo base_url();?>backend/upcoming_trips/?adminapproved=3">Pending</a></td>
                        <td><a href="<?php echo base_url();?>backend/upcoming_trips/?adminapproved=3"><?php echo $pending_by_admin_trips; ?></a></td>
                     </tr>
                     
                  </tbody>
               </table>
            </section>
         </div>
      </div>
      <!------------->
        <div class="col-lg-3">
         <div class="board-block board-block-info">
            <div class="block-header">
               <h3 class="chart-tittle">
                   <a href="<?php echo base_url();?>backend/favorite_destinations/">Favorite Destinations </a>
               </h3>
               <span class=" pull-right badge block-badge">
                <a class="count_number" href="<?php echo base_url();?>backend/favorite_destinations/"> 
               <?php echo $approve_by_admin_desti +  $unapprove_by_admin_desti + $pending_by_admin_desti ?></a></span>
               <a data-toggle="collapse" href="#collapseExample6" aria-expanded="false" aria-controls="collapseExample6" class="block-toggle-btn pull-right"></a>
            </div>
            <section class="panel in" id="collapseExample6">
               <table class="table table-hover personal-task">
                  <tbody>
                     <tr>
                        <td>
                           <i class="fa fa-thumbs-up"></i>
                        </td>
                        <td><a href="<?php echo base_url();?>backend/favorite_destinations/?adminapproved=1">Approved</a></td>
                        <td><a href="<?php echo base_url();?>backend/favorite_destinations/?adminapproved=1"><?php echo $approve_by_admin_desti; ?></a></td>
                     </tr>
                     <tr>
                        <td>
                           <i class="icon-thumbs-down"></i>
                        </td>
                        <td><a href="<?php echo base_url();?>backend/favorite_destinations/?adminapproved=0">Unapproved</a></td>
                        <td><a href="<?php echo base_url();?>backend/favorite_destinations/?adminapproved=0"><?php echo $unapprove_by_admin_desti; ?></a></td>
                     </tr>
                     <tr>
                        <td>
                           <i class="fa fa-clock-o"></i>
                        </td>
                        <td><a href="<?php echo base_url();?>backend/favorite_destinations/?adminapproved=3">Pending</a></td>
                        <td><a href="<?php echo base_url();?>backend/favorite_destinations/?adminapproved=3"><?php echo $pending_by_admin_desti; ?></a></td>
                     </tr>
                     
                  </tbody>
               </table>
            </section>
         </div>
      </div>
        <div class="col-lg-3">
         <div class="board-block board-block-danger">
            <div class="block-header">
               <h3 class="chart-tittle">
                   <a href="<?php echo base_url();?>backend/favorite_incredible_places/">Favorite Incredible Places</a> 
               </h3>
               <span class=" pull-right badge block-badge">
                <a class="count_number" href="<?php echo base_url();?>backend/favorite_incredible_places/">
               <?php echo $approve_by_admin_incre +  $unapprove_by_admin_incre  +  $pending_by_admin_incre;  ?></a></span>
               <a data-toggle="collapse" href="#collapseExample6" aria-expanded="false" aria-controls="collapseExample6" class="block-toggle-btn pull-right"></span></a>
            </div>
            <section class="panel in" id="collapseExample6">
               <table class="table table-hover personal-task">
                  <tbody>
                     <tr>
                        <td>
                           <i class="fa fa-thumbs-up"></i>
                        </td>
                        <td><a href="<?php echo base_url();?>backend/favorite_incredible_places/?adminapproved=1">Approved</a></td>
                        <td><a href="<?php echo base_url();?>backend/favorite_incredible_places/?adminapproved=1"><?php echo $approve_by_admin_incre; ?></a></td>
                     </tr>
                     <tr>
                        <td>
                           <i class="icon-thumbs-down"></i>
                        </td>
                        <td><a href="<?php echo base_url();?>backend/favorite_incredible_places/?adminapproved=0">Unpproved</a></td>
                        <td><a href="<?php echo base_url();?>backend/favorite_incredible_places/?adminapproved=0"><?php echo $unapprove_by_admin_incre; ?></a></td>
                     </tr>
                     <tr>
                        <td>
                           <i class="fa fa-clock-o"></i>
                        </td>
                        <td><a href="<?php echo base_url();?>backend/favorite_incredible_places/?adminapproved=3">Pending</td>
                        <td><a href="<?php echo base_url();?>backend/favorite_incredible_places/?adminapproved=3"><?php echo $pending_by_admin_incre; ?></a></td>
                     </tr>
                     
                  </tbody>
               </table>
            </section>
         </div>
      </div>
 </div>
<div class="clearfix"></div>

      <!-- END FORM--> 
   </div>
</div>
<link   href="<?php echo base_url();?>assets/css/chosen.min.css" rel="stylesheet">
<script src="<?php  echo base_url();?>assets/js/chosen.jquery.min.js"></script>
<script type="text/javascript">
$(".chosen-select").chosen();
</script>
<script>
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
<style type="text/css">
   hr.style1{
   border:none;
   border-left:1px solid hsla(200, 10%, 50%,100);
   height:100vh;
   width:1px;
   }
.latest_user_heading{
  text-align: center;
  font-weight: 800;
  margin-top: 0px;
  margin-bottom: 17px;
  }
  .my.custom.class {
    margin-bottom: 35px;
}
.panel-body {
   background-color: #ecf0f5;
}
.personal-task tbody tr td{
  padding: 3px !important;
}
td.vd-icons i {
    font-size: 12px !important;
}
.count_number{
  color: #fff !important;
  transform: none !important ;
}
</style>