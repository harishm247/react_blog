<div class="bread_parent">
<ul class="breadcrumb">
    <li><a href="<?php echo base_url('backend/support/dashboard');?>"><i class="icon-home"></i> Dashboard  </a></li>
     <li><a href="<?php echo base_url('backend/support/user_contactus'); ?>">Support </a></li>
    <li><a href="<?php echo base_url('backend/support/user_contactus_detail/'.$contactus->support_id); ?>"><b>Support Detail </b> </a></li>        
</ul>
</div>   
           <div class="panel-body">
              <!-- BEGIN FORM-->
             
            <div class="form-body">
              <div class="row">
                 <div class="col-md-6">
                    <div class="form-group">
                       <label class="control-label col-md-3"> Name:</label>
                       <div class="col-md-9"><?php echo $contactus->name; ?></div>
                    </div>
                 </div>
                 <!--/span-->
                 <div class="col-md-6">
                    <div class="form-group">
                       <label class="control-label col-md-3">Email:</label>
                       <div class="col-md-9"><?php echo $contactus->email; ?></div>
                    </div>
                 </div>
                 <!--/span-->
                  <!--/span-->
                 <div class="col-md-6">
                    <div class="form-group">
                       <label class="control-label col-md-3">Message:</label>
                       <div class="col-md-9"><?php echo $contactus->message; ?></div>
                    </div>
                 </div>
                 <!--/span-->

                   <!--/span-->
                 <div class="col-md-6">
                    <div class="form-group">
                       <label class="control-label col-md-3">Date:</label>
                       <div class="col-md-9"><?php echo $contactus->created; ?></div>
                    </div>
                 </div>
                 <!--/span-->

                  <!--/span-->
                 <div class="col-md-6">
                    <div class="form-group">
                       <label class="control-label col-md-3">IP address:</label>
                       <div class="col-md-9"><?php echo $contactus->user_ip; ?></div>
                    </div>
                 </div>
                 <!--/span-->
              </div>
              <!--/row-->

                 </div>
               
            
           </div>
      